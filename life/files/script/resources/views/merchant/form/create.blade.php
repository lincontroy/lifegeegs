@extends('layouts.backend.app')

@section('title', 'Form Generate')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Form Generate'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-generator">
                        <input type="hidden" id="public_key" value="{{ Auth::user()->public_key }}">
                        <input type="hidden" id="url" value="{{ route('request.form') }}">
                        <form id="formData" method="post">
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" disabled class="form-control" value="public_key">
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ __('Value') }}</label>
                                            <input type="text" disabled class="form-control"
                                                value="{{ Auth::user()->public_key }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="currency_name" class="form-control" value="currency">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="currency_value" class="form-control" value="usd">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="amount_name" class="form-control" value="amount">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="amount_value" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="email_name" class="form-control" value="email">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="email_value" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="phone_name" class="form-control" value="phone">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="phone_value" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="name_field_name" class="form-control" value="name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="name_field_value" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="is_fallback_name" class="form-control"
                                                value="is_fallback">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <select name="is_fallback_value" class="form-control">
                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0" selected>{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text"  disabled name="fallback_url_name" class="form-control"
                                                value="fallback_url">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="fallback_url_value" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="is_test_name" class="form-control" value="is_test">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <select name="is_test_value" class="form-control">
                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('name') }}</label>
                                            <input type="text" disabled name="purpose_name" class="form-control" value="purpose">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-md-none">{{ __('value') }}</label>
                                            <input type="text" name="purpose_value" class="form-control" value="test">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <button id="generate" type="submit"
                                                class="btn btn-primary mr-2 btn-lg">{{ __('Generate') }}</button>
                                            <button id="copy"
                                                class="btn btn-primary d-none btn-lg">{{ __('Copy') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <pre name="" class="codeForm"
                                        id="form">{{ __('Click on the generate button!!') }}</pre>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/marcent_form.js') }}"></script>
@endpush
