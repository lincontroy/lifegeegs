@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Payu Payment') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Payu Payment') }}</li>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-checkout">
                                    <tr>
                                        <td>{{ __('Amount') }}</td>
                                        <td class="float-right">{{ $Info['amount']-$Info['charge'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Charge') }}</td>
                                        <td class="float-right">{{ $Info['charge'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Total (INR)') }}</td>
                                        <td class="float-right">{{ $Info['amount'] }}</td>
                                    </tr>  
                                    <tr>
                                        <td>{{ __('Payment Mode') }}</td>
                                        <td class="float-right">{{ __('Payu') }}</td>
                                    </tr>                                      
                                </table>
                            </div>
                        </div>
                        <form action="#" method="post" name="payuForm" id="payment_form">
                            @csrf
                            <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
                            <input type="hidden" id="salt" value="{{ $Info['salt'] }}" />
                            <input type="hidden" name="key" id="key" value="{{ $Info['key'] }}" />
                            <input type="hidden" name="hash" id="hash" value="{{ $Info['hash'] }}"/>
                            <input type="hidden" name="txnid" id="txnid" value="{{ $Info['txnid'] }}" />
                            <input type="hidden" name="amount" id="amount" value="{{ $Info['amount'] }}" />
                            <input type="hidden" name="firstname" id="firstname" value="{{ $Info['firstname'] }}"/>
                            <input type="hidden" name="email" id="email" value="{{ $Info['email'] }}" />
                            <input type="hidden" name="phone" id="mobile" value="{{ $Info['phone'] }}" />
                            <input type="hidden" name="productinfo" id="productinfo" value="{{ $Info['productinfo'] }}"/>
                            <input type="hidden" name="surl" id="surl" value="{{ $Info['surl'] }}"/>
                            <input type="hidden" name="furl" id="furl" value="{{ $Info['furl'] }}"/>
                            <div class="card-footer bg-white">
                                <div class="login-btn">
                                    <input type="submit" class="btn btn-primary mt-4 col-12 w-100 btn-lg" type="submit" value="Submit" onclick="launchBOLT(); return false;"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>


@endsection

@push('js')
@if ($Info['test_mode'] == 1 || $Info['test_mode'] == true)
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-
color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@else 
<script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@endif

<script src="{{ asset('backend/admin/assets/js/payu.js')}}"></script>
@endpush