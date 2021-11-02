@extends('layouts.backend.app')

@section('title', 'Edit Profile')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit Profile'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card">
                    <form method="POST" action="{{ route('merchant.profile.store') }}" class="basicform"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Name') }}<sup>*</sup></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') ? old('name') : Auth()->user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Email') }} <sup>*</sup></label>
                                        <input type="text" id="emil" class="form-control" name="email"
                                            value="{{ old('email') ? old('email') : Auth()->user()->email }}">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-row">
                              
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Image') }}<sup>*</sup></label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Phone') }}</label>
                                        <input type="text" id="phone" class="form-control" name="phone"
                                            value="{{ old('phone') ? old('phone') : Auth()->user()->phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Password') }}</label>
                                        <input type="password" id="password" class="form-control" name="password">
                                       
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-lg-3">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/edit-profile.js') }}"></script>
@endpush
