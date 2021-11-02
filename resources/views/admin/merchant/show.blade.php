@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Merchant View'])
@endsection

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
                            <td><small>{{$data->public_key ?? "null"}}</small></td>
                        </tr>
                        <tr>
                            <td>{{ __('Private Key')}}</td>
                            <td><small>{{$data->private_key ?? "null"}}</small></td>
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
                        <tr>
                            <td>{{ __('Send Mail') }}</td>
                            <td><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('Send Mail') }}</button></td>
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
                        <tr>
                            <td colspan="2" class="text-center">
                            <p><b>{{ __('Statistics') }}</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Plan Order')}}</td>
                            <td>{{ $orders_total }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Our Profit')}}</td>
                            <td>{{ number_format($profits,2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Current Plan')}}</td>
                            <td>{{ $userplan->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Plan Expire Date')}}</td>
                            <td>{{ $current_plan->exp_date ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Storage Used')}}</td>
                            <td>{{ number_format(folderSize('uploads/'.$data->id),2) }} / {{ number_format($userplan->storage_limit,2) }}MB</td>
                        </tr> 
                        <tr>
                            <td>{{ __('Total Requests')}}</td>
                            <td>{{ number_format($total_requests) }}</td>
                        </tr>  
                        <tr>
                            <td>{{ __('Current Month Requests')}}</td>
                            <td>{{ number_format($current_month_requests) }}</td>
                        </tr>  
                        <tr>
                            <td>{{ __('Today Requests')}}</td>
                            <td>{{ number_format($today_requests) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Supports')}}</td>
                            <td>{{ number_format($supports) }}</td>
                        </tr>              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ url('admin/merchant-send-mail',$data->id) }}" class="basicform" id="mailform">
    @csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Send Mail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Subject') }}<sup>*</sup></label>
                                    <input type="text" class="form-control" name="subject">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Message') }} <sup>*</sup></label>
                                    <textarea name="message" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-primary basicbtn" >{{ __('Send') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('SL.') }}</th>
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
                                <td>{{ $order->plan->name ?? '' }}</td>
                                <td>{{ $order->getway->name ?? '' }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
   <script>
        $('#mailform').on('submit', function(){
            $('.basicbtn').prop('disabled', true);
            $('.basicbtn').text('Please wait...');
        })
   </script>
@endpush
