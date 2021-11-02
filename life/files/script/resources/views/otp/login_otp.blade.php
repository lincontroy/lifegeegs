<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('OTP') }}</title>

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
              <img src="{{ asset('backend/admin') }}/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>
            <div class="card card-primary">
            <div class="card-header"><h4>{{ __('OTP Send In Your Mail') }}</h4></div>
            <div class="card-body">
            @if (Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
            @endif
            <form method="POST" action="{{ route('otp.confirmation') }}" class="needs-validation submitform" novalidate="">
              @csrf
              <div class="form-group">
                <label for="otp">OTP</label>
                <input type="text" placeholder="Enter OTP" class="form-control" name="otp">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block submitbtn" tabindex="4">
                  {{ __('Submit') }}
                </button>
              </div>
              </form>
              <form method="POST" action="{{ route('otp.resend') }}" class="needs-validation submitform" novalidate="">
                @csrf
                    <div class="row text-right">
                      <div class="col-lg-12">
                        <div class="login-btn">
                          <button class="btn btn-link submitbtn" type="submit">{{ __('Resend OTP') }}</button>
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
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/admin/assets/js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/bootstrap.min.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('backend/admin/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/custom.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('backend/admin/assets/js/page/index-0.js') }}"></script>
</body>
</html>
