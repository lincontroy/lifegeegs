
@extends('layouts.backend.app')

@section('title','Payment Gateway Edit')

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
                <h4>{{ __('Edit '. $gateway->name) }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.payment-gateway.update', $gateway->id) }}" class="basicform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Name') }}<sup>*</sup></label>
                                <input type="text" class="form-control" name="name" value="{{ $gateway->name }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Logo') }} <sup>*</sup></label>
                                <input type="file" id="logo" class="form-control" name="logo">
                                @if ($gateway->logo != '')
                                    <img src="{{ asset($gateway->logo) }}" alt="" class="image-thumbnail mt-2">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Rate') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="rate" value="{{ $gateway->rate }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Test Mode') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="test_mode">
                                    <option value="1" {{ $gateway->test_mode == 1 ? 'selected' : '' }}>{{ __('Enable') }}</option>
                                    <option value="0" {{ $gateway->test_mode == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Currency Name') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="currency_name" value="{{ $gateway->currency_name }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Fraud Checker') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="fraud_checker">
                                    <option value="1" {{ $gateway->fraud_checker == 1 ? 'selected' : '' }}>{{ __('Enable') }}</option>
                                    <option value="0" {{ $gateway->fraud_checker == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Charge') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="charge" value="{{ $gateway->charge }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Customer Status') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="customer_status">
                                    <option value="1" {{ $gateway->customer_status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ $gateway->customer_status == 0 ? 'selected' : '' }}>{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Global Status') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="global_status">
                                    <option value="1" {{ $gateway->global_status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ $gateway->global_status == 0 ? 'selected' : '' }}>{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        @if ($gateway->is_auto == 1)
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Namespace') }} <sup>*</sup></label>
                                <input type="text" class="form-control" name="namespace" value="{{ $gateway->namespace }}">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Is Auto') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="is_auto">
                                    <option value="1" {{ $gateway->is_auto == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ $gateway->is_auto == 0 ? 'selected' : '' }}>{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Accept Image') }} <sup>*</sup></label>
                                <select class="form-control selectric" name="image_accept">
                                    <option value="1" {{ $gateway->image_accept == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ $gateway->image_accept == 0 ? 'selected' : '' }}>{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        @php $info = json_decode($gateway->data) @endphp
                        @foreach ($info ?? [] as $key => $cred)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ucwords(str_replace("_", " ", $key)) }}</label>
                                    <input type="text" class="form-control" name="data[{{ $key }}]" value="{{ $cred }}">
                                </div>
                            </div>
                        @endforeach
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