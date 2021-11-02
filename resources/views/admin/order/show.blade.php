@extends('layouts.backend.app')

@section('title','Order Information')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Order View'])
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
                            <td>{{ __('Order Created Date')}}</td>
                            <td><b>{{$order->created_at->isoFormat('LL')}}</b></td>
                        </tr>
                        <tr>
                            <td>{{ __('Order Created At')}}</td>
                            <td><b>{{$order->created_at->diffForHumans()}}</b></td>
                        </tr>
                        <tr>
                            <td>Plan</td>
                        <td>{{ $order->plan->name }}</td>
                        </tr>
                        <tr>
                            <td>Getway</td>
                        <td>{{ $order->getway->name }}</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                        <td>{{ $order->amount }}</td>
                        </tr>
                        <tr>
                            <td>Transaction ID</td>
                            <td>{{ $order->payment_id }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            @php
                            $status = [
                              0 => ['class' => 'badge-danger',  'text' => 'Rejected'],
                              1 => ['class' => 'badge-primary', 'text' => 'Accepted'],
                              2 => ['class' => 'badge-danger', 'text' => 'Expired'],
                              3 => ['class' => 'badge-warning', 'text' => 'Pending']
                             ][$order->status]
                             @endphp
                            <td>
                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $order->created_at->isoFormat('LL') }}</td>
                        </tr>
                        <tr>
                            <td>Expire At</td>
                            <td class="text-danger"><strong>{{ \Carbon\Carbon::parse($order->exp_date)->isoFormat('LL') }}</strong></td>
                        </tr>
                        @if(!empty($order->meta->value))
                        <tr>
                            <td>{{ __('Attachment') }}</td>
                            <td><a href="{{ asset($order->meta->value) }}" target="_blank">{{ __('View') }}</a></td>
                        </tr>
                        @endif
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
                                <td>{{ __('User Name')}}</td>
                                <td><a href="{{ route('admin.merchant.show', $order->user_id) }}">{{ $order->user->name }}</a></td>
                            </tr>
                            <tr>
                                <td>{{ __("Email") }}</td>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <td> {{ __('User Phone')}}</td>
                                <td><b><a href="#">{{$order->user->phone ?? 'null'}}</a></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

