@extends('layouts.frontend.app')

@section('slider')
<!-- breadcrumb area start -->
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Valuable Features') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Valuable Features') }}</li>
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
<section>
    <div class="features-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                @forelse ($sections as $value)
                @php $jsonSection = json_decode($value->termMeta->value ) @endphp
                <div class="col-lg-4">
                    <div class="single-service text-center">
                        <div class="service-img">
                            <img src="{{ asset($jsonSection->image ?? 'frontend/assets/img/services/1.png') }}" alt="">
                        </div>
                        <div class="service-title">
                            <h4>{{ $value->title }}</h4>
                        </div>
                        <div class="service-des">
                            <p>{{ $jsonSection->short_des }}</p>
                        </div>
                        <div class="service-btn">
                            <a href="{{ url('/service',$value->slug) }}">{{ __('Read More') }}</a>
                        </div>
                    </div>
                </div>
                @empty
                    <h4 class="text-danger">{{ __('No Data To Show') }}</h4>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection