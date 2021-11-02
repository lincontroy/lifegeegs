<?php
namespace App\Lib;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Str;

class Toyyibpay {
        
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
        return url('customer/payment/toyyibpay');
        }elseif ($request_from == 'merchant') {
            return url('payment/toyyibpay');
        }
    }

    public static function make_payment($array)
    {
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
        $data['request_from'] = $request_from = $array['request_from'];
        $data['user_secret_key']=$array['user_secret_key'];
        $data['cateogry_code']=$array['cateogry_code'];
        $data['payment_mode']='toyyibpay';
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
        
        Session::put('toyyibpay_credentials',$data);

        if ($test_mode == false) {
			$url='https://toyyibpay.com/';
		}
		else{
			$url='https://dev.toyyibpay.com/';
		}

        $payment_info['payment_method'] = "toyyibpay";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);

		$data = array(
			'userSecretKey'=>$array['user_secret_key'],
			'categoryCode'=>$array['cateogry_code'],
			'billName'=>$billName,
			'billDescription'=>"Thank you for deposit",
			'billPriceSetting'=>1,
			'billPayorInfo'=>1,
			'billAmount'=>$amount*100,
			'billReturnUrl'=>Toyyibpay::fallback($request_from),
			'billCallbackUrl'=>Toyyibpay::fallback($request_from),
			'billExternalReferenceNo' => Str::random(5),
			'billTo'=>$name,
			'billEmail'=>$email,
			'billPhone'=> $array['phone'],
			'billSplitPayment'=>0,
			'billSplitPaymentArgs'=>'',
			'billPaymentChannel'=>'2',
			'billDisplayMerchant'=>1,
			'billContentEmail'=>"",
			'billChargeToCustomer'=>2
		);  
		$f_url= $url.'index.php/api/createBill';

        
		try {
            $response = Http::asForm()->post($f_url,$data);
		    $billcode=$response[0]['BillCode'];
            $url=$url.$billcode;
            return redirect($url);
        } catch (\Throwable $th) {
            return redirect(Toyyibpay::redirect_if_payment_faild($request_from));
        }
       
        
    }


    public function status()
    {
        if(!Session::has('toyyibpay_credentials')){
            return abort(404);
        }
        $response=Request()->all();
		$status=$response['status_id'];
		$payment_id=$response['billcode'];
        
        $info=Session::get('toyyibpay_credentials');
        $data['request_from'] = $request_from = $info['request_from'];
        if ($status==1) {
             $data['payment_id'] = $payment_id;           
             $data['payment_method'] = "toyyibpay";
             $data['getway_id'] = $info['getway_id'];
             $data['payment_type'] = $info['payment_type'];
             $data['amount'] = $info['amount'];
             $data['main_amount'] = $info['main_amount'];
             $data['charge'] = $info['charge'];
             $data['currency'] = $info['currency'] ?? '';
             $data['status'] = 1;  
             $data['payment_status'] = 1; 
             $data['is_fallback']=$info['is_fallback'];
             if ($request_from == 'customer' || $request_from == 'api') {
                $data['request_id'] = $info['request_id'];
                $data['user_id']= $info['user_id'];
            }     
             Session::forget('toyyibpay_credentials');
             Session::put('payment_info',$data); 
             
             return redirect(Toyyibpay::redirect_if_payment_success($request_from));
        }      
        else{
           
            Session::forget('toyyibpay_credentials');
            return redirect(Toyyibpay::redirect_if_payment_faild($request_from));
        }
    }

}


?>