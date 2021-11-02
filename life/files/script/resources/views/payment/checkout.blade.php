@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Checkout') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Checkout') }}</li>
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
<div class="dashboard-area pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="main-container checkout-main-area">
                    <div class="header-section mb-4">
                        <h4>{{ __('Checkout') }}</h4>
                    </div>  
                    <div class="login-section">
                        @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                        @endif
                        @php $info = json_decode($requestData->data) @endphp
                        <ul class="nav nav-pills mx-auto payment_method" id="myTab3" role="tablist">
                            @foreach ($usergetways as $key => $gateways)
                                @php $gateway =  $gateways->getway @endphp
                                <li class="nav-item">
                                <a class="nav-link {{ $key == 0 ? 'show active' : '' }}"
                                    id="getway-tab{{ $gateway->id }}" data-toggle="tab" data-bs-toggle="pill"
                                    href="#getway{{ $gateway->id }}" role="tab" aria-controls="home" aria-selected="true">
                                    <div class="card-body">
                                        <img src="{{ asset($gateway->logo) }}" alt="{{ $gateway->name }}" width="100">
                                    </div>
                                </a>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            @foreach ($usergetways as $key => $gateways)
                              @php $gateway =  $gateways->getway @endphp
                              @php $data = json_decode($gateway->data) @endphp
                              <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                  id="getway{{ $gateway->id }}" role="tabpanel"
                                  aria-labelledby="getway-tab{{ $gateway->id }}">
                                  <div class="table-responsive payment-gateway-section">
                                      <table class="table table-checkout">
                                          <tr>
                                              <td><strong>{{ __('Amount (USD)') }}</strong></td>
                                              <td class="text-right">{{ $requestData->amount }}</td>
                                          </tr>
                                          <tr>
                                              <td><strong>{{ __('Currency') }}</strong></td>
                                              <td class="text-right">{{ strtoupper($gateways->currency_name) }}</td>
                                          </tr>
                                          <tr>
                                            <td><strong>{{ __('Rate') }}</strong></td>
                                            <td class="text-right">{{ $gateways->rate }}</td>
                                          </tr>   
                                          <tr>
                                            <td><strong>{{ __('Gateway Fee') }}</strong></td>
                                            <td class="text-right">{{ $gateways->charge }}</td>
                                          </tr>   
                                          <tr>
                                            <td><strong>{{ __('Total') }}</strong></td>
                                            <td class="text-right">{{ $final_amount = ($requestData->amount * $gateways->rate + $gateways->charge) }}
                                            </td>
                                          </tr>   
                                          <tr>
                                            <td><strong>{{ __('Purpose') }}</strong></td>
                                            @php $info = json_decode($request->requestmeta->value) @endphp 
                                            <td class="text-right">{{ $info->purpose ?? '' }}</td>
                                          </tr>   
                                      </table>
                                    </div>
                                    <form action="{{ route('checkout.payment.view') }}" method="post" class="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <input type="hidden" name="gateway_id" value="{{ $gateway->id }}">
                                            <input type="hidden" name="request_id" value="{{ $requestData->id }}">
                                            <input type="hidden" name="user_id" value="{{ $gateways->user_id }}">
                                            <input type="hidden" name="is_test" value="{{ $requestData->is_test }}">
                                            <input type="hidden" name="phone_required" value="{{ $gateways->phone_required }}">
                                            <input type="hidden" name="image_accept" value="{{ $gateway->image_accept }}">

                                            @if ($gateways->phone_required == 1)
                                       
                                            <table class="table table-checkout">
                                                <tr>
                                                    <td><strong>{{ __('Phone') }}</strong></td>
                                                    <td class="text-right">
                                                        <input type="text" name="phone"
                                                            class="form-control checkout_control @error('phone') is-invalid @enderror"
                                                            value="{{ $phone ?? old('phone') }}" required>
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="screenshot-alert">{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </table>
                                            @endif
                                     
                                            @if ($gateway->image_accept == 1)
                                            <table class="table table-checkout">
                                                <tr>
                                                    <td><strong>{{ __('Screenshot') }}</strong></td>
                                                    <td class="">
                                                        <div class="custom-file">
                                                            <input type="file" name="screenshot" class="form-control @error('screenshot')is-invalid @enderror screenshot"  id="screenshot">
                                                            @error('screenshot')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="screenshot-alert">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                            @endif      
                                            @if ($gateway->is_auto == 0)
                                            <table class="table table-checkout">
                                            <tr>
                                                <td><strong>{{ __('Comment') }}</strong></td>
                                                <td class="">
                                                    <textarea name="comment" class="form-control border @error('comment')is-invalid @enderror comment">{{ old('comment') ?? '' }}</textarea>

                                                    @error('comment')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="screenshot-alert">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    
                                                </td>
                                            </tr>
                                            </table>
                                            @endif  
                                            <input type="hidden" name="captcha" value="{{ $plan->captcha == 1 && $requestData->captcha_status == 1 ? 1 : 0 }}">    

                                            @if ($plan->captcha == 1 && $requestData->captcha_status == 1 && env('NOCAPTCHA_SITEKEY') && $gateway->is_auto == 0)
                        
                                            <div class="form-group mb-2 d-flex justify-content-center">

                                            {!! NoCaptcha::renderJs(Session::get('locale')) !!}
                                            {!! NoCaptcha::display() !!}
                                            </div>
                                            
                                            @endif 
                                            @if ($gateway->is_auto == 0)
                                            <tr>
                                                <td colspan="2" class="text-left">
                                                    <strong class="text-danger">
                                                         @php $info = json_decode($gateways->data) @endphp
                                                        {{ __('Instruction') }} : {{ $info->instruction }} 
                                                    </strong>
                                                </td>
                                            </tr>
                                            @endif
                                            <div class="login-btn">
                                                <button type="submit" class="btn btn-primary mt-4 w-100 submitbtn">{{ __('Submit')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>  
                    </div>                      
                </div>
            </div>
            <div class="col-lg-4">
                <div class="main-container checkout-main-area">
                    <div class="header-section mb-4">
                        <h5>{{ __('Merchant Info') }}</h5>
                    </div>  
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="text-center">
                                <img src="{{ asset($plan->user->image) }}" alt="" class="image-thumbnail mt-2">
                            </div>
                            <br>
                            <table class="table">
                                <tbody>
                                    @php $info = $plan->user->meta ? json_decode($plan->user->meta->value) : '' @endphp 
                                    <tr>
                                        <td>Name</td>
                                        <td>{{ $plan->user->name  ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Company Name</td>
                                        <td>{{ $info->company_name  ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Company Email</td>
                                        <td>{{ $info->company_email ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Company Address</td>
                                        <td>{{ $info->company_address ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
