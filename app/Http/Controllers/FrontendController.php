<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractUsRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ContactUsPageMail;
use App\Models\Option;
use App\Models\Plan;
use App\Models\Term;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Newsletter;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {
            try {
            DB::select('SHOW TABLES');
            
            $option = Option::where('key', 'hero_section')->first();
            $heroSectionData = json_decode($option->value ?? null);
            $sections = Term::with('termMeta')->where([['type', 'service'],['status',1]])->latest()->take(3)->get();
            $quickStart = Term::with('quickStart')->where('type', 'quick_start')->where('status',1)->first();
            $optionSecond = Option::where('key', 'gateway_section')->first();
            $getawaySection = json_decode($optionSecond->value ?? null);
            $plans = Plan::where([['status', 1], ['is_default', 0]])->latest()->get();
            $blogs = Term::with('excerpt', 'description', 'thum_image', 'user')->where([['type', 'blog'],['status',1]])->latest()->limit(3)->get();

           

            $theme = Option::where('key', 'theme_settings')->first();
            $seo = Option::where('key', 'seo_home')->first();
            $jsonSeo = json_decode($seo->value ?? null);

            SEOMeta::setTitle($jsonSeo->site_name);
            SEOMeta::setDescription($jsonSeo->matadescription);

            JsonLdMulti::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
            JsonLdMulti::setDescription($jsonSeo->matadescription ?? null);
            JsonLdMulti::addImage(asset('uploads/logo.png'));

            SEOMeta::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
            SEOMeta::setDescription($jsonSeo->matadescription ?? null);
            SEOMeta::addKeyword($jsonSeo->matatag ?? null);

            SEOTools::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
            SEOTools::setDescription($jsonSeo->matadescription ?? null);

            SEOTools::opengraph()->addProperty('keywords', $jsonSeo->matatag ?? null);
            SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
            SEOTools::twitter()->setTitle($jsonSeo->site_name ?? env('APP_NAME'));
            SEOTools::twitter()->setSite($jsonSeo->twitter_site_title ?? null);
            SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

            return view('frontend.index', compact('heroSectionData', 'sections', 'quickStart', 'getawaySection', 'blogs', 'plans'));
        } catch (\Exception $e) {
            return redirect()->route('install');
        }

       
    }
    /**
     * $sco for get data form option table
     * than decoded the json data form $sco var
     * JsonLdMulti , SEOMeta , SEOTools, all us
     */

    public function contact()
    {
        //seo related data send using
        $seo = Option::where('key', 'seo_contract')->first();
        $jsonSeo = json_decode($seo->value ?? null);
        JsonLdMulti::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($jsonSeo->matadescription ?? null);
        JsonLdMulti::addImage(asset('uploads/logo.png'));

        SEOMeta::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($jsonSeo->matadescription ?? null);
        SEOMeta::addKeyword($jsonSeo->matatag ?? null);

        SEOTools::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($jsonSeo->matadescription ?? null);

        SEOTools::opengraph()->addProperty('keywords', $jsonSeo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
        SEOTools::twitter()->setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($jsonSeo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

        return view('frontend.contact.contact');
    }

    public function sendMailByContactUs(ContractUsRequest $request)
    {
        if(env('NOCAPTCHA_SECRET') != null){
            $messages = [
                'g-recaptcha-response.required' => 'You must check the reCAPTCHA.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
            ];
            
            $validator = \Validator::make($request->all(), [
                'g-recaptcha-response' => 'required|captcha'
            ], $messages);
            
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }

        $validated = $request->validate([
            'email' => 'required|email|max:30',
            'name' => 'required|max:20',
            'subject' => 'required|max:100',
            'message' => 'required|max:500',
        ]);

        $sendTo = $_ENV['MAIL_FROM_ADDRESS'];
        $data = [
            'sendTo'  => $sendTo,
            'email'   => $request->email,
            'name'    => $request->name,
            'subject' => $request->subject,
            'message' => $request->message,
            'type'    => 'contact_mail',
        ];
        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        } else {
            Mail::to($sendTo)->send(new ContactUsPageMail($data));
        }
        \Session::flash('success','Mail Sent Successfully..!!');
        return back();
    }

    public function pricing()
    {
        $seo = Option::where('key', 'seo_pricing')->first();
        $jsonSeo = json_decode($seo->value ?? null);
        JsonLdMulti::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($jsonSeo->matadescription ?? null);
        JsonLdMulti::addImage(asset('uploads/logo.png'));

        SEOMeta::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($jsonSeo->matadescription ?? null);
        SEOMeta::addKeyword($jsonSeo->matatag ?? null);

        SEOTools::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($jsonSeo->matadescription ?? null);
        SEOTools::opengraph()->addProperty('keywords', $jsonSeo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
        SEOTools::twitter()->setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($jsonSeo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

        $plans = Plan::where([['status', 1], ['is_default', 0]])->get();
        return view('frontend.pricing.pricing', compact('plans'));
    }

    /**
     * this method is useing for show hole service list to show in content of frontend
     */

    public function serviceList()
    {
        $seo = Option::where('key', 'seo_service')->first();
        $jsonSeo = json_decode($seo->value ?? null);
        JsonLdMulti::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($jsonSeo->matadescription ?? null);
        JsonLdMulti::addImage(asset('uploads/logo.png'));

        SEOMeta::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($jsonSeo->matadescription ?? null);
        SEOMeta::addKeyword($jsonSeo->matatag ?? null);

        SEOTools::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($jsonSeo->matadescription ?? null);
        SEOTools::opengraph()->addProperty('keywords', $jsonSeo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
        SEOTools::twitter()->setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($jsonSeo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

        $sections = Term::with('termMeta')->where([['type', 'service'],['status',1]])->latest()->get();
        return view('frontend.service.service-list', compact('sections'));
    }

    /**
     * this method is useing for view all blog list
     * var $seo is the related data for this page seo
     * var $jsonSeo for decode the json data form var $seo
     * var $latest_blogs is for show the latest data of all blogs
     * var $all_blogs is the list of all blogs with pagination
     *
     * $request for get method
     *
     */

    public function blog(Request $request)
    {
        $seo = Option::where('key', 'seo_blog')->first();
        $jsonSeo = json_decode($seo->value ?? null);
        JsonLdMulti::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($jsonSeo->matadescription ?? null);
        JsonLdMulti::addImage(asset('uploads/logo.png'));

        SEOMeta::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($jsonSeo->matadescription ?? null);
        SEOMeta::addKeyword($jsonSeo->matatag ?? null);

        SEOTools::setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($jsonSeo->matadescription ?? null);

        SEOTools::opengraph()->addProperty('keywords', $jsonSeo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
        SEOTools::twitter()->setTitle($jsonSeo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($jsonSeo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

        $all_blogs = Term::with('excerpt')->where('type', 'blog')->where('status',1);
        $latest_blogs = $all_blogs->latest()->limit(10)->get();
        SEOMeta::setTitle('Blog');
        SEOMeta::setDescription('it is an payment gateway application. in this page you can view all post recently post form the application');
        if ($request->text_search) {
            $q = $request->text_search;
            $all_blogs = $all_blogs->where('title', 'LIKE', "%$q%")->paginate(6);
            return view('frontend.blog.blog', compact('all_blogs', 'latest_blogs'));
        } else {
            $all_blogs = $all_blogs->paginate(6);
            return view('frontend.blog.blog', compact('all_blogs', 'latest_blogs'));
        }
    }

    /**
     * this method use for view each blog details of the content
     * var $id is the slug for the blog post
     *
     * seometa,opengraph,jsonld,jsonldmulti all this for sco related data
     * return the view with all data
     */

    public function blogDetails(string $id)
    {
        $blogDetails = Term::with('thum_image', 'description', 'excerpt')->where('type', 'blog')->where('slug', $id)->where('status',1)->first();
        abort_if(empty($blogDetails),404);

        $all_blogs = Term::with('excerpt')->where('type', 'blog')->where('status',1);
        $latest_blogs = $all_blogs->latest()->limit(10)->get();

        SEOMeta::setTitle($blogDetails->title);
        SEOMeta::setDescription($blogDetails->excerpt->value ?? null);

        OpenGraph::setDescription($blogDetails->excerpt->value ?? null);
        OpenGraph::setTitle($blogDetails->title);
        OpenGraph::addImage([$blogDetails->thum_image->value, 'size' => 300] ?? abort(404));

        JsonLd::setTitle($blogDetails->title);
        JsonLd::setDescription($blogDetails->excerpt->value ?? null);
        JsonLd::addImage(asset($blogDetails->thum_image->value) ?? abort(404));

        JsonLdMulti::setTitle($blogDetails->title);
        JsonLdMulti::setDescription($blogDetails->excerpt->value ?? null);

        return view('frontend.blog.blog-details', compact('blogDetails', 'latest_blogs'));
    }

    /**
     * this method use for view each service of the content
     * var $id is the slug for the service
     * seometa,opengraph,jsonld,jsonldmulti all this for sco related data
     * return the view with all data
     */
    public function service(string $id)
    {
        $seo = Option::where('key', 'seo_service')->first();
        $jsonSeo = json_decode($seo->value ?? null);
        $service = Term::with('termMeta')->where([['slug', $id],['type', 'service'],['status',1]])->first();
        abort_if(empty($service),404);
        $jsonSection = json_decode($service->termMeta->value ?? '');

        SEOMeta::setTitle($service->title);
        SEOMeta::setDescription($jsonSection->des ?? null);

        OpenGraph::setDescription($jsonSection->des ?? null);
        OpenGraph::setTitle($service->title);
        OpenGraph::addImage([$jsonSection->image, 'size' => 300] ?? abort(404));

        JsonLd::setTitle($service->title);
        JsonLd::setDescription($jsonSection->des ?? null);
        JsonLd::addImage(asset($jsonSection->image) ?? abort(404));

        JsonLdMulti::setTitle($service->title);
        JsonLdMulti::setDescription($jsonSection->des ?? null);

        return view('frontend.service.service', compact('service'));
    }
    /**
     * this method using to show all page content form backend page module
     * $id is the slug for the page module each content
     */
    public function pageShow(string $id)
    {
        $data = Term::with('excerpt', 'description')->where([['slug', $id],['status',1]])->first();
        abort_if(empty($data),404);
        
        SEOMeta::setTitle($data->title);
        SEOMeta::setDescription($data->excerpt->value ?? null);

        OpenGraph::setDescription($data->excerpt->value ?? null);
        OpenGraph::setTitle($data->title);

        JsonLd::setTitle($data->title);
        JsonLd::setDescription($data->excerpt->value ?? null);

        JsonLdMulti::setTitle($data->title);
        JsonLdMulti::setDescription($data->excerpt->value ?? null);

        return view('frontend.page.page', compact('data'));
    }

    //News letter subscription
    public function subscribe(Request $request)
    {
        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribe($request->email);
        } else {
            return response()->json('Already Subscribed');
        }
        return response()->json('Subscribe Successful');
    }
}
