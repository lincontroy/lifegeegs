@extends('layouts.backend.app')

@section('title','User Plan Edit')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'User Plan Edit','button_name'=> 'All','button_link'=> route('admin.user-plan-report.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('User Information') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>{{ __('User Name') }}</td>
                                <td><b><a href="#">{{ $data->user->name }}</a></b></td>
                            </tr>
                            <tr>
                                <td>{{ __('User Email') }}</td>
                                <td><a href="mailto:{{ $data->user->email }}"><b>{{ $data->user->email }}</b></a></td>
                            </tr>
                            <tr>
                                <td>{{ __('User Phone') }}</td>
                                <td><b>{{ $data->user->phone ?? 'null' }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><br>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Edit User Plan') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.user-plan-report.update',$data->id) }}" class="basicform">
                @method("PUT")
                @csrf
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Google Captcha') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="captcha" class="form-control">
                                <option value="1" {{$data->captcha == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                <option value="0" {{$data->captcha == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Menual Request') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="menual_req" class="form-control">
                                <option value="1" {{$data->menual_req == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                <option value="0" {{$data->menual_req == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mail Activity') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="mail_activity" class="form-control">
                                <option value="1" {{$data->mail_activity == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                <option value="0" {{$data->mail_activity == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Fraud Check') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="fraud_check" class="form-control">
                                <option value="1" {{$data->fraud_check == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                <option value="0" {{$data->fraud_check == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Monthly Request') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control" name="monthly_req" value="{{old('monthly_req') ? old('monthly_req') :$data->monthly_req}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Daily Request') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control" name="daily_req" value="{{old('daily_req') ? old('daily_req') :$data->daily_req}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Storage Limit') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control" name="storage_limit" value="{{old('storage_limit') ? old('storage_limit') :$data->storage_limit}}">
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


