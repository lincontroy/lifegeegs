@extends('layouts.backend.app')

@section('title','Create New')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Payment Gateway Edit','button_name'=> 'All Payment Gateway','button_link'=> route('admin.payment-gateway.index')])
@endsection

@push('before_css')
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/selectric.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create New') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.payment-gateway.store') }}" class="basicform_with_reset">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Name') }}<sup>*</sup></label>
                                <input type="text" class="form-control" name="name" value="">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Logo') }} <sup>*</sup></label>
                                <input type="file" id="logo" class="form-control" name="logo">
                                <img src="" alt="" class="image-thumbnail mt-2">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Rate') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="rate" value="">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Test Mode') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="test_mode">
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Inactive')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Currency Name') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="currency_name" value="">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Fraud Checker') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="fraud_checker">
                                    <option value="1">{{ __('Enable') }}</option>
                                    <option value="0">{{ __('Disable') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Charge') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="charge" value="">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Customer Status') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="customer_status">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Global Status') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="global_status">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Accept Image') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="image_accept">
                                    <option value="1">{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('instruction') }} <sup>*</sup></label>
                                <textarea class="form-control" name="instruction" required=""></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Submit') }}</button>
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
