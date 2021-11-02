<footer class="main-footer">
    <div class="footer-left">
      {{ __('Copyright') }} &copy; {{ Carbon\Carbon::now()->format('Y') }} <div class="bullet"></div> Develop By <a href="{{ route('login') }}">{{ config()->get('app.name') }}</a>
    </div>
    <div class="footer-right">
      1.0.0
    </div>
  </footer>