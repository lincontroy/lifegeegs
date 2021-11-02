@extends('layouts.backend.app')

@section('title','Edit Hero Section')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit Hero Section'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card">
                <form method="POST" action="{{ url('admin/hero-section-store') }}" class="basicform">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{old('title') ? old('title') :$data->title ?? null}}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Company Address') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" id="des" name="des" rows="4" cols="50">{{$data->des ?? null}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('First Button Text') }}</label>
                            <div class="col-sm-12 col-md-7" name="status">
                                <input type="text" class="form-control" name="start_text" value="{{old('start_text') ? old('start_text') :$data->start_text ?? null}}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('First Button Url') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="start_url" value="{{old('start_url') ? old('start_url') :$data->start_url ?? null}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Contract Button Text') }}</label>
                            <div class="col-sm-12 col-md-7" name="status">
                                <input type="text" class="form-control" name="contact_text" value="{{old('contact_text') ? old('contact_text') :$data->contact_text ?? null}}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Contract Button Url') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="contact_url" value="{{old('contact_url') ? old('contact_url') :$data->contact_url ?? null}}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-12 col-md-7 text-center">
                                <img src="{{ asset($data->image ?? 'no-img.png') }}" alt="" class="image-thumbnail mt-2">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Image') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary basicbtn btn-lg w-100" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


