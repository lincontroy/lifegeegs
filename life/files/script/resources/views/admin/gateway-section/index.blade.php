@extends('layouts.backend.app')

@section('title','Edit Gateway Section')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit Gateway Section'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card">
                <form method="POST" action="{{ url('admin/gateway-section-store') }}" class="basicform">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('First Title ') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="first_title" value="{{old('first_title') ? old('first_title') :$data->first_title ?? null}}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('First Description') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" id="des" name="first_des" rows="4" cols="50">{{$data->first_des ?? null}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Second Title ') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="second_title" value="{{old('second_title') ? old('second_title') :$data->second_title ?? null}}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Second Description') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" id="second_des" name="second_des" rows="4" cols="50">{{$data->second_des ?? null}}</textarea>
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


