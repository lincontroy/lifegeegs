<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Str;
use App\Mail\LoginOtpMail;
use App\Models\Option;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\Userplan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use DB;
use Validator;
class LoginController extends Controller
{
        
    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

   
    public function otp(){
        $user = User::findOrFail(Auth::id());
        $data['otp_number'] = $otp = rand(1000, 9999);
        $data['type'] = 'login_otp';
        $data['email'] = $user->email;
        Session::put('otp_number', $otp);
        Session::put('message', "Check your mail for otp!");

        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        }else{
            Mail::to($user->email)->send(new LoginOtpMail($data));
        }
        
        return redirect()->route('otp.view');
    }

    public function otpview(){
        return view('otp.login_otp');
    }

    // Login OtP confirmation
    public function otpConfirm(Request $request)
    {
        if($request->otp != Session::get('otp_number')) {
            Session::put('message', "OTP not matched");
            return redirect()->route('otp.view');
        } else{
            if (Session::has('message')) {
                Session::forget('message');
            } 
            Session::put('otp_verified', true);
            Session::forget('otp_number');
            return redirect('/merchant/dashboard');
        }
        
    }


    public function plan_register(Request $request){
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
        

        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users|email|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $plan = Plan::findOrFail($request->planid);
       
        DB::beginTransaction();
        try {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->public_key = $this->newKey('public_key');
        $user->private_key = $this->newKey('private_key');
        $user->currency = 'USD';
        $user->password = Hash::make($request->password);
        $user->save();

        $trial = $plan->is_trial;

        if($trial == 0){
            $plan = Plan::where('is_default', 1)->first();
        }

        if ($trial == 1 && $plan) {
        $userplan = new Userplan();
        $userplan->user_id = $user->id;
        $userplan->name =  'free';
        $userplan->storage_limit =  0;
        $userplan->captcha =  0;
        $userplan->menual_req = 0;
        $userplan->monthly_req = $plan->monthly_req ?? 0;
        $userplan->daily_req = $plan->daily_req ?? 0;
        $userplan->mail_activity = $plan->mail_activity ?? 0;
        $userplan->fraud_check = $plan->fraud_check ?? 0;
        $userplan->captcha = $plan->captcha ?? 0;
        $userplan->save();

        $order = new Order;
        $order->plan_id =  $plan->id;
        $order->user_id = $user->id;
        $order->getway_id = 14;
        $order->payment_id = Str::random(10);
        $order->amount = $plan->price;
        $order->status = 1;
        $order->payment_status = 1;
        $order->exp_date = Carbon::now()->addDays($plan->duration);
        $order->save();

        }
        else{
           $userplan = new Userplan();
           $userplan->user_id = $user->id;
           $userplan->name =  'free';
           $userplan->storage_limit =  0;
           $userplan->captcha =  0;
           $userplan->menual_req = 0;
           $userplan->monthly_req =  0;
           $userplan->daily_req =  0;
           $userplan->mail_activity = 0;
           $userplan->fraud_check = 0;
           $userplan->captcha = 0;
           $userplan->save();
        }
        

         Auth::login($user);
          DB::commit();
        } catch (Exception $e) {
          DB::rollback();
        }

        if ($trial == 0 && $request->planid) {
            return redirect()->route('merchant.plan.gateways', $request->planid);
        }

        Session::flash('message', 'Transaction Successfully done! & Plan Activated');
        Session::flash('type', 'success');
        return redirect()->route('merchant.plan.index');
    }

    public function newKey($column)
    {
        $key=Str::random(50);
        $check=User::where($column,$key)->first();
        if(!empty($check)){
            $this->newKey();
        }

        return $key;
    }

  

}
