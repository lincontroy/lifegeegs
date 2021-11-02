<div class="sidebar-area">
    <nav id="main-nav">
        <ul>
            <li></li>
            <li><a class="{{ Request::is('docs') ? 'active' : '' }}" href="{{ route('docs') }}"><span class="iconify" data-icon="fluent:home-12-filled" data-inline="false"></span> {{ __('Quick Start') }}</a></li>
            <li><a class="{{ Request::is('docs/payment/install') ? 'active' : '' }}" href="{{ route('docs.payment.install') }}"><span class="iconify" data-icon="fluent:payment-16-filled" data-inline="false"></span> {{ __('Payment Gateway Install') }}</a></li>
            <li><a class="{{ Request::is('docs/form/generator') ? 'active' : '' }}" href="{{ route('docs.form.generator') }}"><span class="iconify" data-icon="bx:bx-transfer-alt" data-inline="false"></span> {{ __('Form Generator') }}</a></li>
            <li><a class="{{ Request::is('docs/payment/url') ? 'active' : '' }}" href="{{ route('docs.payment.url') }}"><span class="iconify" data-icon="bi:eye-slash-fill" data-inline="false"></span> {{ __('One time URL') }}</a></li>
            <li><a class="{{ Request::is('docs/payment/api') ? 'active' : '' }}" href="{{ route('docs.payment.api') }}"><span class="iconify" data-icon="ic:baseline-library-books" data-inline="false"></span> {{ __('Payments through API') }}</a></li>
            <li><a class="{{ Request::is('docs/thankyou') ? 'active' : '' }}" href="{{ route('docs.thankyou') }}"><span class="iconify" data-icon="fluent:style-guide-24-filled" data-inline="false"></span> {{ __('Thank You') }}</a></li>
        </ul>
    </nav>
</div>
