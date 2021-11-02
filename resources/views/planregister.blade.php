@extends('layouts.frontend.app')

@section('title','Register')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Register') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Register') }}</li>
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
    <div class="dashboard-area pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="main-container">
                        <div class="header-section mb-4">
                            <h4>{{ __('Register') }}</h4>

                        </div>                        
                        <form method="POST" id="regform" action="{{ route('plan.register') }}">
                        @csrf
                         <input type="hidden" name="planid" value="{{ $planid }}">
                        <div class="login-section">
                            <h6>{{ __('Name') }}</h6>
                            <div class="form-group mb-2">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your name">
                            </div>
                             <h6>{{ __('E-Mail Address') }}</h6>
                            <div class="form-group mb-2">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@isset($request->email) {{ $request->email }} @else {{ old('email') }} @endisset" required autocomplete="email" placeholder="Enter your email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <h6>{{ __('Password') }}</h6>
                            <div class="form-group mb-4">
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <h6>{{ __('Confirm Password') }}</h6>
                            <div class="form-group mb-2">
                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
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
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-btn">
                                        <button type="submit" id="regbtn" class="btn btn-primary">{{ __('Register') }}</button>
                                    </div>
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


