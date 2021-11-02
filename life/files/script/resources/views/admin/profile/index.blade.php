@extends('layouts.backend.app')

@section('title','User Profile')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'User Profile'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <div class="profile-widget-header  text-center">
                        @if (Auth()->user()->image != '')
                            <img src="{{ asset(Auth()->user()->image) }}" alt="" class="image-thumbnail mt-2">
                        @else
                            <img alt="image" src='https://ui-avatars.com/api/?name={{Auth()->user()->name}}'
                                    class="rounded-circle profile-widget-picture ">
                        @endif
                    </div>
                    <br>
                    <table class="table text-center" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Description') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ __('Name')}}</td>
                            <td>{{Auth()->user()->name}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Email')}}</td>
                            <td>{{Auth()->user()->email}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('phone')}}</td>
                            <td>{{Auth()->user()->phone ?? "null"}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('status')}}</td>
                            <td>@if(Auth()->user()->status ==1)
                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col-sm-12">
                        <a type="submit" href="{{ route('admin.profile.create') }}"
                            class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Edit') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


