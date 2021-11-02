<?php
namespace App\Lib;

use App\Models\Payment;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;
class CustomGetway {
        
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
        return url('customer/payment/flutterwave');
        }elseif ($request_from == 'merchant') {
            return url('payment/flutterwave');
        }
    }

    public static function make_payment($array)
    {
        
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];

        $data['payment_mode']='manual';
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
        $data['request_from'] = $request_from = $array['request_from'];
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
        $data['screenshot']=$array['screenshot'] ?? '';
        $data['comment']=$array['comment'] ?? '';
        $data['is_fallback']=$array['is_fallback'] ?? 0;
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


        Session::put('manual_credentials',$data);

        $payment_info['payment_method'] = "manual";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);


        if ($request_from == 'customer' || $request_from == 'api') {
            return redirect('customer/manual/payment');
        }elseif ($request_from == 'merchant') {
            return redirect('/manual/payment');
        }
    }


    public function status()
    {
        if(!Session::has('manual_credentials')){
            return abort(404);
        }
        $info=Session::get('manual_credentials');
        $data['request_from'] = $request_from = $info['request_from'];
            $data['payment_id'] = $this->generateString();           
            $data['payment_method'] = "manual";
            $data['getway_id'] = $info['getway_id'];
            $data['payment_type'] = $info['payment_type'];
            $data['amount'] = $info['amount'];
            $data['main_amount'] = $info['main_amount'];
            $data['currency'] = $info['currency'];
            $data['charge'] = $info['charge'];
            $data['status'] = 2;   
            $data['payment_status'] = 2;  
            $data['is_fallback'] = $info['is_fallback']; 
            $data['screenshot']=$info['screenshot'] ?? '';
            $data['comment']=$info['comment'] ?? '';
            if ($request_from == 'customer' || $request_from == 'api') {
            $data['request_id'] = $info['request_id'];
            $data['user_id']= $info['user_id'];
            }    
            Session::forget('manual_credentials');
            Session::put('payment_info',$data); 
            return redirect(CustomGetway::redirect_if_payment_success($request_from));
      
    }


    public function generateString()
    {
        $str = Str::random(10);
        $payment = Payment::where('trx_id',$str)->count();
        if ($payment == 0) {
            return $str;
        }
        return $this->generateString();
    }

}


?>
