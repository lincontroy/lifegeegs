@extends('layouts.backend.app')

@section('title','Plan List')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Plan List','button_name'=> 'Add New','button_link'=> route('admin.plan.create')])
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
                <div class="col-sm-8">
                    <a href="{{ url('/admin/plan') }}" class="mr-2 btn btn-outline-primary  active ">All
                        ({{$all}})</a>
                    <a href="{{ url('/admin/plan?1') }}"
                        class="mr-2 btn btn-outline-success ">Active ({{$active}})</a>
                    <a href="{{ url('/admin/plan?0') }}"
                        class="mr-2 btn btn-outline-danger ">Inactive ({{$inactive}})</a>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Plan Name') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Total Orders') }}</th>
                            <th>{{ __('Active Orders') }}</th>
                            <th>{{ __('Total Earnings') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = ($data->currentpage()-1)* $data->perpage() + 1;
                            @endphp
                            @forelse($data as $key => $value)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->price}}</td>
                                <td>{{$value->duration}}</td>
                                <td>{{ $value->orders_count }}</td>
                                <td>{{ $value->acitveorders_count }}</td>
                                <td>{{ number_format($value->orders_sum_amount,2) }}</td>
                                <td>@if($value->status ==1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                         <a class="dropdown-item has-icon" href="{{ route('admin.plan.show', $value->id) }}"><i class="fa fa-eye"></i>{{ __('View') }}</a>
                                        <a class="dropdown-item has-icon" href="{{ route('admin.plan.edit', $value->id) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-id={{ $value->id }}><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $value->id }}" action="{{ route('admin.plan.destroy', $value->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"><p class="text-center">{{ __('No Data Found') }}</p></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
