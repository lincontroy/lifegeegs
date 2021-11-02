<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Language;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $options = array(
            array('id' => '1','key' => 'gateway_section','value' => '{"first_title":"Protect yourself and your customers with advanced fraud detection","second_title":"Detailed reporting for accounting, reconciliation, and audits","first_des":"Lenden’s combination of automated and manual fraud systems protect you from fraudulent transactions and associated chargeback claims.","second_des":"Understand your customers’ purchase patterns and do easy reconciliations with a robust data Dashboard and easy exports.","image":"uploads\\/gateway_section\\/21\\/04\\/1698171749952367.png"}'),
            array('id' => '2','key' => 'auto_enroll_after_payment','value' => 'on'),
            array('id' => '3','key' => 'tawk_to_property_id','value' => '6076c018f7ce1827093a4822'),
            array('id' => '4','key' => 'cron_option','value' => '{"status":"on","days":10,"assign_default_plan":"on","alert_message":"Hi, your plan will expire soon","expire_message":"Your plan is expired!"}'),
            array('id' => '5','key' => 'theme_settings','value' => '{"footer_description":"Lorem ipsum dolor sit amet, consect etur adi pisicing elit sed do eiusmod tempor incididunt ut labore.","newsletter_address":"88 Broklyn Golden Street, New York. USA needhelp@ziston.com","theme_color":"39089809809","new_account_button":"Create Free Account","new_account_url":"/register","social":[{"icon":"ri:facebook-fill","link":"#"},{"icon":"ri:twitter-fill","link":"#"},{"icon":"ri:google-fill","link":"#"},{"icon":"ri:instagram-fill","link":"#"},{"icon":"ri:pinterest-fill","link":"#"}]}'),
            array('id' => '6','key' => 'seo_home','value' => '{"site_name":"Home","matatag":"Home","matadescription":"it is an payment gateway application. you can add your payment gateway keys,id and start using your payment gateway system within 5  within 5 minutes.","twitter_site_title":"home"}'),
            array('id' => '7','key' => 'seo_blog','value' => '{"site_name":"Blog","matatag":"Blog","matadescription":"it is an payment gateway application. in this page you can view all post recently post form the application","twitter_site_title":"Blog"}'),
            array('id' => '8','key' => 'seo_service','value' => '{"site_name":"Service","matatag":"Service","matadescription":"it is an payment gateway application. in this page you can view all details about each services","twitter_site_title":"Service"}'),
            array('id' => '9','key' => 'seo_contract','value' => '{"site_name":"Contract","matatag":"Contract","matadescription":"it is an payment gateway application. in this page you can view all Contract about the application system","twitter_site_title":"Contract"}'),
            array('id' => '10','key' => 'seo_pricing','value' => '{"site_name":"Pricing","matatag":"Pricing","matadescription":"it is an payment gateway application. in this page you can view all Contract about the application system","twitter_site_title":"Pricing"}'),
            array('id' => '11','key' => 'currency_symbol','value' => '$'),
            array('id' => '12','key' => 'hero_section','value' => '{"title":"Payments infrastructure for the internet","des":"Millions of companies of all sizes\\u2014from startups to Fortune 500s\\u2014use Stripe\\u2019s software and APIs to accept payments, send payouts, and manage their businesses online.","start_text":"Start Now","start_url":"/register","contact_text":"Contact Sales","contact_url":"/contact","image":"uploads\\\\/hero_section\\\\/21\\\\/04\\\\/1698167161124161.png"}'),
            array('id' => '13','key' => 'support_email','value' => 'help@amcoders.com')
          );

          Option::insert($options);

          $languages = array(
            array('id' => '1','name' => 'en','position' => NULL,'data' => 'English','status' => '1','created_at' => '2021-05-04 22:25:06','updated_at' => '2021-05-04 22:29:43')
          );

          Language::insert($languages);

          $menu = array(
            array('id' => '1','name' => 'Header','position' => 'header','data' => '[{"text":"Home","href":"/","icon":"","target":"_self","title":""},{"text":"Documentation","icon":"","href":"/docs","target":"_self","title":""},{"text":"Pricing","href":"/pricing","icon":"empty","target":"_self","title":""},{"text":"Blog","href":"/blog","icon":"empty","target":"_self","title":""},{"text":"Services","href":"/service","icon":"empty","target":"_self","title":""},{"text":"Login","href":"/login","icon":"empty","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2021-05-04 22:32:49','updated_at' => '2021-05-04 22:40:10'),
            array('id' => '2','name' => 'Explore','position' => 'footer_left','data' => '[{"text":"About Us","icon":"","href":"/contact","target":"_self","title":""},{"text":"Our Services","icon":"empty","href":"/service","target":"_self","title":""},{"text":"Pricing","icon":"empty","href":"/pricing","target":"_self","title":""},{"text":"Blog","icon":"empty","href":"/blog","target":"_self","title":""},{"text":"Contact Us","icon":"empty","href":"/contact","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2021-05-04 23:09:16','updated_at' => '2021-05-04 23:18:16'),
            array('id' => '3','name' => 'Quick Links','position' => 'footer_right','data' => '[{"text":"My Account","icon":"","href":"/merchant/dashboard","target":"_self","title":""},{"text":"Login","icon":"empty","href":"/login","target":"_self","title":""},{"text":"Register","icon":"empty","href":"/register","target":"_self","title":""},{"text":"Reset Password","icon":"empty","href":"/password/reset","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2021-05-04 23:09:44','updated_at' => '2021-05-04 23:23:42')
          );



          Menu::insert($menu);

    }
}
