<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\PlanMail;
use App\Models\Getway;
use App\Models\Option;
use App\Models\Order;
use App\Models\Paymentmeta;
use App\Models\Plan;
use App\Models\Ordermeta;
use App\Models\User;
use App\Models\Userplan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Support\Str;
use DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::where([['status', 1], ['is_default', 0],['is_trial', 0]])->get();
        $orders = Order::where('user_id', Auth::id())->with('plan', 'getway')->latest()->paginate(25);
        return view('merchant.plan.index', compact('plans', 'orders'));
    }

    public function gateways($planid)
    {
        $gateways = Getway::where('name', '!=', 'free')->where('global_status',1)->get();
        $plan = Plan::where([['status', 1], ['is_default', 0],['is_trial', 0]])->findOrFail($planid);
        if($plan->is_trial == 1){
            $order = Order::where([['plan_id',$planid],['user_id',Auth::id()]])->first();
            if($order == null){
                $data['getway_id'] = Getway::where('name','free')->pluck('id')->first() ?? 8;
                $data['payment_id'] = $this->uniquetrx();
                $data['plan'] = $planid;
                $data['payment_status'] = 1;
                Session::put('plan', $planid);
                Session::put('payment_info', $data);
                return redirect()->route('merchant.payment.success');
            }else{
                return redirect()->route('merchant.plan.index')->with('message','Already enrolled in Trial Plan! Select Other Plan')->with('type','danger');
            }
            
        }
        return view('merchant.plan.gateways', compact('gateways', 'plan'));
    }

    public function deposit(Request $request)
    {
        
        $gateway = Getway::findOrFail($request->id);
        if ($gateway->image_accept == 1) {
             $validated = $request->validate([
                'screenshot' => 'required|image|max:1000',
             ]);

             $screenshot = $request->file('screenshot');
             $receipt = hexdec(uniqid()) . '.' . $screenshot->getClientOriginalExtension();
             $path = 'uploads/payment_receipt' . date('/y/m/');
             $screenshot->move($path, $receipt);
             $image = $path . $receipt;
             $payment_data['screenshot'] =$image;
        }
        $gateway_info = json_decode($gateway->data); //for creds
        $plan = Plan::where([['status', 1], ['is_default', 0],['is_trial', 0]])->findOrFail($request->plan_id);
        $payment_data['currency'] = $gateway->currency_name ?? 'USD';
        $payment_data['email'] = Auth::user()->email;
        $payment_data['name'] = Auth::user()->name;
        $payment_data['phone'] = $request->phone;
        $payment_data['billName'] = $plan->name;
        $payment_data['amount'] = $gateway->charge+$plan->price * $gateway->rate;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = $gateway->charge+$plan->price * $gateway->rate;
        $payment_data['getway_id'] = $gateway->id;
        $payment_data['payment_type'] = 1;
        $payment_data['request'] = $request->except('_token');
        $payment_data['request_from'] = 'merchant';
        Session::put('plan', $request->plan_id);

        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            };
        }
        // return $payment_data;
      return  $gateway->namespace::make_payment($payment_data);
    }

    public function success(Request $request)
    {
        if (!session()->has('payment_info') && session()->get('payment_info')['payment_status'] == 0) {
            abort(403);
        }
        //if transaction successfull
        $plan_id = $request->session()->get('plan');
        $plan = Plan::findOrFail($plan_id);
        $getway_id = $request->session()->get('payment_info')['getway_id'];
        $gateway = Getway::findOrFail($getway_id);
        $payment_id = $request->session()->get('payment_info')['payment_id'];
        $totalAmount = $plan->price * $gateway->rate;

        $auto_enrollment = Option::where('key', 'auto_enroll_after_payment')->pluck('value')->first();
        DB::beginTransaction();
        try {
        $order = new Order();

        if ($auto_enrollment == 'on' && session()->get('payment_info')['payment_status'] == 1) {
            $userplan = Userplan::where('user_id', Auth::id())->first();
            if (!$userplan) {
                $userplan = new Userplan;
            }
            $userplan->name = $plan->name;
            $userplan->user_id = Auth::id();
            $userplan->storage_limit = $plan->storage_limit;
            $userplan->menual_req = $plan->menual_req;
            $userplan->daily_req = $plan->daily_req;
            $userplan->captcha = $plan->captcha;
            $userplan->monthly_req = $plan->monthly_req;
            $userplan->mail_activity = $plan->mail_activity;
            $userplan->fraud_check = $plan->fraud_check;
            $userplan->save();
        }



        $admin = User::where('role_id', 1)->first();

        $data = [
            'type'    => 'plan',
            'email'   => $admin->email,
            'name'    => Auth::user()->name,
            'message' => "Successfully Paid " . round($totalAmount, 2) . " (charge included) for " . $plan->name . " plan",
        ];

        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        } else {
            Mail::to($admin->email)->send(new PlanMail($data));
        }

        // Insert transaction data into order table
        $order = new Order;
        $order->plan_id = $plan_id;
        $order->user_id = Auth::id();
        $order->getway_id = $gateway->id;
        $order->payment_id = $payment_id;
        $order->amount = $plan->price;
        if (session()->get('payment_info')['payment_status'] == 1) {
            $order->status = $auto_enrollment == 'on' ? 1 : 2; //Success
        }
        else{
            $order->status = 3; //pending
        }
        
        
        $order->payment_status = session()->get('payment_info')['payment_status'];
        $order->exp_date = Carbon::now()->addDays($plan->duration);
        $order->save();
        if (isset(session()->get('payment_info')['screenshot'])) {
          $meta= new Ordermeta;
          $meta->value=session()->get('payment_info')['screenshot'];
          $meta->order_id=$order->id;
          $meta->save();
        }

         DB::commit();
        } catch (Exception $e) {
          DB::rollback();
        }

   

        Session::flash('message', 'Transaction Successfully done!');
        Session::flash('type', 'success');
        Session::forget('payment_info');
        return redirect()->route('merchant.plan.index');
    }

    public function failed()
    {
        Session::flash('message', 'Transaction Error Occured!!');
        Session::flash('type', 'danger');
        return redirect()->route('merchant.plan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchant.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('plan', 'getway', 'user')->where('user_id',Auth::id())->findOrFail($id);
        return view('merchant.plan.show', compact('order'));

    }

    public function invoicePdf($id)
    {
        $data = Order::with('plan', 'getway', 'user')->where('user_id',Auth::id())->findOrFail($id);
        $pdf = PDF::loadView('merchant.plan.invoice-pdf', compact('data'));
        return $pdf->download('order-invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('merchant.plan.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
    function uniquetrx(){  
        $str = Str::random(16);
        $check = Order::where('payment_id', $str)->first();
        if($check == true){
            $str = $this->uniquetrx();
        }
        return $str;
    }
}
