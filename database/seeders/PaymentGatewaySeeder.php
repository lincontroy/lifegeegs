<?php

namespace Database\Seeders;

use App\Models\Currencygetway;
use App\Models\Getway;
use App\Models\Usergetway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getways = array(
            array('id' => '1','name' => 'Paypal','logo' => 'uploads/payment_gateway/paypal.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Paypal','currency_name' => 'USD','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '0','data' => '{"client_id":null,"client_secret":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '2','name' => 'Stripe','logo' => 'uploads/payment_gateway/stripe.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Stripe','currency_name' => 'usd','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '0','data' => '{"publishable_key":null,"secret_key":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '3','name' => 'Mollie','logo' => 'uploads/payment_gateway/mollie.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Mollie','currency_name' => 'usd','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '0','data' => '{"api_key":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '4','name' => 'PayStack','logo' => 'uploads/payment_gateway/paystack.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Paystack','currency_name' => 'usd','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '0','data' => '{"public_key":null,"secret_key":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '5','name' => 'Razorpay','logo' => 'uploads/payment_gateway/razorpay.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Razorpay','currency_name' => 'INR','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '0','data' => '{"key_id":null,"key_secret":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '6','name' => 'Instamojo','logo' => 'uploads/payment_gateway/instamojo.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Instamojo','currency_name' => 'INR','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '1','data' => '{"x_api_key":null,"x_auth_token":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '7','name' => 'ToyyibPay','logo' => 'uploads/payment_gateway/toyyibpay.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Toyyibpay','currency_name' => 'MR','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '1','data' => '{"user_secret_key":null,"cateogry_code":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '8','name' => 'FlutterWave','logo' => 'uploads/payment_gateway/flutterwave.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Flutterwave','currency_name' => 'NGN','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '1','data' => '{"public_key":null,"secret_key":null,"encryption_key":null,"payment_options":"card"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '9','name' => 'Payu','logo' => 'uploads/payment_gateway/payu.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Payu','currency_name' => 'INR','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '1','data' => '{"merchant_key":null,"merchant_salt":null,"auth_header":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '10','name' => 'Thawani','logo' => 'uploads/payment_gateway/thawani.png','rate' => '0.38','charge' => '1','namespace' => 'App\\Lib\\Thawani','currency_name' => 'OMR','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '1','phone_required' => '1','data' => '{"secret_key":null,"publishable_key":null}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-15 02:44:46'),

            array('id' => '11','name' => 'Manual','logo' => 'uploads/payment_gateway/manual.png','rate' => '1','charge' => '1','namespace' => 'App\\Lib\\CustomGetway','currency_name' => 'USD','is_auto' => '0','image_accept' => '1','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '0','phone_required' => '0','data' => '{"instruction":null}','created_at' => '2021-04-15 04:12:12','updated_at' => '2021-04-15 04:12:12'),

            array('id' => '12','name' => 'Mercadopago','logo' => 'uploads/payment_gateway/mercadopago.png','rate' => '1.2','charge' => '1','namespace' => 'App\\Lib\\Mercado','currency_name' => 'USD','is_auto' => '1','image_accept' => '0','test_mode' => '1','customer_status' => '1','global_status' => '1','fraud_checker' => '0','phone_required' => '0','data' => '{"secret_key":null,"public_key":null}','created_at' => '2021-04-15 05:40:51','updated_at' => '2021-04-15 07:17:13'),

            array('id' => '13','name' => 'Free','logo' => NULL,'rate' => '1','charge' => '0','namespace' => '','currency_name' => '','is_auto' => '0','image_accept' => '0','test_mode' => '1','customer_status' => '0','global_status' => '1','fraud_checker' => '0','phone_required' => '0','data' => '','created_at' => NULL,'updated_at' => NULL)
          );
          
        Getway::insert($getways);
    }
}
