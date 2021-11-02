<?php 

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// **---------------------------------------CRON JOB ROUTES START---------------------------------------** //
// Fraud Checker Admin
Route::get('cron/admin/fraudcheck', 'CronController@fraudcheckAdmin')->name('admin.fraud.check');
// Fraud Checker Merchant
Route::get('cron/merchant/fraudcheck', 'CronController@fraudcheckMerchant')->name('merchant.fraud.check');

// Alert after Order Expired
Route::get('cron/alert-user/after/order/expired', 'Admin\OrderController@alertUserAfterExpiredOrder')->name('alert.after.order.expired');

// Alert before Order Expired
Route::get('cron/alert-user/before/order/expired', 'Admin\OrderController@alertUserBeforeExpiredOrder')->name('alert.before.order.expired');

// **---------------------------------------CRON JOB ROUTES END---------------------------------------** //




Route::get('/', 'FrontendController@index')->name('welcome');
Route::get('/blog/{id}', 'FrontendController@blogDetails');
Route::get('/blog', 'FrontendController@blog');
Route::get('/service/{id}', 'FrontendController@service');
Route::get('/service', 'FrontendController@serviceList');
Route::get('/contact', 'FrontendController@contact');
Route::post('/contact-mail', 'FrontendController@sendMailByContactUs');
Route::get('/pricing', 'FrontendController@pricing');
Route::get('/page/{id}', 'FrontendController@pageShow');
Route::get('docs', 'DocumentationController@index')->name('docs');
Route::get('docs/payment/install', 'DocumentationController@payment_install')->name('docs.payment.install');
Route::get('docs/form/generator', 'DocumentationController@form_generator')->name('docs.form.generator');
Route::get('docs/payment/url', 'DocumentationController@payment_url')->name('docs.payment.url');
Route::get('docs/payment/api', 'DocumentationController@payment_api')->name('docs.payment.api');
Route::get('docs/thankyou','DocumentationController@thankyou')->name('docs.thankyou');

Route::get('lang','LanguageController@store')->name('lang.store');

Auth::routes();

//Plan register
Route::get('plan/{planid}', 'HomeController@check')->name('plan.check');
Route::post('/plan/register', 'Merchant\LoginController@plan_register')->name('plan.register');
Route::get('admin/login', 'Admin\LoginController@login')->name('admin.login');


Route::post('/subscribe', 'FrontEndController@subscribe')->name('newsletter');

// **---------------------------------------CRON JOB ROUTES END---------------------------------------** //

Route::get('/checkout/{param}', 'Merchant\RequestController@checkoutUrl')->name('checkout');
Route::get('/checkout', 'Merchant\RequestController@checkoutView')->name('checkout.view');
Route::post('/checkout/payment/view', 'Merchant\RequestController@paymentView')->name('checkout.payment.view');

Route::get('/otp', 'Merchant\LoginController@otp')->name('otp');
Route::post('/otp', 'Merchant\LoginController@otp')->name('otp.resend');
Route::get('/otp/view', 'Merchant\LoginController@otpview')->name('otp.view');
Route::post('/otp/confirmation', 'Merchant\LoginController@otpConfirm')->name('otp.confirmation');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/logout', 'Auth\LoginController@logout', 'logout')->name('admin.logout');
Route::get('/logout', 'Merchant\LoginController@logout', 'logout')->name('logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    // Roles Route
    Route::resource('role', 'RoleController');
    Route::post('roles/destroy', 'RoleController@destroy')->name('roles.destroy');
 
    // Admin Route
    Route::resource('admin', 'AdminController');
    Route::post('/admins/destroy', 'AdminController@destroy')->name('admins.destroy');

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('data/request', 'DashboardController@data')->name('transaction.date.wise.data');
    Route::post('plan/data/', 'DashboardController@plandata')->name('plan.date.wise');

    // System Envrionment Settings Route
    Route::get('setting/env', 'EnvController@index');
    Route::post('env-update', 'EnvController@store')->name('env.store');

    Route::resource('plan', 'PlanController');
    Route::resource('profile', 'ProfileController');
    Route::resource('currency', 'CurrencyController');
    Route::resource('payment-gateway', 'PaymentGatewayController');
    Route::resource('merchant', 'MerchantController');
    Route::post('merchant-send-mail/{id}', 'MerchantController@sendMail');
    Route::get('merchant-login/{id}', 'MerchantController@login')->name('merchant.login');
    Route::resource('order', 'OrderController');
    Route::get('order/active', 'OrderController@index');

    //Report Route
    Route::resource('report', 'ReportController');
    Route::get('order-excel', 'ReportController@excel')->name('order.excel');
    Route::get('order-csv', 'ReportController@csv')->name('order.csv');
    Route::get('order-pdf', 'ReportController@pdf')->name('order.pdf');
    Route::get('report-invoice/{id}', 'ReportController@invoicePdf');
    //User Plan Report
    Route::resource('user-plan-report', 'UserPlanReportController');
    Route::get('user-plan-excel', 'UserPlanReportController@excel')->name('user-plan-report.excel');
    Route::get('user-plan-csv', 'UserPlanReportController@csv')->name('user-plan-report.csv');
    Route::get('user-plan-pdf', 'UserPlanReportController@invoicePdf')->name('user-plan-report.pdf');
    Route::get('user-plan-invoice/{id}', 'UserPlanReportController@invoicePdf');
    Route::get('user-plan', 'UserPlanReportController@userPlan');
    //payment report
    Route::resource('payment-report', 'PaymentReportController');
 
    Route::get('payment-excel', 'PaymentReportController@excel')->name('payment-report.excel');
    Route::get('payment-csv', 'PaymentReportController@csv')->name('payment-report.csv');
    Route::get('payment-pdf', 'PaymentReportController@pdf')->name('payment-report.pdf');
    Route::get('payment-report-invoice/{id}', 'PaymentReportController@invoicePdf');
    
    //Service Section
    Route::resource('frontend/settings/service', 'ServiceController');

    //Quick start Section
    Route::get('frontend/settings/quick-start-section', 'ThemeController@QuickStartSection');
    Route::post('quick-start-section-store', 'ThemeController@QuickStartSectionStore');

    //Gateway Section
    Route::get('frontend/settings/gateway-section', 'ThemeController@gatewaySection');
    Route::post('gateway-section-store', 'ThemeController@gatewaySectionStore');

    //Hero Section
    Route::get('frontend/settings/hero-section', 'ThemeController@heroSection');
    Route::post('hero-section-store', 'ThemeController@heroSectionStore');

    //Transaction Route
    Route::resource('transaction', 'TransactionController');
    Route::resource('blog', 'BlogController');

    Route::resource('page', 'PageController');

    // Language Route
    Route::resource('language', 'LanguageController');
    Route::post('language/set', 'LanguageController@lang_set')->name('language.set');
    Route::post('language/key_store', 'LanguageController@key_store')->name('key_store');

    // Menu Route
    Route::resource('menu', 'MenuController');
    Route::post('/menus/destroy', 'MenuController@destroy')->name('menus.destroy');
    Route::post('menues/node', 'MenuController@MenuNodeStore')->name('menus.MenuNodeStore');

    //Option route
    Route::get('option/edit/{key}', 'OptionController@edit')->name('option.edit');
    Route::post('option/update/{key}', 'OptionController@update')->name('option.update');
    Route::get('option/sco-index', 'OptionController@seoIndex')->name('option.seo-index');
    Route::get('option/seo-edit/{id}', 'OptionController@seoEdit')->name('option.seo-edit');
    Route::put('option/seo-update/{id}', 'OptionController@seoUpdate')->name('option.seo-update');

    Route::post('envupdate','OptionController@env_update')->name('env.update');

    //Theme settings
    Route::get('theme/settings', 'OptionController@settingsEdit')->name('theme.settings');
    Route::put('theme/settings-update/{id}', 'OptionController@settingsUpdate')->name('theme.settings.update');


    //Support Route
    Route::resource('support', 'SupportController');
    Route::post('supportInfo', 'SupportController@getSupportData')->name('support.info');
    Route::post('supportstatus', 'SupportController@supportStatus')->name('support.status');


    
});

Route::group(['prefix' => 'merchant', 'as' => 'merchant.', 'namespace' => 'Merchant', 'middleware' => ['auth', 'merchant']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/keys/update', 'DashboardController@keysupdate')->name('dashboard.keys.update');
    Route::get('/keygenerate/{type}', 'DashboardController@uniqkeyuser')->name('dashboard.keygenerate');
    Route::get('earning/{day}', 'DashboardController@earning')->name('dashboard.earning');
    Route::get('stats', 'DashboardController@stats')->name('dashboard.stats');

    Route::get('/gateways/{id}', 'PlanController@gateways')->name('plan.gateways');
    Route::post('/deposit', 'PlanController@deposit')->name('plan.deposit');
    Route::resource('plan', 'PlanController');
    Route::get('plan-invoice/{id}', 'PlanController@invoicePdf');
    Route::resource('profile', 'ProfileController');
    Route::resource('payment-report', 'PaymentReportController');
    Route::get('payment/success', 'PlanController@success')->name('payment.success');
    Route::get('payment/failed', 'PlanController@failed')->name('payment.failed');
    Route::resource('gateway', 'PaymentGatewayController');
    Route::resource('request', 'RequestController');
    Route::get('request-invoice/{id}', 'RequestController@invoicePdf');
    Route::resource('settings', 'SettingsController');
    //Generate Form route
    Route::get('form', 'FormController@generate')->name('form.generate');

    //Support Route
    Route::resource('support', 'SupportController');

});

//**======================== Payment Gateway Route Group for merchant ====================**//

Route::group(['middleware' => ['auth', 'merchant']], function () {
    Route::get('/payment/paypal', '\App\Lib\Paypal@status');
    Route::post('/stripe/payment', '\App\Lib\Stripe@status')->name('stripe.payment');
    Route::get('/stripe/{from}', '\App\Lib\Stripe@view')->name('stripe.view');
    // Route::get('/payu/payment', '\App\Lib\Payu@status');
    Route::get('/payment/mollie', '\App\Lib\Mollie@status');

    Route::post('/payment/paystack', '\App\Lib\Paystack@status');
    Route::get('/merchant/paystack/{from}', '\App\Lib\Paystack@view')->name('merchant.paystack.view');

    Route::get('/mercadopago/pay', '\App\Lib\Mercado@status')->name('merchant.mercadopago.status');

    Route::get('merchant/tap/view/{from}', '\App\Lib\Tap@view')->name('merchant.tap.view');
    Route::get('/payment/tap/', '\App\Lib\Tap@status')->name('merchant.tap.status');
    Route::post('/payment/tap/authorize', '\App\Lib\Tap@authorize')->name('merchant.tap.authorize');

    Route::get('/razorpay/payment/{from}', '\App\Lib\Razorpay@view')->name('razorpay.view');
    Route::post('merchant/razorpay/status', '\App\Lib\Razorpay@status');
    Route::get('/payment/flutterwave', '\App\Lib\Flutterwave@status');
    Route::get('/payment/thawani', '\App\Lib\Thawani@status');
    Route::get('/payment/instamojo', '\App\Lib\Instamojo@status');
    Route::get('/payment/toyyibpay', '\App\Lib\Toyyibpay@status');
    Route::get('/payment/hyperpay', '\App\Lib\Hyperpay@status');
    Route::get('/merchant/razorpay/payment', '\App\Lib\Hyperpay@view');

    Route::get('/manual/payment', '\App\Lib\CustomGetway@status');

    Route::get('merchant/payu/payment/', '\App\Lib\Payu@view')->name('merchant.payu.view');
    Route::post('merchant/payu/status', '\App\Lib\Payu@status')->name('merchant.payu.status');
});

//**======================  Payment Routes from an external FORM  ====================================**//

Route::post('request/payment', 'Merchant\RequestController@requestform')->name('request.form');

//**=================================  Payment Routes For Customer =================================**//

Route::get('customer/checkout/{token}', 'Merchant\RequestController@apiCheckoutUrl')->name('customer.checkout');
Route::get('customer/checkout/', 'Merchant\RequestController@apiCheckoutView')->name('customer.checkout.view');
Route::post('customer/api/payment', 'Merchant\RequestController@apipayment')->name('customer.api.payment');
Route::get('customer/api/payment/success', 'Merchant\RequestController@apisuccess')->name('customer.api.payment.success');
Route::get('customer/api/payment/failed', 'Merchant\RequestController@apifailed')->name('customer.api.payment.failed');

//Mercado payment gatewat
Route::get('customer/mercadopago/pay', '\App\Lib\Mercado@status')->name('customer.mercadopago.status');
// Manual Payment
Route::get('customer/manual/payment', '\App\Lib\CustomGetway@status');

//Tap
Route::get('customer/tap/view/{from}', '\App\Lib\Tap@view')->name('customer.tap.view');
Route::get('customer/payment/tap/', '\App\Lib\Tap@status')->name('customer.tap.status');
Route::post('customer/tap/authorize', '\App\Lib\Tap@authorize')->name('customer.tap.authorize');

//Payeer
Route::get('payeer/payment/', '\App\Lib\Payeer@test');

//Thawani
Route::get('customer/payment/thawani', '\App\Lib\Thawani@status');

//Payu
Route::get('customer/payu/view', '\App\Lib\Payu@view')->name('customer.payu.view');
Route::post('customer/payu/payment', '\App\Lib\Payu@status')->name('customer.payu.status');

// Route::post('merchant/payu/status', '\App\Lib\Payu@status')->name('merchant.payu.status');

//Razor pay
Route::get('razorpay/payment/{from}', '\App\Lib\Razorpay@view')->name('razorpay.view');
Route::post('customer/razorpay/status', '\App\Lib\Razorpay@status');

//Insta mojo
Route::get('customer/payment/instamojo', '\App\Lib\Instamojo@status');

//Toyyibpay
Route::get('customer/payment/toyyibpay', '\App\Lib\Toyyibpay@status');
//Flutterwave
Route::get('customer/payment/flutterwave', '\App\Lib\Flutterwave@status');

//Mollie
Route::get('customer/payment/mollie', '\App\Lib\Mollie@status');

//Stripe
Route::post('customer/stripe/payment', '\App\Lib\Stripe@status')->name('customer.stripe.payment');
Route::get('customer/stripe/{from}', '\App\Lib\Stripe@view')->name('customer.stripe.view');

// Paypal
Route::get('customer/payment/paypal', '\App\Lib\Paypal@status');

//Paystack
Route::post('customer/payment/paystack', '\App\Lib\Paystack@status');
Route::get('/customer/paystack/{from}', '\App\Lib\Paystack@view')->name('customer.paystack.view');

//Payment Status for customers
Route::get('customer/payment/success', 'Merchant\RequestController@success')->name('customer.payment.success');
Route::get('customer/payment/failed', 'Merchant\RequestController@failed')->name('customer.payment.failed');
Route::get('customer/payment/status', 'Merchant\RequestController@status')->name('customer.payment.status');

