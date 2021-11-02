@extends('layouts.docs.app')

@section('content')
<div class="dashboard-main-area">
    <div class="dashboard-title">
        <h2>{{ __('Payment gateway Install') }}</h2>
    </div>
    <div class="dashboard-des">
        <p>{{ __('You can install your own payment gateway in Merchant Panel. Just follow two step for this. Go to:') }} <strong>"{{ __('yourdomain/merchant/gateway') }}"</strong>.</p>
    </div>
    <div class="main-container-area">
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 1: Select payment gateway to install with your credentials.') }}</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/payment-install/1.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="step-area mt-5">
            <div class="step-title">
                <h5>{{ __('Step 2: Enter your gateway information including credentials') }}:</h5>
            </div>
            <div class="step-body">
                <div class="step-img">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/payment-install/2.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="next-page-link-area mt-100 mb-100">
        <div class="next-page-link f-right">
            <a href="{{ route('docs.form.generator') }}">{{ __('Payments through Merchant Generated form') }} <span class="iconify" data-icon="eva:arrow-ios-forward-outline" data-inline="false"></span></a>
        </div>
    </div>
</div>
@endsection