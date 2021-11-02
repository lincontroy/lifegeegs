<?php
namespace App\Lib;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Models\Getway;
class Razorpay {

    protected static $payment_id;

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

    public function view($request_from){
        if(Session::has('razorpay_credentials')){
            $Info=Session::get('razorpay_credentials');
            $gateway = Getway::findOrFail($Info['getway_id']);
            $response=Session::get('razorpay_response');
            return ($request_from == 'customer' || $request_from == 'api') ? 
            view('payment.getway.razorpay',compact('response','Info','gateway')) 
            : view('merchant.plan.payment.razorpay',compact('response','Info','gateway'));
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
        $data['key_id']=$array['key_id'];
        $data['key_secret']=$array['key_secret'];
        $data['payment_mode']='razorpay';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $data['getway_id']=$array['getway_id'];
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        $data['main_amount']=$array['amount'];
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
        $data['request_from'] = $request_from = $array['request_from'];
        $data['payment_type']=$array['payment_type'];
        $data['billName']=$billName;
        $data['name']=$name;
        $data['email']=$email;
        $data['currency']=$currency;
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


        Session::put('razorpay_credentials',$data);
        $payment_info['payment_method'] = "razorpay";
        $payment_info['getway_id'] = $data['getway_id'];
        $payment_info['status'] = 0; 
        $payment_info['is_fallback'] = $data['is_fallback'];
        $payment_info['user_id']=$array['user_id'] ?? '';
        Session::put('payment_info',$payment_info);

       $response=Razorpay::get_response();

       Session::put('razorpay_response',$response);

       if ($request_from == 'customer' || $request_from == 'api') {
        return redirect()->route('razorpay.view', $request_from);
         }elseif ($request_from == 'merchant') {
        return redirect()->route('razorpay.view', $request_from);
        }

    }

    public static function get_response(){
        $array=Session::get('razorpay_credentials');
        $phone=$array['phone'];
        $email=$array['email'];
        $amount=$array['amount'];
        $getway_id=$array['getway_id'];
        $name=$array['name'];
        $billName=$array['billName'];

        $razorpay_credentials=Session::get('razorpay_credentials');


        $api = new Api($razorpay_credentials['key_id'], $razorpay_credentials['key_secret']);
        $referance_id=Str::random(12);
        $order = $api->order->create(array(
            'receipt' => $referance_id,
            'amount' => $amount*100,
            'currency' => $razorpay_credentials['currency'],
        )
        );

         // Return response on payment page
        $response = [
            'orderId' => $order['id'],
            'razorpayId' => $razorpay_credentials['key_id'],
            'amount' => $amount*100,
            'name' => $name,
            'currency' => $razorpay_credentials['currency'],
            'email' => $email,
            'contactNumber' => $phone,
            'address' => "",
            'description' => $billName,
        ];

        return $response;
    }


    public function status(Request $request)
    {
      if(Session::has('razorpay_credentials')){
        $order_info= Session::get('razorpay_credentials');
        $data['request_from'] = $request_from = $order_info['request_from'];
        // Now verify the signature is correct . We create the private function for verify the signature
        $signatureStatus = Razorpay::SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );

      // If Signature status is true We will save the payment response in our database
      // In this tutorial we send the response to Success page if payment successfully made
        if($signatureStatus == true)
        {
            //for success
            $data['payment_id'] = Razorpay::$payment_id;
            $data['payment_method'] = "razorpay";
            $data['getway_id']=$order_info['getway_id'];
            $data['amount'] =$order_info['amount'];
            $data['billName']=$order_info['billName'];
            $data['getway_id'] = $order_info['getway_id'];
            $data['payment_type'] = $order_info['payment_type'];
            $data['amount'] = $order_info['amount'];
            $data['main_amount'] = $order_info['main_amount'];
            $data['charge'] = $order_info['charge'];
            $data['currency'] = $order_info['currency'] ?? '';
            $data['status'] = 1;
            $data['payment_status'] = 1; 
            $data['is_fallback'] = $order_info['is_fallback'];
            if ($request_from == 'customer' || $request_from == 'api') {
                $data['request_id'] = $order_info['request_id'];
                $data['user_id']= $order_info['user_id'];
            }
            Session::put('payment_info',$data);
            Session::forget('razorpay_credentials');
            return redirect(Razorpay::redirect_if_payment_success($request_from));
        }
        else{
            Session::forget('razorpay_credentials');
            return redirect(Razorpay::redirect_if_payment_faild($request_from));
        }

      }
    }

    // In this function we return boolean if signature is correct
    private static function SignatureVerify($_signature,$_paymentId,$_orderId)
    {
        try
        {
            $razorpay_credentials=Session::get('razorpay_credentials');
            // Create an object of razorpay class
            $api = new Api($razorpay_credentials['key_id'], $razorpay_credentials['key_secret']);
            $attributes  = array('razorpay_signature'  => $_signature,  'razorpay_payment_id'  => $_paymentId ,  'razorpay_order_id' => $_orderId);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            Razorpay::$payment_id=$_paymentId;
            return true;
        }
        catch(\Exception $e)
        {
            // If Signature is not correct its give a excetption so we use try catch
            return false;
        }
    }

    public static function isfraud($creds){
        $payment_id = $creds['payment_id'];
        $key = $creds['key_id'];
        $secret = $creds['key_secret'];
        try {
            $api = new Api($key, $secret);
            $payment = $api->payment->fetch($payment_id);
            if ($payment) {
               return $payment['status'] === "captured" ? 1 : 0;
            }
        } catch (\Throwable $th) {
            return 0;
        }
        
    }


}


?>
