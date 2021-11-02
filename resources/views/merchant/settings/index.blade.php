@extends('layouts.backend.app')

@section('title', 'Edit Settings')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit Settings'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card">
                    <form method="POST" action="{{ route('merchant.settings.store') }}" class="basicform">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company Name') }}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ old('company_name') ? old('company_name') : $data->company_name ?? null }}">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company Email') }}</label>
                                <div class="col-sm-12 col-md-7" name="status">
                                    <input type="email" id="company_email" class="form-control" name="company_email"
                                        value="{{ old('company_email') ? old('company_email') : $data->company_email ?? null }}">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company Phone') }}</label>
                                <div class="col-sm-12 col-md-7" name="status">
                                    <input type="number" class="form-control" name="company_phone"
                                        value="{{ old('company_phone') ? old('company_phone') : $data->company_phone ?? null }}">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company City') }}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="company_city"
                                        value="{{ old('company_city') ? old('company_city') : $data->company_city ?? null }}">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company Address') }}</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="form-control" id="company_address" name="company_address" rows="4"
                                        cols="50">{{ $data->company_address ?? null }}</textarea>
                                </div>
                            </div>

                            

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Callback url') }}</label>
                                <div class="col-sm-12 col-md-7" name="status">
                                    <input class="form-control" id="w3review" name="callback" 
                                        {{ $data->callback ?? null }}>
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
    </div>
@endsection
