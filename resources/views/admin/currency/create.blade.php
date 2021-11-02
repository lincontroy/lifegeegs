@extends('layouts.backend.app')

@section('title','Create Currency')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Currency Create','button_name'=> 'Manage Currency','button_link'=> route('admin.currency.index')])
@endsection

@push('before_css')
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/selectric.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Currency Gateway') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.currency.store') }}" class="basicform">
                @csrf
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Symbol') }} </label>
                        <div class="col-sm-12 col-md-7" >
                            <input type="text" id="price" class="form-control" name="symbol">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Position') }}</label>
                        <div class="col-sm-12 col-md-7" >
                            <select name="position" class="form-control selectric">
                                <option value="1">{{ __('Left') }}</option>
                                <option value="0">{{ __('Right') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control selectric">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company Address') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" id="company_address" name="company_address" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Invoice Description') }}</label>
                        <div class="col-sm-12 col-md-7" name="status">
                            <textarea class="form-control" id="w3review" name="invoice_description" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
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


