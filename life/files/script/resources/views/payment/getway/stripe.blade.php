@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Stripe Payment') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Stripe Payment') }}</li>
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
            <div class="col-6 offset-3 my-4">
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
                            <td class="text-right">{{ $Info['main_amount'] + $Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount (USD)') }}</td>
                            <td class="text-right">{{ $Info['amount'] }}</td>
                        </tr>  
                        <tr>
                            <td>{{ __('Payment Mode') }}</td>
                            <td class="text-right">{{ __('Stripe') }}</td>
                        </tr>                                      
                    </table>
                    <form action="{{ url('customer/stripe/payment') }}" method="post" id="payment-form" class="paymentform">
                        @csrf
                        <div class="form-row">
                            <label for="card-element" class="mb-3">
                                <h6>{{ __('Credit or debit card') }}</h6>
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                            <div class="login-btn">
                                <button type="submit" class="btn btn-primary mt-4" id="submit_btn">{{ __('Submit Payment') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>   
    </div>
    <input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">
</div>
@endsection

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('backend/admin/assets/js/stripe.js') }}"></script>
@endpush
