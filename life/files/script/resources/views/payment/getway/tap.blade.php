@extends('layouts.frontend.app')

@section('content')
<div class="row py-5">
    <div class="col-md-6 col-6 offset-3">
        <div class="card">
            <div class="card-body">
                <form id="form-container" method="post" action="{{ route('customer.tap.authorize') }}">
                    @csrf
                    <!-- Tap element will be here -->
                    <div id="element-container"></div>
                    <div id="error-handler" role="alert"></div>
                    <!-- Tap pay button -->
                    <button id="tap-btn" class="btn btn-primary mt-4 btn-block w-100">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">
@endsection


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
    <script src="{{ asset('backend/admin/assets/js/tap.js') }}"></script>
@endpush
