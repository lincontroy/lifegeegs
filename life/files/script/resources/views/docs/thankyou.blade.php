@extends('layouts.docs.app')

@section('content')
<div class="dashboard-main-area">
    <div class="dashboard-title">
        <h2>{{ __('Thank You') }}</h2>
    </div>
    <div class="dashboard-des">
        <p>{{ __('Thank you for all of your support and love. With change comes growth, with growth comes understanding and with understanding comes acceptance. We love you with all our hearts.') }}</p>
    </div>
    <div class="main-container-area">
        <div class="thankyou-img">
            <img class="img-fluid" src="{{ asset('frontend/assets/img/docs/thankyou.png') }}" alt="">
        </div>
    </div>
    <div class="next-page-link-area mt-100 mb-100">
       
    </div>
</div>  
@endsection