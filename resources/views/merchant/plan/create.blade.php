@extends('layouts.backend.app')

@section('title', 'Create Plan')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Plan Create','button_name'=> 'All Plans','button_link'=>
    route('admin.plan.index')])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Create Plan') }}</h4>
                </div>
                <form method="POST" action="{{ route('admin.plan.store') }}" class="basicform">
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
                                    <input type="number" id="price" class="form-control" name="price">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Duration') }} <sup>*</sup></label>
                                    <input type="text" class="form-control" name="duration">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Google Recaptcha') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Manual Request') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Monthly Request') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Daily Request') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Is Auto') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Free Trial') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Mail Activity') }} <sup>*</sup></label>
                                    <select class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="2">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Storage Limit') }} <sup>*</sup></label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit"
                                    class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
