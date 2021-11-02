@extends('layouts.frontend.app')

@section('slider')
<!-- breadcrumb area start -->
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Contact Us') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Contact Us') }}</li>
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
                <div class="col-lg-6 offset-lg-3">
                    <div class="header-title-section text-center">
                        <h3>{{ __('Contact Us') }}</h3>
                        <p>{{ __('contact_des') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="contact-form">
                        <form action="{{ url('/contact-mail') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" placeholder="{{ __('Enter Your Name') }}" class="form-control" name="name" id="name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{ __('Email') }}</label>
                                        <input type="email" placeholder="{{ __('Enter Your Email') }}" class="form-control" name="email" id="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{ __('Subject') }}</label>
                                        <input type="text" placeholder="{{ __('Enter Your Subject') }}" class="form-control" name="subject" id="subject" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{ __('Message') }}</label>
                                        <textarea name="message" class="form-control" placeholder="{{ __('Message') }}" id="message" required></textarea>
                                    </div>
                                </div>
                                @if(env('NOCAPTCHA_SECRET') != null)
                                <div class="form-group mb-2">

                                   {!! NoCaptcha::renderJs(Session::get('locale')) !!}
                                   {!! NoCaptcha::display() !!}

                                   @if ($errors->has('g-recaptcha-response'))
                                   <span class="text-danger">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                            @endif 
                                <div class="col-lg-12">
                                    <div class="form-btn">
                                        <button type="submit" class="basicbtn">{{ __('Send Message') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
