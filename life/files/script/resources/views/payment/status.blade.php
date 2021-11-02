@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Payment Status') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Payment Status') }}</li>
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
      <div class="col-lg-8 offset-lg-2">
          <div class="main-container checkout-main-area">
            @if (Session::has('message'))
            <div class="alert alert-{{ Session::get('type') }}">
                <p class="mb-0">{{ Session::get('message') }}</p>
            </div>
            @endif
            
            @if ($status != 0)
            <table class="table table-checkout">
              <tr>
                <th>{{ __('Title') }}</th>
                <th class="text-right">{{ __('Description') }}</th>
              </tr>
              <tr>
                <th>{{ __('Purpose') }}</th>
                <td class="text-right">{{ $req_info['purpose'] ?? '' }}</td>
              </tr>
              <tr>
                <th>{{ __('Payment ID') }}</th>
                <td class="text-right">{{ $payment->trx_id ?? '' }}</td>
              </tr>
              <tr>
                <th>{{ __('Amount') }}</th>
                <td class="text-right">{{ $payment->amount ?? '' }}</td>
              </tr>
              <tr>
                <th>{{ __('Gateway') }}</th>
                <td class="text-right">{{ $payment->getway->name ?? '' }}</td>
              </tr>
              <tr>
                <th>{{ __('Merchant') }}</th>
                <td class="text-right">{{ $payment->user->name ?? '' }}</td>
              </tr>
              <tr>
                <th>{{ __('Created') }}</th>
                <td class="text-right">{{ $payment->created_at->isoFormat('LL') }}</td>
              </tr>
            </table>
            @else 
              <h4>
                <strong>Sorry payment could not be processed!</strong>
              </h4>
            @endif  
          </div>
      </div>
    </div>   
  </div>
</div>
<input type="hidden" id="fallback" value="{{ $url ?? '' }}">
<input type="hidden" id="is_fallback" value="{{ $fallback ?? 0 }}">
@endsection
