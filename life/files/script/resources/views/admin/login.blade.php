<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/components.css') }}">
</head>

<body>
  <div id="app">
    <section class="section">
        <div class="container mt-5">
          <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
              <div class="login-brand">
                <img src="{{ asset('uploads/docs-logo.png') }}" alt="logo" width="100" class="shadow-light">
              </div>
  
              <div class="card card-primary">
                <div class="card-header"><h4>{{ __('Login') }}</h4></div>
               
                <div class="card-body">
                  @if (Session::has('message'))
                  <div class="alert alert-danger">
                     {{ Session::get('message') }}
                  </div>
                  @endif
                  <form method="POST" action="{{ route('login') }}" class="needs-validation" id="login" novalidate="">
                    @csrf
                    <div class="form-group">
                      <label for="email">{{ __('Email') }}</label>
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" required autofocus value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
  
                    <div class="form-group">
                      <div class="d-block">
                          <label for="password" class="control-label">{{ __('Password') }}</label>
                        <div class="float-right">
                        @if (Route::has('password.request'))
                          <a href="{{ route('password.request') }}" class="text-small">
                            {{ __('Forgot Password?') }}
                          </a>
                        @endif
                        </div>
                      </div>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required autocomplete="current-password">
                      <div class="invalid-feedback">
                        @error('password')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
  
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{ __('Login') }}
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/admin/assets/js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/moment.min.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('backend/admin/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/custom.js') }}"></script>

</body>
</html>

