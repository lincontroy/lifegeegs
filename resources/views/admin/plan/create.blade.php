@extends('layouts.backend.app')

@section('title','Plan Create')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Plan Create','button_name'=> 'All Plans','button_link'=> route('admin.plan.index')])
@endsection

@push('before_css')
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/selectric.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create Plan') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.plan.store') }}" class="basicform_with_reset">
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
                                <label>{{ __('Price') }} <sup>*</sup></label>
                                <input type="number" id="price" class="form-control" name="price" step="any">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Duration') }} <sup>*</sup></label>
                                <input type="number" class="form-control" name="duration">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Google Recaptcha') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="captcha">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Manual Request') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="menual_req">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Monthly Request') }} <sup>*</sup></label>
                                <input type="number" class="form-control" name="monthly_req">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Daily Request') }} <sup>*</sup></label>
                                <input type="number" class="form-control" name="daily_req">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Is Auto') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="is_auto">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Free Trial') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="is_trial">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Mail Activity') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="mail_activity">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Storage Limit') }} <sup>*</sup></label>
                                <input type="number" class="form-control" name="storage_limit">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Fraud Check') }}</label>
                                <select name="fraud_check" class="form-control selectric">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Is Featured') }} <sup>*</sup></label>
                                <select name="is_featured" class="form-control selectric">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Is Default') }} <sup>*</sup></label>
                                <select name="is_default" class="form-control selectric">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select name="status" class="form-control selectric">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
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


