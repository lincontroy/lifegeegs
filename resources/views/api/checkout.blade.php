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
</div>
<!-- breadcrumb area start -->
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
                        @if (Session::has('alert'))
                        <div class="alert {{ Session::get('type') }}">
                        {{ Session::get('alert') }}
                        </div>
                        @endif
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
                                </li>
                            @endforeach
                        </ul>
                        
                            <div class="tab-content" id="myTabContent2">
                                @foreach ($usergetways as $key => $gateways)
                                    @php $gateway =  $gateways->getway @endphp
                                    @php $data = json_decode($gateway->data) @endphp
                                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                        id="getway{{ $gateway->id }}" role="tabpanel"
                                        aria-labelledby="getway-tab{{ $gateway->id }}">
                                        <div class="">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
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
                                                        <td>{{ __('Purpose') }}</td>
                                                        <td class="text-right">{{ $requestData->data->purpose ?? '' }}</td>
                                                    </tr>
        
                                                </table>
                                            </div>
                                            
                                        </div>
                                        <form action="{{ route('customer.api.payment') }}" method="post" class="form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="">
                                                <input type="hidden" name="gateway_id" value="{{ $gateway->id }}">
                                                <input type="hidden" name="request_id"
                                                    value="{{ $requestData->request_id }}">
                                                <input type="hidden" name="user_id" value="{{ $gateways->user_id }}">
                                                <input type="hidden" name="is_test" value="{{ $requestData->is_test }}">
                                                <input type="hidden" value="{{ $gateway->phone_required }}"
                                                    name="phone_required">
                                                <input type="hidden" value="{{ $gateway->image_accept }}"
                                                name="image_accept">
                                                
                                                @if ($gateway->phone_required == 1)
                                                    <table class="table">
                                                        <tr>
                                                            <td>Phone</td>
                                                            <td>
                                                                <input type="text" name="phone"
                                                                    class="form-control checkout_control @error('phone') is-invalid @enderror"
                                                                    value="{{ $phone ?? '' }}" required>
                                                                @error('phone')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                    </table>
    
                                                @endif
    
                                                @if ($gateway->image_accept == 1)
                                                    <table class="table">
                                                        <tr>
                                                            <td>Screenshot</td>
                                                            <td>
                                                                <input type="file" name="screenshot"
                                                                    class="form-control screenshot" 
                                                                    value="" required/>
    
                                                                    @error('screenshot')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                            </td>
                                                        </tr>
                                                    </table>
                                                @endif     
                                                @if ($gateway->is_auto == 0)
                                                    <table class="table">
                                                        
                                                        <tr>
                                                            <td><strong>{{ __('Comment') }}</strong></td>
                                                            <td class="">
                                                                <textarea name="comment" class="form-control border @error('screenshot')is-invalid @enderror screenshot"></textarea>
        
                                                                @error('screenshot')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="screenshot-alert">{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
    
                                                @endif         
                                                <input type="hidden" name="captcha" value="{{ $plan->captcha }}">      
                                               
                                                @if ($plan->captcha == 1 && env('NOCAPTCHA_SITEKEY') && $gateway->is_auto == 0)
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
                                                                Note : {{ $info->instruction }} 
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    @endif
    
                                                <button  type="submit"
                                                    class="btn btn-primary mt-4 w-100 submitbtn">{{ __('Submit') }}</button>
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
                            @if ($plan->user->image != '')
                            <div class="text-center">
                                <img src="{{ asset($plan->user->image) }}" alt="" class="image-thumbnail mt-2">
                            </div>
                            @endif
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
@push('js')

{{-- @if ($plan->captcha == 1)
<script src="https://www.google.com/recaptcha/api.js" async></script>
@endif --}}
<script>
$('.form').on('submit', function(){
    $('.submitbtn').text('Please wait...');
    $('.submitbtn').prop('disabled', true);
});
</script>
@endpush



