@extends('layouts.docs.app')

@section('content')
<div class="dashboard-main-area">
    <div class="dashboard-title">
        <h2>{{ config('app.name') }}{{ __(' Documentation') }}</h2>
    </div>
    <div class="dashboard-des">
        <p>{{ __('Welcome to the '.config('app.name').' Documentation where you’ll learn how to install payment gateway in Merchant Panel & many more.') }}</p>
    </div>
    <div class="quickstart-area">
        <div class="quickstart-title mt-5">
            <h4>{{ __('Quick Start') }}</h4>
        </div>
        <div class="quick-start-card">
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('docs.payment.install') }}">
                        <div class="single-quick-start mb-30">
                            <div class="quick-start-img">
                                <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/quick-step/1.png') }}" alt="">
                            </div>
                            <div class="quick-start-title">
                                <h6>{{ __('Payment gateway Install(Merchant Panel)') }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('docs.form.generator') }}">
                        <div class="single-quick-start mb-30">
                            <div class="quick-start-img">
                                <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/quick-step/2.png') }}" alt="">
                            </div>
                            <div class="quick-start-title">
                                <h6>{{ __('Payments through Merchant Generated form') }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('docs.payment.url') }}">
                        <div class="single-quick-start mb-30">
                            <div class="quick-start-img">
                                <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/quick-step/3.png') }}" alt="">
                            </div>
                            <div class="quick-start-title">
                                <h6>{{ __('Payments through one time URL (Merchant Generated)') }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('docs.payment.api') }}">
                        <div class="single-quick-start mb-30">
                            <div class="quick-start-img">
                                <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/quick-step/4.png') }}" alt="">
                            </div>
                            <div class="quick-start-title">
                                <h6>{{ __('Payments through API (Demo with Postman)') }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="next-page-link-area mt-100 mb-100">
        <div class="next-page-link f-right">
            <a href="{{ route('docs.payment.install') }}">{{ __('Payment gateway Install(Merchant Panel) ') }}<span class="iconify" data-icon="eva:arrow-ios-forward-outline" data-inline="false"></span></a>
        </div>
    </div>
</div>
@endsection