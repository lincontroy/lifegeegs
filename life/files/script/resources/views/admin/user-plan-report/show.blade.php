@extends('layouts.backend.app')

@section('title','User Plan Report View')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'User Plan Report View'])
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Order Information') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td>{{ __('User Plan Name')}}</td>
                            <td><b>{{$data->name}}</b></td>
                        </tr>
                        <tr>
                            <td>{{ __('Order Created Date')}}</td>
                            <td><b>{{$data->created_at->format('d.m.Y')}}</b></td>
                        </tr>
                        <tr>
                            <td>{{ __('Order Created At')}}</td>
                            <td><b>{{$data->created_at->diffForHumans()}}</b></td>
                        </tr>

                        <tr>
                            <td>{{ __('Captcha')}}</td>
                            <td>@if($data->captcha ==1)
                                    <span class="badge badge-success">{{ __('Active')}}</span>
                                @else
                                    <span class="badge badge-warning">{{ __('Deactive')}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td> {{ __('Manual Request')}}</td>
                            <td>@if($data->menual_req ==1)
                                    <span class="badge badge-success">{{ __('Active')}}</span>
                                @else
                                    <span class="badge badge-warning">{{ __('Deactive')}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td> {{ __('Monthly Request')}}</td>
                            <td><b>{{$data->monthly_req ?? null}}</b></td>
                        </tr>
                        <tr>
                            <td> {{ __('Daily Request ')}}</td>
                            <td><b>{{$data->daily_req ?? null}}</b></td>
                        </tr>
                        <tr>
                            <td> {{ __('Mail Activity')}}</td>
                            <td>@if($data->mail_activity ==1)
                                    <span class="badge badge-success">{{ __('Active')}}</span>
                                @else
                                    <span class="badge badge-warning">{{ __('Deactive')}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td> {{ __('Storage Limit')}}</td>
                            <td><b>{{$data->storage_limit ?? null}}</b></td>
                        </tr>
                        <tr>
                            <td> {{ __('Fraud Check')}}</td>
                            <td>@if($data->fraud_check ==1)
                                    <span class="badge badge-success">{{ __('Active')}}</span>
                                @else
                                    <span class="badge badge-warning">{{ __('Deactive')}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Download Invoice') }}</td>
                            <td><b> <a href="{{ url('admin/user-plan-invoice',$data->id)}}" class="btn btn-icon btn-dark">{{ __('pdf') }}</a></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('User Information')}} </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>{{ __('User Name')}}  </td>
                                <td><b><a href="#">{{$data->user->name}}</a></b></td>
                            </tr>
                            <tr>
                                <td> {{ __('User Email')}}</td>
                                <td><a href="mailto:{{$data->user->email}}"><b>{{$data->user->email}}</b></a></td>
                            </tr>
                            <tr>
                                <td> {{ __('User Phone')}}</td>
                                <td><b><a href="#">{{$data->user->phone}}</a></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

