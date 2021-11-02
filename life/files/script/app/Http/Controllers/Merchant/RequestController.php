<?php

namespace App\Http\Controllers\Merchant;

use DB;
use PDF;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Getway;
use App\Models\Payment;
use App\Models\Userplan;
use App\Mail\PaymentMail;
use App\Jobs\SendEmailJob;
use App\Models\Usergetway;
use App\Models\Paymentmeta;
use App\Models\Requestmeta;
use Illuminate\Http\Request;
use App\Models\Currencygetway;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Request as PaymentRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class RequestController extends Controller
{
    public function invoicePdf($id)
    {
        $data = PaymentRequest::where('user_id',Auth::id())->with('requestmeta')->findOrFail($id);
        $jsonData = json_decode($data->requestmeta->value);
        $pdf = PDF::loadView('merchant.request.invoice-pdf', compact('data', 'jsonData'));
        return $pdf->download('request-invoice.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = PaymentRequest::where('user_id',Auth::id())->with('requestmeta')->latest()->paginate(20);
        return view('merchant.request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(getplandata('menual_req') == 0, 404);
        return view('merchant.request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'purpose'        => 'required',
            'amount'         => 'required',
            'amount'         => 'required',
            'captcha_status' => 'required',
            'is_test'        => 'required',
            'status'         => 'required'
        ]);

        $user_plan = Userplan::where('user_id', Auth::id())->select('id', 'daily_req', 'monthly_req')->first();
        $daily_request = PaymentRequest::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->count();
        $monthly_request = PaymentRequest::where('user_id', Auth::id())->whereMonth('created_at', Carbon::now()->month)->count();

        if ($user_plan->daily_req <= $daily_request) {
            $msg['errors']['error'] = "Daily Request Limited Exceeded!";
            return response()->json($msg, 404);
        }

        if ($user_plan->monthly_req <= $monthly_request) {
            $msg['errors']['error'] = "Monthly Request Limited Exceeded!";
            return response()->json($msg, 404);
        }

        $data = [
            'purpose' => $request->purpose,
        ];

        $requestObj = new PaymentRequest;
        $requestObj->amount = $request->amount;
        $requestObj->is_fallback = 0;
        $requestObj->user_id = Auth::id();
        $requestObj->captcha_status = $request->captcha_status;
        $requestObj->currency = $request->currency;
        $requestObj->status = $request->status;
        $requestObj->is_test = $request->is_test;
        $requestObj->save();

        $meta = new Requestmeta;
        $meta->key = 'request_info';
        $meta->request_id = $requestObj->id;
        $meta->value = json_encode($data);
        $meta->save();

        return response()->json(encrypt($requestObj->id));
    }

    public function checkoutUrl($param)
    {
        $decrypted = decrypt($param);
        $paymentRequest = PaymentRequest::where('id', $decrypted)->where('status', 1)->first();
        if (!$paymentRequest) {
            return 'Invalid URL';
        }
        Session::put('requestData', $paymentRequest);
        return redirect()->route('checkout.view');
    }

    public function checkoutView()
    {
        $requestData = Session::has('requestData') ? Session::get('requestData') : [];
        abort_if(!$requestData, 403);

        $plan = Userplan::where('user_id', $requestData['user_id'])->first();
        $usergetways = Usergetway::with('getway', 'user')->where('user_id', $requestData['user_id'])->where('status',1)->get();
        $request = PaymentRequest::with('requestmeta')->findOrFail($requestData->id);
        return view('payment.checkout', compact('requestData', 'usergetways', 'plan','request'));
    }

    public function paymentView(Request $request)
    {

        if ($request->phone_required == 1) {
            $request->validate([
                'phone' => 'required',
            ]);
        }
        if($request->image_accept == 1){
            $request->validate([
                'screenshot' => 'required|image|max:1000|mimes:jpeg,bmp,png,jpg',
                'comment' => 'required|max:200'
            ]);
        }

        $test_mode = $request->session()->has('test_mode') ? $request->session()->has('test_mode') : 1;
        // Google recaptcha validation
        if ($request->has('g-recaptcha-response')) {
            if(env('NOCAPTCHA_SECRET') != null){
                $messages = [
                    'g-recaptcha-response.required' => 'You must check the reCAPTCHA.',
                    'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
                ];
                
                $validator = Validator::make($request->all(), [
                    'g-recaptcha-response' => 'required|captcha'
                ], $messages);
                
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
            }
        }

        $user_id = $request->session()->get('requestData')['user_id'];

        $storage_limit=Userplan::where('user_id',$user_id)->pluck('storage_limit')->first();
        $storage_used = folderSize('uploads/'.$user_id);
        if ($request->hasFile('screenshot') && $storage_limit > $storage_used) {
            $logo      = $request->file('screenshot');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/'.$user_id.'/'.date('y/m/');
            $logo->move($logo_path, $logo_name);
            $payment_data['screenshot'] = $logo_path . $logo_name;
        }

        $usergateway = Usergetway::with('getway', 'user', 'currencygetway')->where([
            ['getway_id', $request->gateway_id],
            ['status', 1],
            ['user_id',$user_id],
        ])->first();

        $paymentRequest = PaymentRequest::findOrFail($request->request_id);
        $paymentRequest->status = 0; //Inactive
        $paymentRequest->ip = getIp(); //Ip Address
        $paymentRequest->save();
        $payment_data['currency'] = $usergateway->currency_name ?? $usergateway->getway->currency_name ?? 'USD';
        $payment_data['email'] = $usergateway->user->email ?? 'demo@mail.com';
        $payment_data['name'] = $usergateway->user->name ?? 'customer';
        $payment_data['phone'] = $request->phone ?? '';
        $payment_data['billName'] = 'customer payment';
        $payment_data['amount'] = $paymentRequest->amount;
        $payment_data['test_mode'] = $request->is_test ?? $test_mode ?? 1;
        $payment_data['charge'] = $usergateway->charge ?? 0;
        $payment_data['pay_amount'] = $paymentRequest->amount * $usergateway->rate + $usergateway->charge;
        $payment_data['getway_id'] = $usergateway->getway_id;
        $payment_data['user_id'] = $usergateway->user_id;
        $payment_data['request_from'] = 'customer';
        $payment_data['request_id'] = $request->request_id;
        $payment_data['payment_type'] = 1;
        $payment_data['comment'] = $request->comment ?? '';

        if ($request->is_test == 1) {
            $gateway_info = json_decode($usergateway->sandbox);
        } else {
            $gateway_info = json_decode($usergateway->production);
        }

        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            };
        }

        return $usergateway->getway->namespace::make_payment($payment_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PaymentRequest::with('requestmeta')->findOrFail($id);
        $jsonData = json_decode($data->requestmeta->value);
        return view('merchant.request.show', compact('data', 'jsonData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currencygetway = Currencygetway::with('usergetway', 'currency')->get();
        $request = PaymentRequest::where('user_id',Auth::id())->findOrFail($id);
        $request->id;
        $param = encrypt($request->id);
        return view('merchant.request.edit', compact('currencygetway', 'request', 'param'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate
        $request->validate([
            'purpose'        => 'required',
            'amount'         => 'required',
            'amount'         => 'required',
            'captcha_status' => 'required',
            'is_test'        => 'required',
            'status'         => 'required'
        ]);

        $data = [
            'purpose' => $request->purpose,
        ];

        $requestObj = PaymentRequest::where('user_id',Auth::id())->findOrFail($id);
        $requestObj->amount = $request->amount;
        $requestObj->captcha_status = $request->captcha_status;
        $requestObj->status = $request->status;
        $requestObj->is_test = $request->is_test;
        $requestObj->save();

        $meta = Requestmeta::where('request_id', $id)->first();
        $meta->value = json_encode($data);
        $meta->save();
        return response()->json('Added Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PaymentRequest::where('user_id',Auth::id())->findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Payment Request Deleted Successfully');
    }

    public function success(Request $request)
    {
        if (!session()->has('payment_info') && session()->get('payment_info')['payment_status'] != 1) {
            abort(403);
        }
        
        $screenshot = Session::get('payment_info')['screenshot'] ?? '';
        $comment = Session::get('payment_info')['comment'] ?? '';
        $data = $request->session()->get('payment_info');
        $getway = Getway::findOrFail($data['getway_id']);
        $payment = new Payment;
        $payment->request_id = $data['request_id'];
        $payment->user_id = PaymentRequest::findOrFail($data['request_id'])->user_id;
        $payment->getway_id = $data['getway_id'];
        $payment->amount = $data['amount'];
        $payment->main_amount = $data['main_amount'];
        $payment->currency = $data['currency'];
        $payment->trx_id = $data['payment_id'];
        $payment->status = ($getway->is_auto == 1 ? 1 : $data['payment_status']) ?? 2;
        $payment->save();

        if($screenshot != ''){
            $paymentmeta = new Paymentmeta;
            $paymentmeta->payment_id = $payment->id;
            $paymentmeta->key = 'payment_meta';
            $paymentmeta->value = json_encode(['screenshot' => $screenshot,'comment'=> $comment]);
            $paymentmeta->save();
        }
        Session::flash('message', 'Payment Successfull!!!');
        Session::flash('type', 'success');
        return redirect()->route('customer.payment.status');
    }

    public function failed()
    {
        Session::flash('message', 'Transaction Error Occured!!');
        Session::flash('type', 'danger');
        return redirect()->route('customer.payment.status');
    }

    public function status()
    {
        abort_if(!Session::has('payment_info') && !Session::has('customer_session'),403);
       
        if(Session::has('payment_info')){

            $payment_info=session()->get('payment_info');
            $amount = $payment_info['main_amount'] ?? 0;
            $customer_session['status']=$payment_info['status'] ?? '';
            $customer_session['request_id']=session()->get('requestData')['id'] ?? $payment_info['request_id'] ?? session()->get('api_request')['request_id'];
            $customer_session['payment_id']=$payment_info['payment_id'] ?? '';
            $customer_session['getway_id']=$payment_info['getway_id'];
            $customer_session['is_fallback']=$payment_info['is_fallback'] ?? 0; 
            $customer_session['user_id']=$payment_info['user_id'];
            $customer_session['payment_method']=$payment_info['payment_method'];
            $payment_id = $customer_session['payment_id'];
            $getway_id = $customer_session['getway_id'];
            $payment_status = $customer_session['status'];
            $status = $customer_session['status'];
            $payment_status = $status == 1 ? 'success' : ($status == 0 ? 'failed' : 'pending');
            $getway = Getway::findOrFail($getway_id) ?? '';

            if($status == 0){
                $url = session()->has('api_request') ? session()->get('api_request')['fallbackurl'] . "?getway=" . $getway->name . "&&status=" . $payment_status : '';
                if ($payment_info['is_fallback'] == 1) {
                    return redirect($url);
                }else{
                    Session::flash('message', 'Transaction Error Occured!!');
                    Session::flash('type', 'danger');
                    return view('payment.status', compact('status'));
                }
            }
            $customer_session['url']=session()->has('api_request') ? session()->get('api_request')['fallbackurl'] . "?trxid=" . $payment_id . "&&getway=" . $getway->name . "&&status=" . $payment_status : '';

            Session::put('customer_session',$customer_session);
        }
        else{
            $payment_info=session()->get('customer_session');
            $customer_session['request_id']=session()->get('requestData')['id'] ?? $payment_info['request_id'];
            $customer_session['payment_id']=$payment_info['payment_id'] ?? '';
            $customer_session['status']=$payment_info['status'] ?? '';
            $customer_session['getway_id']=$payment_info['getway_id'];
            $customer_session['is_fallback']=$payment_info['is_fallback'] ?? 0;
            $customer_session['user_id']=$payment_info['user_id'];
            $getway_id = $customer_session['getway_id'];
            $status = $customer_session['status'];
            $getway = Getway::findOrFail($getway_id) ?? '';
            $customer_session['url']=$payment_info['url'];
            $payment_id = $customer_session['payment_id'];
            $user_id = $customer_session['user_id'];
            $amount = $payment_info['main_amount'] ?? 0;
        }
        

        $req_id = $customer_session['request_id'];
        $request_meta = Requestmeta::where('request_id', $req_id)->pluck('value')->first();
        $req_info = json_decode($request_meta, true);
        
        $status = $customer_session['status'];
        $payment_status = $status == 1 ? 'success' : ($status == 0 ? 'failed' : 'pending');

        $fallback = $customer_session['is_fallback'];
        
        $payment = Payment::with('getway', 'user')->where('trx_id', $payment_id)->first() ?? '';
        $url = $customer_session['url'];

       

        // send mail
        $mailcheck = Userplan::where('user_id',$customer_session['user_id'])->first();
       
        $user = User::findOrFail($customer_session['user_id']);
        if (Session::has('payment_info')) {
            if($status == 1 && $mailcheck->mail_activity == 1){
               
                $data = [
                    'type'    => 'payment',
                    'email' => $user->email,
                    'message' => "Successfully payment " . round($amount, 2) . " (".$user->currency.") by Customer via ". strtoupper($payment_info['payment_method']) . " Transaction ID : ". $payment_info['payment_id']
                ];

                if (env('QUEUE_MAIL') == 'on') {
                    dispatch(new SendEmailJob($data));
                } else {
                    Mail::to($user->email)->send(new PaymentMail($data));
                }
            }
        }
        session()->has('payment_info') ? Session::forget('payment_info') : '';
        session()->has('api_request') ? Session::forget('api_request') : '';
        session()->has('requestData') ? Session::forget('requestData') : '';

        if ($status == 2) {
            Session::flash('message', 'Payment Pending: The request is now in pending for verification...!!');
            Session::flash('type', 'warning');
        }

        if ($fallback == 1) {
            return redirect($url);
        }

        return view('payment.status', compact('payment', 'url', 'fallback','req_info','status'));
    }

    // ==============================  Api routes =============================  //

    public function apirequest(Request $request)
    {

        $validated = $request->validate([
            'private_key' => 'required|min:50|max:50',
            'currency' => 'required|max:50',
            'is_fallback' => 'required',
            'is_test' => 'required',
            'purpose' => 'required|max:500',
            'amount' => 'required|max:100',
        ]);

        if($request->is_fallback == 1){
            $validated = $request->validate([
            'fallback_url' => 'required|max:100',
          ]);
        }

        if($request->amount <= 0){
            return response()->json('Invalid Amount',401);
        }

        $private_key = $request->private_key;
        $currency = $request->currency;


       $user = User::where('private_key', $private_key)->where('currency', $currency)->where('status', 1)->first();

        if (!$user) {
            return response()->json('Invalid Request!',401);
            
        }

        //Check if request limit exceeeded
        $user_plan = Userplan::where('user_id', $user->id)->select('id', 'daily_req', 'monthly_req')->first();
        $daily_request = PaymentRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $monthly_request = PaymentRequest::where('user_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->count();

        $daily_req = $user_plan->daily_req ?? 0;
        if ($daily_req <= $daily_request) {
            $msg['errors']['error'] = "Daily Request Limited Exceeded!";
            return response()->json($msg, 401);
        }

        $monthly_req = $user_plan->monthly_req ?? 0;
        if ($monthly_req <= $monthly_request) {
            $msg['errors']['error'] = "Monthly Request Limited Exceeded!";
            return response()->json($msg, 401);
        }

        DB::beginTransaction();
        try {
        $paymentRequest = new PaymentRequest;
        $paymentRequest->user_id = $user->id;
        $paymentRequest->amount = $request->amount;
        $paymentRequest->currency = $request->currency;
        $paymentRequest->is_fallback = $request->is_fallback;
        $paymentRequest->is_test = $request->is_test;
        $paymentRequest->ip = $request->ip();
        $paymentRequest->status = 1; //pending
        $paymentRequest->save();

        $requestMeta = new Requestmeta;
        $requestMeta->key = 'request_info';
        $requestMeta->value = json_encode(['fallback' => $request->fallback_url,'purpose'=>$request->purpose ?? '']);
        $requestMeta->request_id = $paymentRequest->id;
        $requestMeta->save();

        DB::commit();
        } catch (Exception $e) {
          DB::rollback();

          return response()->json('Opps something wrong',403);
        }

        $encrtypted_token = encrypt($paymentRequest->id);
        return response()->json(['checkout_url' => url('/customer/checkout/' . $encrtypted_token)]);
    }

    public function apiCheckoutUrl($token)
    {
        try {
            $id = decrypt($token);
        } catch (DecryptException $e) {
            return $e;
        }
       $paymentRequest = PaymentRequest::with('requestmeta')->where('status', 1)->findOrFail($id);
       // abort_if($paymentRequest->ip != getIp(), 403);
       $paymentRequest->status = 0;
       $paymentRequest->save();

        if ($paymentRequest === null) {
            return 'Invalid URL';
        }

        $info = json_decode($paymentRequest->requestmeta->value);

        $data = [
            'data'           => $info,
            'request_id'     => $paymentRequest->id,
            'amount'         => $paymentRequest->amount,
            'user_id'        => $paymentRequest->user_id,
            'is_fallback'    => $paymentRequest->is_fallback,
            'is_test'        => $paymentRequest->is_test,
            'ip'             => $paymentRequest->ip,
            'captcha_status' => $paymentRequest->captcha_status,
            'fallbackurl'    => $info->fallback,
        ];


        Session::put('api_request', $data);
        
        return redirect()->route('customer.checkout.view');
    }

    public function apiCheckoutView()
    {
        $requestData = Session::has('api_request') ? json_decode(json_encode(Session::get('api_request')), false) : '';
        abort_if(!$requestData, 403);
        $phone = Session::get('api_request')['phone'] ?? '';
        $plan = Userplan::with('user')->where('user_id', $requestData->user_id)->first();
        $usergetways = Usergetway::with('getway', 'user', 'currencygetway')->where('user_id', $requestData->user_id)->get();

        return view('api.checkout', compact('requestData', 'usergetways', 'phone', 'plan'));
    }

    public function apisuccess(Request $request)
    {

        if (!session()->has('payment_info') && session()->get('payment_info')['payment_status'] != 1) {
            abort(403);
        }
        Session::forget('customer_session');

        $screenshot = Session::get('payment_info')['screenshot'] ?? '';
        $comment = Session::get('payment_info')['comment'] ?? '';

        $data = $request->session()->get('payment_info');
        $getway = Getway::findOrFail($data['getway_id']);
        $payment = new Payment;
        $payment->request_id = $data['request_id'];
        $payment->user_id = $data['user_id'];
        $payment->getway_id = $data['getway_id'];
        $payment->amount = $data['amount'];
        $payment->main_amount = $data['main_amount'];
        $payment->currency = $data['currency'];
        $payment->trx_id = $data['payment_id'];
        $payment->status = ($getway->is_auto == 1 ? 1 : $data['payment_status']) ?? 2;
        $payment->save();

        $paymentmeta = new Paymentmeta;
        $paymentmeta->payment_id = $payment->id;
        $paymentmeta->key = 'payment_meta';
        $paymentmeta->value = json_encode(['screenshot' => $screenshot, 'comment' => $comment]);
        $paymentmeta->save();

        Session::flash('message', 'Payment Successfull!!!');
        Session::flash('type', 'success');
        return redirect()->route('customer.payment.status');
    }

    public function apifailed()
    {
        Session::flash('message', 'Transaction Error Occured!!');
        Session::flash('type', 'danger');
        return redirect()->route('customer.payment.status');
    }

    public function apipayment(Request $request)
    {
        if ($request->phone_required == 1) {
            $request->validate([
                'phone' => 'required',
            ]);
        }
        if ($request->image_accept == 1) {
            $request->validate([
                'screenshot' => 'required|image|max:1000|mimes:jpeg,bmp,png,jpg',
                'comment' => 'required|max:200'
            ]);
        }

        // Google recaptcha validation
        if ($request->has('g-recaptcha-response')) {
            if(env('NOCAPTCHA_SECRET') != null){
                $messages = [
                    'g-recaptcha-response.required' => 'You must check the reCAPTCHA.',
                    'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
                ];
                
                $validator = Validator::make($request->all(), [
                    'g-recaptcha-response' => 'required|captcha'
                ], $messages);
                
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
            }
        }

        $user_info = Session::has('api_request') ? Session::get('api_request') : "";

        $usergateway = Usergetway::with('getway', 'user', 'currencygetway')->where([
            ['getway_id', $request->gateway_id],
            ['status', 1],
            ['user_id', $user_info['user_id']],
        ])->first();
      
        $user = User::where([['role_id',2],['status',1]])->findOrFail($user_info['user_id']);

        $paymentRequest = PaymentRequest::with('requestmeta')->whereHas('requestmeta')->findOrFail($request->request_id);
        $paymentRequest->status = 0; //Inactive
        $paymentRequest->ip = getIp(); //Ip Address
        $info = json_decode($paymentRequest->requestmeta->value);
        $paymentRequest->save();

        $storage_limit=Userplan::where('user_id',$user->id)->pluck('storage_limit')->first();
        $storage_used = folderSize('uploads/'.$user->id);
        if ($request->hasFile('screenshot') && $storage_limit > $storage_used) {
            $logo      = $request->file('screenshot');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/'.$user->id.'/'.date('y/m/');
            $logo->move($logo_path, $logo_name);
            $payment_data['screenshot'] = $logo_path . $logo_name;
        }

       $payment_data['currency'] = $usergateway->currency_name ?? $usergateway->getway->currency_name ?? 'USD';
        $payment_data['email'] = $user->email ?? $user_info->email ?? "";
        $payment_data['name'] = $user->name ?? $user_info->name ?? "";
        $payment_data['phone'] = $user_info->phone ?? $request->phone ?? "";
        $payment_data['billName'] = $info->purpose ?? 'External Payment';
        $payment_data['amount'] = $paymentRequest->amount;
        $payment_data['test_mode'] = $request->is_test ?? $test_mode ?? 1;
        $payment_data['charge'] = $usergateway->currencygetway->charge ?? 0;
        $payment_data['pay_amount'] = $paymentRequest->amount * $usergateway->rate + $usergateway->charge;
        $payment_data['getway_id'] = $usergateway->getway_id;
        $payment_data['user_id'] = $usergateway->user_id;
        $payment_data['request_from'] = 'api';
        $payment_data['request_id'] = $request->request_id;
        $payment_data['is_fallback'] = $paymentRequest->is_fallback;
        $payment_data['payment_type'] = 1;
        $payment_data['comment'] = $request->comment ?? '';

        if ($request->is_test == 1) {
            $gateway_info = json_decode($usergateway->sandbox);
        } else {
            $gateway_info = json_decode($usergateway->production);
        }

        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            };
        }
        return $usergateway->getway->namespace::make_payment($payment_data);
    }


    //Request From external form
    public function requestform(Request $request)
    {
        if ($request->public_key == "") {
            return response()->json('No Public key found!');
        }
        if ($request->amount == "") {
            return response()->json('Amount field is required!');
        }
        if ($request->phone == "") {
            return response()->json('Phone field is required!');
        }
        if ($request->currency == "") {
            return response()->json('Currency field is required!');
        }
        if ($request->email == "") {
            return response()->json('Email field is required!');
        }

        $public_key = $request->public_key;
        $currency = $request->currency;

       $user = User::where('public_key', $public_key)->where('currency', $currency)->where('status', 1)->first();
        if (!$user) {
            abort(403, "Invalid Request!");
        }

        //Check if request limit exceeded
        $user_plan = Userplan::where('user_id', $user->id)->select('id', 'daily_req', 'monthly_req')->first();
        $daily_request = PaymentRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $monthly_request = PaymentRequest::where('user_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->count();

        if ($user_plan->daily_req <= $daily_request) {
            abort(403, "Daily Request Limited Exceeded!");
        }

        if ($user_plan->monthly_req <= $monthly_request) {
            abort(403, "Monthly Request Limited Exceeded!");
        }

        if ($request->is_fallback == '1' && $request->fallback_url == "") {
            abort(403, "Fallback url is required!");
        }

        $data['phone'] = $phone = $request->phone ?? "";
        $data['email'] = $request->email ?? "";
        $data['name'] = $request->name ?? "";
        $data['purpose'] = $request->purpose ?? "";
        $fallbackurl = $data['fallback'] = rtrim($request->fallback_url, '/') ?? "";

        $paymentRequest = new PaymentRequest;
        $paymentRequest->user_id = $user->id;
        $paymentRequest->amount = $request->amount;
        $paymentRequest->currency = $request->currency;
        $paymentRequest->is_fallback = $request->is_fallback ?? 0;
        $paymentRequest->is_test = $is_test = $request->is_test;
        $paymentRequest->ip = $request->ip();
        $paymentRequest->status = 0; //inactive
        $paymentRequest->save();

        $requestMeta = new Requestmeta;
        $requestMeta->key = 'request_info';
        $requestMeta->value = json_encode($data);
        $requestMeta->request_id = $paymentRequest->id;
        $requestMeta->save();

        $data = [
            'data'           => json_decode($paymentRequest->requestmeta->value),
            'request_id'     => $paymentRequest->id,
            'amount'         => $paymentRequest->amount,
            'user_id'        => $paymentRequest->user_id,
            'is_fallback'    => $paymentRequest->is_fallback,
            'is_test'        => $is_test,
            'ip'             => $paymentRequest->ip,
            'phone'          => $phone,
            'captcha_status' => $paymentRequest->captcha_status,
            'fallbackurl'    => $fallbackurl,
        ];

        Session::put('api_request', $data);
        return redirect()->route('customer.checkout.view');
    }
}
