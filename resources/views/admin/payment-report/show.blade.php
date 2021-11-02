@extends('layouts.backend.app')

@section('title','Payment View')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Payment View'])
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Payment Information') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>{{ __('Order Created Date') }}</td>
                                <td><b>{{$data->created_at->format('d.m.Y')}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Order Created At') }}</td>
                                <td><b>{{$data->created_at->diffForHumans()}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Gateway Method Name') }}</td>
                                <td><b>{{$data->getway->name ?? 'null'}}</b></td>
                            </tr>

                            <tr>
                                <td>{{ __('Order Amount') }}</td>
                                <td><b>{{$data->amount}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Trx Id') }}</td>
                                <td><b>{{$data->trx_id}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Status') }}</td>
                                <td>
                                    @if($data->status ==1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ __('Deactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Download Invoice') }}</td>
                                <td><b> <a href="{{ url('admin/payment-report-invoice',$data->id)}}" class="btn btn-icon btn-dark">pdf</a></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Request Information') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>{{ __('Request Amount') }}</td>
                                    <td><b>{{$data->request->amount}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Calculated Amount') }}</td>
                                    <td><b>{{$data->request->calculated_amount}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Count') }}</td>
                                    <td><b>{{$data->request->count}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Ip') }}</td>
                                    <td><b>{{$data->request->ip}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Is Test') }}</td>
                                    <td>
                                        @if($data->request->is_test ==1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('Deactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div class="col-sm-12">
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
                                    <td><b><a href="#">{{$data->user->name}}</a></b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('User Email') }}</td>
                                    <td><a href="mailto:{{$data->user->email}}"><b>{{$data->user->email}}</b></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('User Phone') }}</td>
                                    <td><b><a href="#">{{$data->user->phone}}</a></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

