<footer>
    @php
        $theme_settings = App\Models\Option::where('key','theme_settings')->first();
        $theme = json_decode($theme_settings->value);
    @endphp
    <div class="footer-area footer-demo-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-left-area">
                        <div class="footer-logo">
                            <div class="header-logo">
                                <img class="img-fluid" src="{{ asset('uploads/logo.png') }}" alt="{{ config('app.name') }}">
                            </div>
                            <div class="footer-content">
                                <p>{{ $theme->footer_description ?? '' }}</p>
                                @php
                                    $languages = App\Models\Language::where('status',1)->get();
                                @endphp
                                <div class="footer-lang-select">
                                    <select name="lang" class="form-select" id="lang">
                                        @foreach ($languages as $value)
                                            <option {{ App::getLocale() == $value->name ? 'selected' : '' }} value="{{ $value->name }}">{{ $value->data }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="agent-social-links">
                                <nav>
                                    <ul>@foreach ($theme->social ?? [] as $key => $item)
                                        <li><a href="{{ $item->link ?? '#'}}"><span class="iconify" data-icon="{{ $item->icon }}" data-inline="false"></span></a></li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-menu">
                        {{ footer_menu('footer_left') }}
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-menu">
                        {{ footer_menu('footer_right') }}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-newsletter">
                        <div class="footer-menu-title">
                            <h4>{{ __('Newsletter') }}</h4>
                        </div>
                        <div class="footer-content">
                            <p>{{ $theme->newsletter_address ?? '' }}</p>
                        </div>
                        <div class="footer-newsletter-input">
                            <form action="{{ route('newsletter') }}" id="newsletter" method="post">
                                @csrf
                                <input type="email" name="email" placeholder="{{ __('Enter Your Email Address') }}" id="subscribe_email">
                                <button type="submit" class="basicbtn">{{ __('Subscribe') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area footer-demo-1">
        <div class="footer-bottom-content text-center">
            <span>{{ __('Copyright © Website') }} - {{ Carbon\Carbon::now()->format('Y') }}. {{ __('Powered By') }} <a href="{{ url('/') }}">{{ config()->get('app.name') }}</a></span>
        </div>
    </div>
</footer>



