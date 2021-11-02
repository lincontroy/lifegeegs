@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Razorpay Payment') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Razorpay Payment') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area start -->
</div>
@endsection

@section('content')
<div class="dashboard-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-container checkout-main-area">
                    <div class="table-responsive">
                        <table class="table table-checkout">
                            <tr>
                                <td>{{ __('Amount') }}</td>
                                <td>{{ $Info['main_amount'] }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Charge') }}</td>
                                <td>{{ $Info['charge'] }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Total') }}</td>
                                <td>{{ $Info['main_amount']+$Info['charge'] }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Amount ('.$Info['currency'].')') }}</td>
                                <td>{{ $Info['amount'] }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Payment Mode') }}</td>
                                <td>{{ __('RazorPay') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="login-btn">
                        <button class="btn btn-primary mt-4 col-12" id="rzp-button1">{{ __('Pay Now') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<form action="{{ url('/customer/razorpay/status')}}" method="POST" hidden>
    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
    <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
    <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
    <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
    <button type="submit" id="rzp-paymentresponse" hidden class="btn btn-primary"></button>
</form>
<input type="hidden" value="{{ $response['razorpayId'] }}" id="razorpayId">
<input type="hidden" value="{{ $response['amount'] }}" id="amount">
<input type="hidden" value="{{ $response['currency'] }}" id="currency">
<input type="hidden" value="{{ $response['name'] }}" id="name">
<input type="hidden" value="{{ $response['description'] }}" id="description">
<input type="hidden" value="{{ $response['orderId'] }}" id="orderId">
<input type="hidden" value="{{ $response['name'] }}" id="name">
<input type="hidden" value="{{ $response['email'] }}" id="email">
<input type="hidden" value="{{ $response['contactNumber'] }}" id="contactNumber">
<input type="hidden" value="{{ $response['address'] }}" id="address">
@endsection

@push('js')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{ asset('backend/admin/assets/js/razorpay.js')}}"></script>
@endpush
