@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Paystack Payment') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Paystack Payment') }}</li>
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
                    <table class="table table-checkout">
                        <tr>
                            <td>{{ __('Amount') }}</td>
                            <td class="text-right">{{ $Info['main_amount'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Charge') }}</td>
                            <td class="text-right">{{ $Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total') }}</td>
                            <td class="text-right">{{ $Info['main_amount']+$Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount') }} ({{ $Info['currency'] }})</td>
                            <td class="text-right">{{ $Info['amount'] }}</td>
                        </tr>  
                        <tr>
                            <td>{{ __('Payment Mode') }}</td>
                            <td class="text-right">{{ __('Paystack') }}</td>
                        </tr>                                      
                    </table>
                    <div class="login-btn">
                        <button class="btn btn-primary mt-4 col-12" id="payment_btn">{{ __('Pay Now') }}</button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>  
<form method="post" class="status" action="{{ url('customer/payment/paystack') }}">
    @csrf
    <input type="hidden" name="ref_id" id="ref_id">
</form>
<input type="hidden" value="{{ $Info['currency'] }}" id="currency">
<input type="hidden" value="{{ $Info['amount'] }}" id="amount">
<input type="hidden" value="{{ $Info['public_key'] }}" id="public_key">
<input type="hidden" value="{{ $Info['email'] ?? Auth::user()->email }}" id="email">
@endsection

@push('js')
<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>
    "use strict";

    $('#payment_btn').on('click',()=>{
        payWithPaystack();
    });
    payWithPaystack();
 
    function payWithPaystack() {
        var amont= $('#amount').val() * 100 ;
        let handler = PaystackPop.setup({
        key: $('#public_key').val(), // Replace with your public key
        email: $('#email').val(),
        amount: amont,
        currency: $('#currency').val(),
        ref: 'ps_{{ Str::random(15) }}',
        onClose: function(){
        payWithPaystack();
    },
        callback: function(response){
            $('#ref_id').val(response.reference);
            $('.status').submit();
        }
    });
        handler.openIframe();
    }
</script>
@endpush