@extends('layouts.backend.app')

@section('title','Create Merchant')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Merchant Create','button_name'=> 'All Merchants','button_link'=> route('admin.merchant.index')])
@endsection

@push('before_css')
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/selectric.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create Merchant') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.merchant.store') }}" class="basicform_with_reset" >
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Name') }}<sup>*</sup></label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Email') }} <sup>*</sup></label>
                                <input type="text" id="emil" class="form-control" name="email">
                            </div>
                        </div>
                    </div>
                      
               
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Phone') }}</label>
                                <input type="text" id="phone" class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Password') }}</label>
                                <input type="password" id="password" class="form-control" name="password">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary btn-lg basicbtn">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('backend/admin/assets/js/selectric.js') }}"></script>
@endpush