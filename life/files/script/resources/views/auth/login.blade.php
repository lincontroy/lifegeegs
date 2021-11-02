@extends('layouts.frontend.app')

@section('title','Login')

@section('slider')
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Log In') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Log In') }}</li>
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
                            <h4>{{ __('Log In') }}</h4>
                        </div>
                      
                        @if(Session::has('error'))
                        <div class="alert alert-danger">
                            <ul>                               
                                <li>{{ Session::get('error') }}</li>
                            </ul>
                        </div>
                        @endif
                       

                        <form method="POST" id="regform" action="{{ route('login') }}">
                        @csrf
                        <div class="login-section">
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
                            <div class="form-group">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" name="remember" type="checkbox" id="remember_me">
                                        <label class="form-check-label" for="remember_me">
                                          {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <div class="forgoten-pass">
                                            <a href="{{ route('password.request') }}" class="text-small">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>                       
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-btn">
                                        <button type="submit" id="regbtn" class="btn btn-primary">{{ __('Log In') }}</button>
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



