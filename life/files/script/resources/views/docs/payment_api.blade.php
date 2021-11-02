@extends('layouts.docs.app')

@section('content')
<div class="dashboard-main-area">
    <div class="dashboard-title">
        <h2>{{ __('Payments through API (Demo with Postman)') }}</h2>
    </div>
    <div class="postman-route-type">
        <h5><span class="route-type">POST</span> generate checkout link for make payment</h5>
    </div>
    <div class="route-url-link">
        <p>{{ url('/') }}/api/request</p>
    </div>
    <div class="postman-request-data-send-card">
        <div class="request-data-header">
            <span>Headers</span>
        </div>
        <div class="request-data-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>Accept</td>
                        <td>application/json</td>
                    </tr>
                    <tr>
                        <td>Content-Type</td>
                        <td>application/json</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="postman-request-data-send-card">
        <div class="request-data-header">
            <span>BODY <span class="small">formdata</span></span>
        </div>
        <div class="request-data-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>private_key</td>
                        <td>Merchant_private_key</td>
                    </tr>
                    <tr>
                        <td>currency</td>
                        <td>Merchant_currency</td>
                    </tr>
                    <tr>
                        <td>is_fallback</td>
                        <td>Accept(1 OR 0) <ul><li>1 = It will return fallback URl.</li><li>0 = It willn't return fallback URl.</li></ul></td>
                    </tr>
                    <tr>
                        <td>fallback_url</td>
                        <td>http://domain.com/status <ul><li>is_fallback = 1 then it will require.</li></ul></td>
                    </tr>
                    <tr>
                        <td>is_test</td>
                        <td>Accept(1 OR 0) <ul><li>1 = Sandbox Mode</li><li>0 = Live Mode</li></ul></td>
                    </tr>
                    <tr>
                        <td>amount</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>purpose</td>
                        <td>testing purpose</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="dashboard-des">
        <p>{{ __('In body add private_key,currency,is_fallback,url,is_test,amount as key and their values from the credentials of merchant profile.') }}</p>
    </div>
    <div class="main-container-area">
        <div class="step-area mt-5">
            <div class="step-body">
                <div class="step-img">
                    
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/rest_api/4.png') }}" alt=""><br><br><br>
                    <h4>Checkout Page:</h4><br>
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/rest_api/5.png') }}" alt=""><br><br><br>
                    <h4>Success Response:</h4><br>
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/rest_api/6.png') }}" alt=""><br><br><br>
                    <h4>Failed:</h4><br>
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/rest_api/7.png') }}" alt=""><br><br><br>
                    <h4>Postman Documentation:</h4>
                    <a target="_blank" href="https://documenter.getpostman.com/view/15092464/TzRUCTDq">https://documenter.getpostman.com/view/15092464/TzRUCTDq</a>
                </div>
            </div>
        </div>
    </div>
    <div class="next-page-link-area mt-100 mb-100">
        <div class="next-page-link f-right">
            <a href="{{ route('docs.thankyou') }}">{{ __('Thank You') }} <span class="iconify" data-icon="eva:arrow-ios-forward-outline" data-inline="false"></span></a>
        </div>
    </div>
</div>
@endsection