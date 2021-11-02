@extends('layouts.frontend.app')

@section('slider')
<!-- breadcrumb area start -->
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ $data->title }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
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
    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{ content($data->description->value ?? null) }}
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection