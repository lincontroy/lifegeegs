@extends('layouts.backend.app')

@section('title','Edit Merchant')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Merchant Edit','button_name'=> 'All Merchants','button_link'=> route('admin.merchant.index')])
@endsection

@push('before_css')
    <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/selectric.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td colspan="2" class="text-center">
                                @if ($data->image != '')
                                <img src="{{ asset($data->image) }}" alt="" class="image-thumbnail mt-2">
                            @else
                                <img alt="image" src='https://ui-avatars.com/api/?name={{$data->name}}'
                                     class="rounded-circle profile-widget-picture ">
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Name')}}</td>
                            <td>{{$data->name}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Email')}}</td>
                            <td>{{$data->email}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('phone')}}</td>
                            <td>{{$data->phone ?? "null"}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Public Key')}}</td>
                            <td>{{$data->public_key ?? "null"}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Private Key')}}</td>
                            <td>{{$data->private_key ?? "null"}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Currency')}}</td>
                            <td>{{$data->currency ?? "null"}}</td>
                        </tr>
                        <tr>
                            <tr>
                                <td>{{ __('status')}}</td>
                                <td>@if($data->status ==1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tr>
                        <tr>
                            <td>{{ __('Created At') }}</td>
                            <td>{{ $data->created_at->isoFormat('LL') }}</td>
                        </tr>                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <form method="POST" action="{{ route('admin.merchant.update',$data->id) }}" class="basicform">
                              @csrf
                              @method("PUT")
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>{{ __('Name') }}</label>
                                                <input type="text" required="" name="name" class="form-control" value="{{ $data->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Email') }}</label>
                                                <input type="email" required="" name="email" class="form-control" value="{{ $data->email }}">
                                            </div>
                                              <div class="form-group">
                                                <label>{{ __('Password') }}</label>
                                                <input type="password" name="password" class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Select Status') }}</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" {{$data->status == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                                    <option value="0" {{$data->status == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg basicbtn">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                          </form>      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('backend/admin/assets/js/selectric.js') }}"></script>
@endpush

