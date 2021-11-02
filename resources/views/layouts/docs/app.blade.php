<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - {{ __('Documentation') }}</title>

    <!-- css here -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/hc-offcanvas-nav.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/docs/default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/docs/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/docs/responsive.css') }}">
</head>

<body>

    <!-- header area start -->
    @include('layouts.docs.partials.header')
    <!-- header area end -->

    <!-- main area start -->
    <section>
        <div class="main-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <!-- sidebar area start -->
                        @include('layouts.docs.partials.sidebar')
                        <!-- sidebar area end -->
                    </div>
                    <div class="col-lg-6">
                        @yield('content')
                    </div>
                    <div class="col-lg-3">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- main area end -->

    <!-- footer area start -->
    @include('layouts.docs.partials.footer')
    <!-- footer area end -->

    <script src="{{ asset('frontend/assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/hc-offcanvas-nav.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/iconify.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/docs/script.js') }}"></script>
</body>

</html>
