<?php

namespace App\Lib;

use App\Models\Paymentmeta;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;

class Thawani
{
    public static function redirect_if_payment_success($request_from)
    {
        if ($request_from == 'customer') {
            return url('customer/payment/success');
        } elseif ($request_from == 'merchant') {
            return url('merchant/payment/success');
        } elseif ($request_from == 'api') {
            return url('customer/api/payment/success');
        }
    }

    public static function redirect_if_payment_faild($request_from)
    {
        if ($request_from == 'customer') {
            return url('customer/payment/failed');
        } elseif ($request_from == 'merchant') {
            return url('merchant/payment/failed');
        } elseif ($request_from == 'api') {
            return url('customer/api/payment/failed');
        }
    }

    public static function fallback($request_from)
    {
        if ($request_from == 'customer' || $request_from == 'api') {
            return url('customer/payment/thawani');
        } elseif ($request_from == 'merchant') {
            return url('payment/thawani');
        }
    }

    public static function make_payment($array)
    {
        $currency = $array['currency'];
        $email = $array['email'];
        $amount = $array['pay_amount'];
        $name = $array['name'];
        $billName = $array['billName'];
        $data['secret_key'] = $array['secret_key'];
        $data['public_key'] = $array['publishable_key'];
        $data['payment_mode'] = 'thawani';
        $test_mode = $array['test_mode'];
        $data['test_mode'] = $test_mode;
        $data['request_from'] = $request_from = $array['request_from'];
        $data['amount'] = $amount;
        $data['charge'] = $array['charge'];
        $data['phone'] = $array['phone'];
        $data['getway_id'] = $array['getway_id'];
        $data['main_amount'] = $array['amount'];
        $data['payment_type'] = $array['payment_type'];
        $data['billName'] = empty($billName) ? 'Customer Payment' : $billName;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['currency'] = $currency;
        $data['is_fallback'] = $array['is_fallback'] ?? 0;
        $data['request_id']=$array['request_id'] ?? '';
        $data['user_id']=$array['user_id'] ?? '';

        $productJson = json_encode([
            'name' => $data['billName'],
            'unit_amount' => (float) ceil($array['pay_amount'] * 1000),
            'quantity' => 1,
        ]);
        if ($test_mode == 0) {
            $data['env'] = false;
            $test_mode = false;
        } else {
            $data['env'] = true;
            $test_mode = true;
        }


        $payment_info['payment_method'] = "thawani";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']= $array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://uatcheckout.thawani.om/api/v1/checkout/session",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "thawani-api-key: " . $data['secret_key']
            ],
            CURLOPT_POSTFIELDS => '{"client_reference_id": '.strtotime(Carbon::now()).',
            "products": [' . $productJson . '],
            "success_url": "' . Thawani::fallback($request_from) . '",
            "cancel_url": "' . Thawani::redirect_if_payment_faild($request_from) . '"}',
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        $response = json_decode($response, true);

        if (array_key_exists('success', $response) && $response['success'] == true) {
            $session_id = $response['data']['session_id'];
            $data['response'] = $response;
            if ($test_mode == true) {
                $url = "https://uatcheckout.thawani.om/pay/" . $session_id . "?key=" . $array['publishable_key'];
            } else {
                $url = "https://checkout.thawani.om/pay/" . $session_id . "?key=" . $array['publishable_key'];
            }
            Session::put('thawani_credentials', $data);
        }else{
            Session::has('thawani_credentials') ? Session::forget('thawani_credentials') : '';
            $url = Thawani::redirect_if_payment_faild($request_from);
        }

        Session::put('thawani_credentials', $data);
        return redirect($url);
    }


    public function status(Request $request)
    {
        if (!Session::has('thawani_credentials')) {
            return abort(404);
        }
        $info = Session::get('thawani_credentials');
        $test_mode = Session::get('thawani_credentials')['test_mode'];
        $secret_key = Session::get('thawani_credentials')['secret_key'];
        $invoice = Session::get('thawani_credentials')['response']['data']['invoice'];
        $response = $this->getResponse($test_mode,$invoice, $secret_key);
        $responseArr = json_decode($response, true);
        $data['request_from'] = $request_from = $info['request_from'];
        
        if (array_key_exists('success', $responseArr) && $responseArr['success'] == true) {
            $data['payment_id'] = $responseArr['data'][0]['payment_id'];
            $data['payment_method'] = "thawani";
            $data['getway_id'] = $info['getway_id'];
            $data['payment_type'] = $info['payment_type'];
            $data['amount'] = $info['amount'];
            $data['main_amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['currency'] = $info['currency'] ?? '';
            $data['status'] = 1;
            $data['payment_status'] = 1;
            $data['is_fallback'] = $info['is_fallback'];

            if ($request_from == 'customer' || $request_from == 'api') {
                $data['request_id'] = $info['request_id'];
                $data['user_id'] = $info['user_id'];
            }
            Session::forget('thawani_credentials');
            Session::put('payment_info', $data);
            return redirect(thawani::redirect_if_payment_success($request_from));
        } else {

            Session::forget('thawani_credentials');
            return redirect(thawani::redirect_if_payment_faild($request_from));
        }
    }



    private function getResponse($test_mode, $invoice_id, $api_key){

        if ($test_mode == 1) {
            $url = "https://uatcheckout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }else{
            $url = "https://checkout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key
          ],
        ]);  
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {
          return $err;
        } else {
          return $response;
        }
    }

    public function generateAccNo()
    {
        $rend = rand(10000000, 99999999) . rand(10000000, 99999999);
        $check = Paymentmeta::where('account_number', $rend)->first();

        if ($check == true) {
            $rend = $this->generateAccNo();
        }
        return $rend;
    }

    public static function isfraud($creds){
        $invoice_id = $creds['payment_id'];
        $api_key = $creds['secret_key'];
        $test_mode = $creds['is_test'];

        if ($test_mode == 1) {
            $url = "https://uatcheckout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }else{
            $url = "https://checkout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }

        try {
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key
          ],
        ]);  
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        $arr = json_decode($response, true);
        if (array_key_exists('success', $arr) && $arr['success'] == true) {
            return 1;
        }else{
            return 0;
        }
                 
        } catch (\Throwable $th) {
            return 0;
        }
        
    }
}
