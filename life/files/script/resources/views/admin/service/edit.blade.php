@extends('layouts.backend.app')

@section('title','Edit Service')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Service Edit','button_name'=> 'All Service','button_link'=> route('admin.service.index')])
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Edit Service') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.service.update',$data->id) }}" class="basicform_with_reload">
                @method("PUT")
                @csrf
                @php $json = json_decode($data->termMeta->value ) @endphp
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="title" value="{{old('title') ? old('title') :$data->title}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Image') }} </label>
                        <div class="col-sm-12 col-md-7" >
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7" >
                            <img src="{{ asset($json->image ?? 'no-img.png') }}" alt="" height="80", width="150">
                        </div>
                    </div>

                    

                    
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Short Description') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" id="short_des" name="short_description" rows="4" cols="50">{{ $json->short_des }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="summernote form-control" name="description">{{ $json->des }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control">
                                <option value="1" {{$data->status == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                <option value="0" {{$data->status == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary basicbtn w-100" type="submit">{{ __('Save') }}</button>
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
