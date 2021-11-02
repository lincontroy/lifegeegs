@extends('layouts.backend.app')

@section('title', 'Create Request')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Create Request','button_name'=> 'All
    Requests','button_link'=> route('merchant.request.index')])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Create Request') }}</h4>
                </div>
                <form method="POST" action="{{ route('merchant.request.store') }}" class="requestform">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Purpose') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="purpose">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Amount') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" step="0.01" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Captcha Status') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="captcha_status">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Test') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="is_test">
                                    <option value="1">{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                            <div class="col-sm-12 col-md-7" name="status">
                                <select name="status" class="form-control">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary basicbtn btn-lg w-100"
                                    type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" class="redirectUrl" value="{{ route('merchant.request.index') }}">
    <input type="hidden" value="{{ url('/checkout') }}/" id="url">
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/create_request.js') }}"></script>
@endpush
