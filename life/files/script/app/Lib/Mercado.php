<?php

namespace App\Lib;

use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;

use MercadoPago;

class Mercado
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


    public static function make_payment($array)
    {
        $currency = $array['currency'];
        $email = $array['email'];
        $amount = $array['pay_amount'];
        $name = $array['name'];
        $billName = $array['billName'];

        $data['secret_key'] = $array['secret_key'];
        $data['public_key'] = $array['public_key'];
        $data['payment_mode'] = 'mercadopago';
        $test_mode = $array['test_mode'];
        $data['test_mode'] = $test_mode;
        $data['request_from'] = $request_from = $array['request_from'];
        $data['amount'] = $amount;
        $data['charge'] = $array['charge'];
        $data['phone'] = $array['phone'];
        $data['getway_id'] = $array['getway_id'];
        $data['main_amount'] = $array['amount'];
        $data['payment_type'] = $array['payment_type'];
        $data['billName'] = $billName;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['currency'] = $currency;
        $data['is_fallback'] = $array['is_fallback'] ?? 0;
        $data['request_id']=$array['request_id'] ?? '';
        $data['user_id']=$array['user_id'] ?? '';

        if ($test_mode == 0) {
            $data['env'] = false;
            $test_mode = false;
        } else {
            $data['env'] = true;
            $test_mode = true;
        }

        $payment_info['payment_method'] = "mercado";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);

        try {
            //Payment
            MercadoPago\SDK::setAccessToken($data['secret_key']);
            $payment = new MercadoPago\Payment();
            $preference = new MercadoPago\Preference();
            $payer = new MercadoPago\Payer();
            $payer->name = $name;
            $payer->email = $email;
            $payer->date_created = Carbon::now();

            if ($request_from == 'customer' || $request_from == 'api') {
                $url = route('customer.mercadopago.status');
            } else {
                $url = route('merchant.mercadopago.status');
            }
             
            $preference->back_urls = array(
                "success" => $url,
                "failure" => Mercado::redirect_if_payment_faild($request_from),
                "pending" => $url,
            );

            $preference->auto_return = "approved";

            // Create a preference item
            $item = new MercadoPago\Item();
            $item->title = $billName;
            $item->quantity = 1;
            $item->unit_price = $amount;
            $preference->items = array($item);
            $preference->payer = $payer;
            $preference->save();


            $data['preference_id'] = $preference->id;
            $redirectUrl = $test_mode == 1  ? $preference->sandbox_init_point : $preference->init_point;
            
            Session::put('mercadopago_credentials', $data);
            return redirect($redirectUrl);

        } catch (\Throwable $th) {
            Mercado::redirect_if_payment_success($request_from);
        }
        
    }


    public function status()
    {
        if (!Session::has('mercadopago_credentials')) {
            return abort(404);
        }
        $response = Request()->all();

        $info = Session::get('mercadopago_credentials');

        $data['request_from'] = $request_from = $info['request_from'];

        if ($response['status'] == 'approved' || $response['status'] == 'pending') {
            $data['payment_id'] = $response['payment_id'];
            $data['payment_method'] = "mercadopago";
            $data['getway_id'] = $info['getway_id'];
            $data['payment_type'] = $info['payment_type'];
            $data['amount'] = $info['amount'];
            $data['main_amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['currency'] = $info['currency'] ?? '';
            $data['status'] = 1;
            $data['payment_status'] = $response['status'] == 'pending' ? 2 : 1;
            $data['is_fallback'] = $info['is_fallback'];

            if ($request_from == 'customer' || $request_from == 'api') {
                $data['request_id'] = $info['request_id'];
                $data['user_id'] = $info['user_id'];
            }
            Session::forget('mercadopago_credentials');
            Session::put('payment_info', $data);
            return redirect(Mercado::redirect_if_payment_success($request_from));
        }else{
            Session::forget('flutterwave_credentials');
            return redirect(Mercado::redirect_if_payment_faild($request_from));
        }
    }

}
