<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use File;
use Str;
class OptionController extends Controller
{
    public function seoIndex()
    {
        abort_if(!Auth()->user()->can('option'), 401);
        $data = Option::where('key', 'seo_home')->orWhere('key', "seo_blog")->orWhere('key', "seo_service")->orWhere('key', "seo_contract")->orWhere('key', "seo_pricing")->get();
        return view('admin.option.seo-index', compact('data'));
    }

    public function seoEdit($id)
    {
        abort_if(!Auth()->user()->can('option'), 401);
        $data = Option::where('id', $id)->first();
        return view('admin.option.seo-edit', compact('data'));
    }

    public function seoUpdate(Request $request, $id)
    {
        $request->validate([
            'site_name'          => 'required',
            'matatag'            => 'required',
            'twitter_site_title' => 'required',
            'matadescription'    => 'required',
        ]);

        $option = Option::where('id', $id)->first();

        $data = [
            "site_name"          => $request->site_name,
            "matatag"            => $request->matatag,
            "twitter_site_title" => $request->twitter_site_title,
            "matadescription"    => $request->matadescription,
        ];
        $value = json_encode($data);
        $option->value = $value;
        $option->save();
        return response()->json('Successfully Updated');
    }

    public function edit($key)
    {
        abort_if(!Auth()->user()->can('option'), 401);
        if ($key == 'cron_option') {
            $option = Option::where('key', $key)->first();
            return view('admin.option.cron', compact('option'));
        }
        if ($key == 'env') {
            $countries= base_path('resources/lang/langlist.json');
            $countries= json_decode(file_get_contents($countries),true);
            return view('admin.option.env',compact('countries'));
        }

         else {
            $auto_enroll_after_payment = Option::where('key', 'auto_enroll_after_payment')->first();
            $tawk_to_property_id = Option::where('key', 'tawk_to_property_id')->first();
            $currency = Option::where('key', 'currency')->first();
            $tax = Option::where('key', 'tax')->first();
            $invoice_prefix = Option::where('key', 'invoice_prefix')->first();
            $support_email = Option::where('key', 'support_email')->first();

            return view('admin.option.option', compact('auto_enroll_after_payment', 'tawk_to_property_id', 'currency', 'tax', 'invoice_prefix', 'support_email'));
        }
        abort(404);

    }

    public function update(Request $request, $key)
    {
        if ($key == 'cron_option') {
            $request->validate([
                'status'              => 'required',
                'days'                => 'required',
                'assign_default_plan' => 'required',
                'alert_message'       => 'required',
                'expire_message'      => 'required',
            ]);

            $option = Option::where('key', $key)->first();

            $data = [
                "status"              => $request->status,
                "days"                => $request->days,
                "assign_default_plan" => $request->assign_default_plan,
                "alert_message"       => $request->alert_message,
                "expire_message"      => $request->expire_message,
            ];
            $value = json_encode($data);
            $option->value = $value;
            $option->save();
        } else {
            $request->validate([
                'logo'    => 'image|max:500',
                'favicon' => 'mimes:ico',

            ]);
            $auto_enroll_after_payment = Option::where('key', 'auto_enroll_after_payment')->first();
            $auto_enroll_after_payment->value = $request->auto_enroll_after_payment;
            $auto_enroll_after_payment->save();

            $tawk_to_property_id = Option::where('key', 'tawk_to_property_id')->first();
            $tawk_to_property_id->value = $request->tawk_to_property_id;
            $tawk_to_property_id->save();

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logo = 'logo.png';
                $thum_image_path = 'uploads/';
                $file->move($thum_image_path, $logo);
            }
            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                $favicon = 'favicon.ico';
                $thum_image_path = 'uploads/';
                $file->move($thum_image_path, $favicon);
            }

        }

        return response()->json('Successfully Updated');

    }

    public function settingsEdit()
    {
        abort_if(!Auth()->user()->can('option'), 401);
        $theme = Option::where('key', 'theme_settings')->first();
        $currency_symbol = Option::where('key','currency_symbol')->first();
        return view('admin.option.theme', compact('theme','currency_symbol'));
    }

    public function settingsUpdate($id, Request $request)
    {
        $request->validate([
            'footer_description' => 'required',
            'newsletter_address' => 'required',
            'new_account_button' => 'required',
            'new_account_url' => 'required',
            'new_account_button' => 'required',
            'currency_symbol' => 'required'
        ]);

        foreach ($request->social as $value) {
            $social[] = [
                'icon' => $value['icon'],
                'link' => $value['link'],
            ];
        };

        // logo check
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_name = 'logo.png';
            $logo_path = 'uploads/';
            $logo->move($logo_path, $logo_name);

        }

        if ($request->hasFile('docs_logo')) {
            $logo = $request->file('docs_logo');
            $logo_name = 'docs-logo.png';
            $logo_path = 'uploads/';
            $logo->move($logo_path, $logo_name);

        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $favicon_name = 'favicon.ico';
            $favicon_path = 'uploads/';
            $favicon->move($favicon_path, $favicon_name);
        }

        $data = [
            'footer_description' => $request->footer_description,
            'newsletter_address' => $request->newsletter_address,
            'new_account_button' => $request->new_account_button,
            'new_account_url'    => $request->new_account_url,
            'social'             => $social,
        ];

        $currency_symbol = Option::where('key','currency_symbol')->first();
        if(!$currency_symbol)
        {
            $currency_symbol = new Option();
            $currency_symbol->key = 'currency_symbol';
        }
        $currency_symbol->value = $request->currency_symbol;
        $currency_symbol->save();

        $theme = Option::findOrFail($id);
        $theme->key = 'theme_settings';
        $theme->value = json_encode($data);
        $theme->save();
        return response()->json('Theme Settings Updated!!');
    }

     public function env_update(Request $request)
    {
        
         $APP_NAME = Str::slug($request->APP_NAME);
$txt ="APP_NAME=".$APP_NAME."
APP_ENV=".$request->APP_ENV."
APP_KEY=".$request->APP_KEY."
APP_DEBUG=".$request->APP_DEBUG."
APP_URL=".$request->APP_URL."


LOG_CHANNEL=".$request->LOG_CHANNEL."
LOG_LEVEL=".$request->LOG_LEVEL."\n
DB_CONNECTION=".env("DB_CONNECTION")."
DB_HOST=".env("DB_HOST")."
DB_PORT=".env("DB_PORT")."
DB_DATABASE=".env("DB_DATABASE")."
DB_USERNAME=".env("DB_USERNAME")."
DB_PASSWORD=".env("DB_PASSWORD")."\n
BROADCAST_DRIVER=".$request->BROADCAST_DRIVER."
CACHE_DRIVER=".$request->CACHE_DRIVER."
QUEUE_CONNECTION=".$request->QUEUE_CONNECTION."
SESSION_DRIVER=".$request->SESSION_DRIVER."
SESSION_LIFETIME=".$request->SESSION_LIFETIME."\n
REDIS_HOST=".$request->REDIS_HOST."
REDIS_PASSWORD=".$request->REDIS_PASSWORD."
REDIS_PORT=".$request->REDIS_PORT."\n
QUEUE_MAIL=".$request->QUEUE_MAIL."
MAIL_MAILER=".$request->MAIL_MAILER."
MAIL_HOST=".$request->MAIL_HOST."
MAIL_PORT=".$request->MAIL_PORT."
MAIL_USERNAME=".$request->MAIL_USERNAME."
MAIL_PASSWORD=".$request->MAIL_PASSWORD."
MAIL_ENCRYPTION=".$request->MAIL_ENCRYPTION."
MAIL_FROM_ADDRESS=".$request->MAIL_FROM_ADDRESS."
MAIL_TO=".$request->MAIL_TO."
MAIL_NOREPLY=".$request->MAIL_NOREPLY."
MAIL_FROM_NAME=".Str::slug($request->MAIL_FROM_NAME)."\n
DO_SPACES_KEY=".$request->DO_SPACES_KEY."
DO_SPACES_SECRET=".$request->DO_SPACES_SECRET."
DO_SPACES_ENDPOINT=".$request->DO_SPACES_ENDPOINT."
DO_SPACES_REGION=".$request->DO_SPACES_REGION."
DO_SPACES_BUCKET=".$request->DO_SPACES_BUCKET."\n
NOCAPTCHA_SECRET=".$request->NOCAPTCHA_SECRET."
NOCAPTCHA_SITEKEY=".$request->NOCAPTCHA_SITEKEY."

MAILCHIMP_DRIVER=".$request->MAILCHIMP_DRIVER."
MAILCHIMP_APIKEY=".$request->MAILCHIMP_APIKEY."
MAILCHIMP_LIST_ID=".$request->MAILCHIMP_LIST_ID."

CONTENT_EDITOR=".$request->content_editor."

TIMEZONE=".$request->TIMEZONE.""."
DEFAULT_LANG=".$request->DEFAULT_LANG."\n
";
       File::put(base_path('.env'),$txt);
       return response()->json(['System Updated']);


    }

}
