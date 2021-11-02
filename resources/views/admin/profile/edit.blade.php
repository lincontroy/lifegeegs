@extends('layouts.backend.app')
@section('title','Edit Profile')
@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Profile'])
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit') }}</h4>
                </div>
                <form method="POST" action="{{ route('admin.profile.store') }}" class="basicform" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{old('name') ? old('name') :Auth()->user()->name}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="emil" class="form-control" name="email" value="{{old('email') ? old('email') :Auth()->user()->email}}">
                            </div>
                        </div>
             
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Phone') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="phone" class="form-control" name="phone" value="{{old('phone') ? old('phone') :Auth()->user()->phone}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Password') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="password" class="form-control" name="password"
                                    >
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Image') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="file" class="form-control" name="image">
                                @if (Auth()->user()->image != '')
                                    <img src="{{ asset(Auth()->user()->image) }}" alt="" class="image-thumbnail mt-2">
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary btn-lg basicbtn">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


