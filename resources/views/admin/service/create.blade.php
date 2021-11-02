@extends('layouts.backend.app')

@section('title','Create Service')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Service Create','button_name'=> 'Manage Service','button_link'=> route('admin.service.index')])
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Service ') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.service.store') }}" class="basicform_with_reset">
                @csrf
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="title">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Image') }} </label>
                        <div class="col-sm-12 col-md-7" >
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Short Description') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" name="short_description" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea  name="description" class="summernote form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary btn-lg basicbtn w-100" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@if(env('CONTENT_EDITOR') == true)
@push('js')
  <script src="{{ asset('backend/admin/assets/js/summernote-bs4.js') }}"></script>
  <script src="{{ asset('backend/admin/assets/js/summernote.js') }}"></script>
@endpush
@endif


