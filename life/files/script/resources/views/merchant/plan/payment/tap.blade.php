@extends('layouts.backend.app')

@section('title', 'Tap Payment')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Tap Payment'])
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="form-container" method="post" action="{{ url('/payment/tap/authorize') }}">
                @csrf
                <!-- Tap element will be here -->
                <div id="element-container"></div>
                <div id="error-handler" role="alert"></div>
                <div id="success" style=" display: none;;position: relative;float: left;">
                    {{ __('Success! Your token generated!') }}
                </div>
                <!-- Tap pay button -->
                <button id="tap-btn" class="btn btn-primary mt-2 btn-block">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
    <input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
    <script src="{{ asset('backend/admin/assets/js/tap.js') }}"></script>
@endpush
