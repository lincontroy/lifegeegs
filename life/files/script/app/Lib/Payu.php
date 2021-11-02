<?php
namespace App\Lib;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Str;

class Payu {
        
    public static function redirect_if_payment_success($request_from)
    {
        if ($request_from == 'customer') {
            return url('customer/payment/success');
        }elseif ($request_from == 'merchant') {
            return url('merchant/payment/success');
        }elseif ($request_from == 'api') {
            return url('customer/api/payment/success');
        }
    }

    public static function redirect_if_payment_faild($request_from)
    {
        if ($request_from == 'customer') {
            return url('customer/payment/failed');
        }elseif ($request_from == 'merchant') {
            return url('merchant/payment/failed');
        }elseif ($request_from == 'api') {
            return url('customer/api/payment/failed');
        }
    }

    public static function fallback($request_from)
    {
       if ($request_from == 'customer' || $request_from == 'api') {
        return route('customer.payu.status'); 
        }elseif ($request_from == 'merchant') {
        return route('merchant.payu.status'); 
        }
    }

    public function view()
    {
        if(Session::has('payu_credentials')){
            $Info=Session::get('payu_credentials');
            $request_from= $Info['request_from'];
            return ($request_from == 'customer' || $request_from == 'api') ? 
            view('payment.getway.payu', compact('Info')) 
            : view('merchant.plan.payment.payu', compact('Info'));
        }
        abort(404);
    }

    public static function make_payment($array)
    {
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $data['txnid'] = $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $billName=$array['billName'];
        $data['merchant_key']=$array['merchant_key'];
        $data['hash']=$array['merchant_salt'];
        $data['payment_mode']='payu';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $data['getway_id']=$array['getway_id'];
        $data['main_amount']=$array['amount'];
        $data['payment_type']=$array['payment_type'];
        $data['billName']=$billName;
        $data['name']=$name;
        $data['email']=$email;
        $data['currency']=$currency;
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
        $data['request_from'] = $request_from = $array['request_from'];
        $data['request_id']=$array['request_id'] ?? '';
        $data['user_id']=$array['user_id'] ?? '';
     
        if($test_mode == 0){
            $data['env']=false;
            $test_mode=false;
        }
        else{
            $data['env']=true;
            $test_mode=true;
        }

        $payment_info['payment_method'] = "payu";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);


		$info = array(
			'key'=> $array['merchant_key'],
			'test_mode '=> $test_mode,
			'txnid' => $txnid,
			'amount'=>  $amount,
			'firstname'=> $name,
			'lastname'=> "",
			'email'=>$email,
			'salt'=> $array['merchant_salt'],
			'productinfo'=>$billName,
			'phone'=> $array['phone'],
			'service_provider'=> 'payu_paisa',
			'surl'=> Payu::fallback($request_from),
			'udf5'=> 'BOLT_KIT_PHP7',
			'furl'=> Payu::redirect_if_payment_faild($request_from),
		);  

        $hash=hash('sha512', $info['key'].'|'.$info['txnid'].'|'.$info['amount'].'|'.$info['productinfo'].'|'.$info['firstname'].'|'.$info['email'].'|||||'.$info['udf5'].'||||||'.$info['salt']);

    	$info['hash'] = $hash;

      

       $data = array_merge($data,$info);
       Session::put('payu_credentials',$data);


       if ($request_from == 'customer' || $request_from == 'api') {
            return redirect()->route('customer.payu.view');
        }else{
            return redirect()->route('merchant.payu.view');
        }
        
    }



    public function status()
    {

        if(!Session::has('payu_credentials')){
            return abort(404);
        }
        $info=Session::get('payu_credentials');
        $data['request_from'] = $request_from = $info['request_from'];
        if (Request()->status == 'success') {
             $data['payment_id'] = Request()->payuMoneyId;           
             $data['payment_method'] = "payu";
             $data['getway_id'] = $info['getway_id'];
             $data['payment_type'] = $info['payment_type'];
             $data['amount'] = $info['amount'];
             $data['main_amount'] = $info['main_amount'];
             $data['charge'] = $info['charge'];
             $data['status'] = 1;  
             $data['currency'] = $info['currency'] ?? '';
             $data['payment_status'] = 1; 
             $data['is_fallback'] = $info['is_fallback'];
             if ($request_from == 'customer' || $request_from == 'api') {
                 $data['request_id'] = $info['request_id'];
                 $data['user_id']= $info['user_id'];
             }
             Session::forget('payu_credentials');
             Session::put('payment_info',$data); 
            return redirect(Payu::redirect_if_payment_success($request_from));
        }      
        else{
            Session::forget('payu_credentials');
            return redirect(Payu::redirect_if_payment_faild($request_from));
        }
    }

}


?>