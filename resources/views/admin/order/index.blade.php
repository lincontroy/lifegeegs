@extends('layouts.backend.app')

@section('title','Order Lists')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Order List','button_name'=> 'Add New','button_link'=>
    route('admin.order.create')])
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
                <div class="col-sm-12">
                    <div class="float-right">
                      <form>            
                        <div class="input-group mb-2">
                          <input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                          <select class="form-control selectric" name="type" id="type">
                            <option value="payment_id">{{ __('Search By Payment Id') }}</option>
                        </select>
                        <div class="input-group-append">                                            
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>       
            <div class="float-left mb-1">
               <a href="{{ url('/admin/order') }}" class="mr-2 btn btn-outline-primary {{ $st == "" ? 'active' : '' }}"> {{ __('All') }}
               ({{$all}})</a>
               <a href="{{ url('/admin/order?1') }}" class="mr-2 btn btn-outline-success {{ $st == "1" ? 'active' : '' }}"> {{ __('Accepted') }}
               ({{$active}})</a>
               <a href="{{ url('/admin/order?0') }}" class="mr-2 btn btn-outline-danger {{ $st == "0" ? 'active' : '' }}"> {{ __('Rejected') }}
               ({{$inactive}})</a>
               <a href="{{ url('/admin/order?3') }}" class="mr-2 btn btn-outline-warning {{ $st == "3" ? 'active' : '' }}"> {{ __('Pending') }}
               ({{$pending}})</a>
               <a href="{{ url('/admin/order?2') }}" class="mr-2 btn btn-outline-secondary {{ $st == "2" ? 'active' : '' }}"> {{ __('Expired') }}
               ({{$expired}})</a>

           </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Plan') }}</th>
                            <th>{{ __('Gateway') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Payment Status') }}</th> 
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)

                            <tr>
                                <td>{{ $order->payment_id }}</td>
                                <td><a href="{{ route('admin.merchant.show',$order->user_id) }}">{{ $order->user->name }}</a></td>
                                <td>{{ $order->plan->name }}</td>
                                <td>{{ $order->getway->name }}</td>
                                <td>{{ $order->amount }}</td>
                                <td>
                                    @php
                                    $pay_status = [
                                        0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                                        1 => ['class' => 'badge-primary', 'text' => 'Paid'],
                                        2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                        3 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                    ][$order->payment_status];
                                    @endphp
                                    <span class="badge {{ $pay_status['class'] }}">{{ $pay_status['text'] }}</span>
                                </td>
                                <td>
                                    @php
                                    $status = [
                                        0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                                        1 => ['class' => 'badge-primary', 'text' => 'Accepted'],
                                        2 => ['class' => 'badge-danger', 'text' => 'Expired'],
                                        3 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                        4 => ['class' => 'badge-danger', 'text' => 'Trash'],
                                    ][$order->status];
                                    @endphp
                                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.order.show', $order->id) }}"><i
                                                class="fa fa-eye"></i>{{ __('View') }}</a>
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.order.edit', $order->id) }}"><i
                                                class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                                            data-id={{ $order->id }}><i
                                                class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $order->id }}"
                                                action="{{ route('admin.order.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                     {{ $orders->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

