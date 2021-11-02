@extends('layouts.docs.app')

@section('content')
<div class="dashboard-main-area">
    <div class="dashboard-title">
        <h2>{{ __('Payments through Merchant Generated form') }}.</h2>
    </div>
    <div class="dashboard-des">
        <p>{{ __('To create the html form for users click form generator from the side menu then fill up the desired values if necessary. Then click on generate button.') }}</p>
    </div>
    <div class="main-container-area">
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 1: Go to "yourdomain/merchant/form"') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/form_generate/1.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 2: Now you can click copy to copy the html code and use it on your project html file.') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/form_generate/2.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 3: Now user can fillup the form and submit.') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/form_generate/3.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 4: After submit select the payment gateway.') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/form_generate/4.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 5: Enter your credit card info if it requires.') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/form_generate/5.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 5: If payment is successful you will be redirected to success page or if merchant added the fallback url then you will be redirected to desired website:') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/form_generate/6.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="next-page-link-area mt-100 mb-100">
        <div class="next-page-link f-right">
            <a href="{{ route('docs.payment.url') }}">{{ __('Payments through one time URL (Merchant Generated)') }} <span class="iconify" data-icon="eva:arrow-ios-forward-outline" data-inline="false"></span></a>
        </div>
    </div>
</div>
@endsection