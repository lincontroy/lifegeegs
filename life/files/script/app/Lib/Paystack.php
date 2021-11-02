<?php
namespace App\Lib;

use App\Models\Getway;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Http;
use Str;
class Paystack {

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

    public static function fallback()
    {
       return url('/payment/Paystack');
    }

    public function view($request_from){

        if(Session::has('paystack_credentials')){
            $Info=Session::get('paystack_credentials');
            return ($request_from == 'customer' || $request_from == 'api') ? 
            view('payment.getway.paystack',compact('Info')) 
            : view('merchant.plan.payment.paystack',compact('Info'));
        }
        abort(404);
    }

    public static function make_payment($array)
    {
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];

        $data['public_key']=$array['public_key'];
        $data['secret_key']=$array['secret_key'];
        $data['payment_mode']='paystack';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $test_mode=$array['test_mode'];
        $data['request_from'] = $request_from = $array['request_from'];
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


        Session::put('paystack_credentials',$data);

        $payment_info['payment_method'] = "paystack";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);

        if ($request_from == 'customer' || $request_from == 'api') {
          return redirect()->route('customer.paystack.view', $request_from);
        }elseif ($request_from == 'merchant') {
          return redirect()->route('merchant.paystack.view', $request_from);
        }

    }


    public function status(Request $request)
    {
        if(!Session::has('paystack_credentials')){
            return abort(404);
        }


        $info=Session::get('paystack_credentials');
        $curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$request->ref_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer ".$info['secret_key']."",
				"Cache-Control: no-cache",
			),
		));

        $response = curl_exec($curl);

		$err = curl_error($curl);
        curl_close($curl);
        $pay_data['request_from'] = $request_from = $info['request_from'];

		if ($err) {
             Session::forget('paystack_credentials');
			 return redirect(Paystack::redirect_if_payment_faild($request_from));
		} else {
			$data=json_decode($response);
			if($data->status == true && $data->data->status == 'success'){
				$ref_id=$data->data->reference;
				$amount=$data->data->amount/100;
				if($amount != $info['amount']){
                    return abort(404);
                }

				$pay_data['payment_id'] = $ref_id;
				$pay_data['payment_method'] = "paystack";
                $pay_data['getway_id'] = $info['getway_id'];
                $pay_data['payment_type'] = $info['payment_type'];
                $pay_data['amount'] = $info['amount'];
                $pay_data['main_amount'] = $info['main_amount'];
                $pay_data['currency'] = $info['currency'] ?? '';
                $pay_data['charge'] = $info['charge'];
                $pay_data['status'] = 1;
                $pay_data['payment_status'] = 1;
                $pay_data['is_fallback'] = $info['is_fallback'];

                if ($request_from == 'customer' || $request_from == 'api') {
                    $pay_data['request_id'] = $info['request_id'];
                    $pay_data['user_id']= $info['user_id'];
                }

                Session::forget('paystack_credentials');
                Session::put('payment_info',$pay_data);

				return redirect(Paystack::redirect_if_payment_success($request_from));
			}
		}
        Session::forget('paystack_credentials');
        return redirect(Paystack::redirect_if_payment_faild($request_from));

    }


    public static function isfraud($cred){
        $secret_key = $cred['secret_key'];
        $reference = $cred['payment_id'];
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". $secret_key,
            "Cache-Control: no-cache",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $arr = json_decode($response, true);
        if (array_key_exists('data', $arr)) {
            return $arr['data']['status'] === "success" ? 1 : 0;
        }
        } catch (\Throwable $th) {
            return 0;
        }

    }
}


?>
