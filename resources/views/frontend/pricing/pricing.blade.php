@extends('layouts.frontend.app')

@section('slider')
<!-- breadcrumb area start -->
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Pricing Tables') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Pricing Tables') }}</li>
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
<div class="pricing-area pt-150 pb-150">
    <div class="container">
        <div class="row mt-5">
            @forelse($plans as $plan)
            <div class="col-lg-3">
                <div class="single-pricing {{ $plan->is_featured ? 'active' : '' }}">
                    <div class="pricing-type">
                        <h6>{{ $plan->name }}</h6>
                    </div>
                    <div class="pricing-price">
                        <sub>{{ $plan->price }} $ /
                            @if ($plan->duration == 7)
                            {{ __('Per Week') }}
                        @elseif($plan->duration == 30)
                            {{ __('Per Month') }}
                        @elseif($plan->duration == 365)
                            {{ __('Per Year') }}
                        @else
                            {{ $plan->duration }} {{ __('Days') }}
                        @endif
                        </sub>
                    </div>
                    <div class="pricing-list">
                        <ul>
                            <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $plan->storage_limit }} {{ __('MB Storage limit') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $plan->monthly_req }} {{ __('Monthly Request') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $plan->daily_req }} {{ __('Daily Request') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->captcha=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Google Captcha') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->menual_req=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Menual Request') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->fraud_check=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Fraud Check') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->is_auto=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Is Auto') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->is_default=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Is Default') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->status=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Status') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->mail_activity=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Mail Activity') }}</li>
                        </ul>
                    </div>
                    <div class="pricing-btn">
                        <a href="{{ route('plan.check', $plan->id) }}">{{ __('Get Started') }}</a>
                    </div>
                </div>
            </div>
            @empty
                <h4 class="text-danger">{{ __('No Data') }}</h4>
            @endforelse
        </div>
    </div>
</div>
@endsection
