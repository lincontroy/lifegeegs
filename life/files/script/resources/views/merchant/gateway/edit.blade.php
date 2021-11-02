@extends('layouts.backend.app')

@section('title', 'Payment Gateway Install')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit  ' . $gateway->name,'prev'=>route('merchant.gateway.index')])
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            @if (Session::has('message'))
                <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }}</div>
            @endif
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="basicform_with_reload" action="{{ route('merchant.gateway.store') }}">
                        @csrf
                        <input type="hidden" name="gateway_id" value="{{ $gateway->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('Display name at checkout') }}</label>
                                <input class="form-control" autofocus="" required="" name="name" type="text"
                                    value="{{ $gateway->usergetwaycreds->name ?? $gateway->name }}">
                                <small
                                    class="form-text text-muted">{{ __('Customers will see this when checking out.') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Currency') }}</label>
                                <input class="form-control" autofocus="" required="" name="currency_name" type="text"
                                    value="{{ $gateway->usergetwaycreds->currency_name ?? '' }}">
                            </div>
                            @if ($gateway->is_auto == 0)
                            <div class="form-group">
                                @php $info = $gateway->usergetwaycreds ? json_decode($gateway->usergetwaycreds->data) : '' @endphp
                                <label>{{ __('Instruction') }}</label>
                                <input class="form-control" autofocus="" required="" name="instruction" type="text" value="{{ $info->instruction ?? '' }}">
                            </div>
                            @endif
                           
                            <div class="form-group">
                                <label>{{ __('Phone Required') }}</label>
                                <select class="form-control" name="phone_required" id="">
                                    <option value="1"
                                        {{ !empty($gateway->usergetwaycreds) ? ($gateway->usergetwaycreds->phone_required == 1 ? 'selected' : '') : '' }}>
                                        {{ __('Yes') }}</option>
                                    <option value="0"
                                        {{ !empty($gateway->usergetwaycreds) ? ($gateway->usergetwaycreds->phone_required == 0 ? 'selected' : '') : '' }}>
                                        {{ __('No') }}</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Rate') }}</label>
                                        <input class="form-control" required=""
                                            value="{{ !empty($gateway->usergetwaycreds) ? $gateway->usergetwaycreds->rate : 1 }}"
                                            step="0.01" name="rate" required="" type="number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Fee') }}</label>
                                        <input class="form-control" required=""
                                        value="{{ !empty($gateway->usergetwaycreds) ? $gateway->usergetwaycreds->charge : 1 }}"
                                            step="0.01" name="charge" required="" type="number">
                                    </div>
                                </div>
                            </div>
                            @if ($gateway->is_auto == 1)
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>{{ __('Test Credentials') }}</h5>
                                        @php $exist_info = $gateway->usergetwaycreds ? json_decode($gateway->usergetwaycreds->sandbox) : [];
                                            $sandbox = '';
                                        @endphp
                                        @foreach (json_decode($gateway->data) ?? [] as $key => $info)
                                            <div class="form-group">
                                                <label>{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                                @foreach ($exist_info as $k => $value)
                                                    @if ($k == $key)
                                                        @php $sandbox = $value @endphp
                                                    @endif
                                                @endforeach
                                                <input class="form-control" required="" value="{{ $sandbox }}"
                                                    name="sandbox[{{ $key }}]" required="" type="text">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <h5>{{ __('Live Credentials') }}</h5>
                                        @php $exist_info = $gateway->usergetwaycreds ? json_decode($gateway->usergetwaycreds->production) : [];
                                            $production = '';
                                        @endphp
                                        @foreach (json_decode($gateway->data) ?? [] as $key => $info)
                                            <div class="form-group">
                                                <label>{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                                @foreach ($exist_info as $k => $value)
                                                    @if ($k == $key)
                                                        @php $production = $value @endphp
                                                    @endif
                                                @endforeach
                                                <input class="form-control" required="" value="{{ $production }}"
                                                    name="production[{{ $key }}]" required="" type="text">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="custom-control custom-switch">
                                <input id="enabled" class="custom-control-input" name="status" type="checkbox" value="1"
                                    {{ !empty($gateway->usergetwaycreds) ? ($gateway->usergetwaycreds->status ? 'checked' : '') : '' }}>
                                <label class="custom-control-label" for="enabled">{{ __('Enable') }}</label>
                            </div>
                        </div>
                        <div class="card-footer clearfix text-muted">
                            <div class="float-left clear-both">
                                <a class="btn btn-white"
                                    href="{{ route('merchant.gateway.index') }}">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary basicbtn btn-lg">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
