@extends('layouts.frontend.app')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Service Details') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Service Details') }}</li>
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
@php $jsonSection = json_decode($service->termMeta->value ) @endphp
 <!-- blog area start -->
 <div class="blog-main-area mt-100 mb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="service-content text-center">
                    <div class="service-img">
                        <img src="{{ asset($jsonSection->image ?? 'frontend/assets/img/services/1.png') }}" alt="">
                    </div>
                    <div class="service-name mb-3">
                        <h2>{{ $service->title }}</h2>
                    </div>
                    <div class="service-des">
                        <p>{{ content($jsonSection->des ?? '') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- blog area end -->
@endsection