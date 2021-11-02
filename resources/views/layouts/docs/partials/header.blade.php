<header>
    <div class="header-area fixed">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="header-logo">
                        <a href="{{ url('docs') }}"><img src="{{ asset('uploads/docs-logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-search-area">
                        <div class="header-searchbar">
                            <div class="header-searchicon">
                                <span class="iconify" data-icon="akar-icons:search" data-inline="false"></span>
                            </div>
                            <div class="header-input">
                                <input type="text" id="searchinput" placeholder="{{ __('Search Documentation') }}" class="w-100">
                            </div>
                        </div>
                        <div class="header-search-list d-none">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('docs') }}"><span class="iconify" data-icon="fluent:home-12-filled" data-inline="false"></span> {{ __('Quick Start') }}</a></li>
                                    <li><a href="{{ route('docs.payment.install') }}"><span class="iconify" data-icon="fluent:payment-16-filled" data-inline="false"></span> {{ __('Payment Gateway Install') }}</a></li>
                                    <li><a href="{{ route('docs.form.generator') }}"><span class="iconify" data-icon="bx:bx-transfer-alt" data-inline="false"></span> {{ __('Form Generator') }}</a></li>
                                    <li><a href="{{ route('docs.payment.url') }}"><span class="iconify" data-icon="bi:eye-slash-fill" data-inline="false"></span> {{ __('One time URL') }}</a></li>
                                    <li><a href="{{ route('docs.payment.api') }}"><span class="iconify" data-icon="ic:baseline-library-books" data-inline="false"></span> {{ __('Payments through API') }}</a></li>
                                    <li><a href="{{ route('docs.thankyou') }}"><span class="iconify" data-icon="fluent:style-guide-24-filled" data-inline="false"></span> {{ __('Thank You') }}</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mobile-btn">
                    <div class="mobile-menu">
                        <a class="toggle f-right" href="#" role="button" aria-controls="hc-nav-1"><span class="iconify" data-icon="akar-icons:grid" data-inline="false"></span></a>
                    </div>
                    <div class="header-dashboard-btn f-right">
                        @auth
                            <a href="{{ route('login') }}">{{ __('Dashboard') }}</a>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endguest
                    </div>
                    <div class="header-login-btn f-right">
                        <a href="{{ route('docs.payment.api') }}">{{ __('API') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
