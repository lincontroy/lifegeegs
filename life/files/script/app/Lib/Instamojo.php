<?php
namespace App\Lib;
use Session;
use Illuminate\Http\Request;
use Http;
class Instamojo {
        
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
            return url('customer/payment/instamojo');
        }elseif ($request_from == 'merchant') {
            return url('payment/instamojo');
        }
}

    public static function make_payment($array)
    {
        $regex = "/^(0|91|\+91)?[789]\d{9}$/";
        if ($array['phone'] == "") {
            return redirect()->back()->with('alert','Phone Number not given!')->with('type','alert-danger');
        }
        if (!preg_match($regex, $array['phone'])) {
            return redirect()->back()->with('alert','Phone Number not valid!')->with('type','alert-danger');
        }

        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];


        $test_mode=$array['test_mode'];
        $data['request_from'] = $request_from = $array['request_from'];
        $data['test_mode']=$test_mode;
        
        $data['x_auth_token']=$array['x_auth_token'];
        $data['x_api_key']=$array['x_api_key'];
        $data['payment_mode']='instamojo';
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
        $data['is_fallback'] = $array['is_fallback'] ?? 0;
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
        Session::put('instamojo_credentials',$data);
        $payment_info['payment_method'] = "instamojo";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);

        if ($test_mode == true) {
            $url='https://test.instamojo.com/api/1.1/payment-requests/';
        }
        else{
            $url='https://www.instamojo.com/api/1.1/payment-requests/';
        }     

        try {
            $params=[
                'purpose' => $data['billName'],
                'amount' => $amount,
                'phone' => $data['phone'],
                'buyer_name' => $name,
                'redirect_url' => Instamojo::fallback($request_from),
                'send_email' => true,
                'send_sms' => true,
                'email' => $email,
                'allow_repeated_payments' => false
            ];
         $response=Http::asForm()->withHeaders([
                'X-Api-Key' => $data['x_api_key'],
                'X-Auth-Token' => $data['x_auth_token']
            ])->post($url,$params);

        if(isset($response['payment_request'])) {
            $url= $response['payment_request']['longurl'];
            return redirect($url);
        }
       else{
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild($request_from));
        }
        } catch (\Throwable $th) {
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild($request_from));
        }
       
        
    }


    public function status()
    {
        if(!Session::has('instamojo_credentials')){
            return abort(404);
        }
        $response=Request()->all();
        $payment_id=$response['payment_id'];
        $info=Session::get('instamojo_credentials');
        $data['request_from'] = $request_from = $info['request_from'];
        if ($response['payment_status']=='Credit') {
             $data['payment_id'] = $payment_id;           
             $data['payment_method'] = "instamojo";
             $data['getway_id'] = $info['getway_id'];
             $data['payment_type'] = $info['payment_type'];
             $data['amount'] = $info['amount'];
             $data['main_amount'] = $info['main_amount'];
             $data['charge'] = $info['charge'];
             $data['currency'] = $info['currency'] ?? '';
             $data['status'] = 1;  
             $data['payment_status'] = 1;   
             if ($request_from == 'customer' || $request_from == 'api') {
                $data['request_id'] = $info['request_id'];
                $data['user_id']= $info['user_id'];
            }  
             Session::forget('instamojo_credentials');
             Session::put('payment_info',$data); 
             
             return redirect(Instamojo::redirect_if_payment_success($request_from));
        }      
        else{
           
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild($request_from));
        }
    }

    public static function isfraud($creds){
        $payment_id = $creds['payment_id'];
        $api = $creds['x_api_key'];
        $is_test = $creds['is_test'];
        $auth_token = $creds['x_auth_token'];

        if ($is_test == 1) {
            $url = 'https://test.instamojo.com/api/1.1/payments/'.$payment_id.'/';
        }else{
            $url = 'https://www.instamojo.com/api/1.1/payments/'.$payment_id.'/';
        }
        
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array(
                            "Content-Type: application/json",
                            "X-Api-Key:".$api,
                            "X-Auth-Token:".$auth_token));
            $response = curl_exec($ch);
            curl_close($ch); 
            $arr = json_decode($response, true);
            return $arr['success'] === true ? 1 : 0;
        } catch (\Throwable $th) {
           return 0;
        }

        
    }

}
