@extends('layouts.backend.app')

@section('title','Merchant List')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Merchant List','button_name'=> 'Add New','button_link'=> route('admin.merchant.create')])
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
                <div class="float-right">
                  <form>            
                    <div class="input-group mb-2">
                      <input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                      <select class="form-control selectric" name="type" id="type">
                        <option value="name">{{ __('Search By Name') }}</option>
                        <option value="email">{{ __('Search By Email') }}</option>
                        <option value="phone">{{ __('Search By Phone') }}</option>
                      </select>
                      <div class="input-group-append">                                            
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>       
                <div class="float-left mb-1">
                 <a href="{{ url('/admin/merchant') }}" class="mr-2 btn btn-outline-primary  active ">{{ __('All') }}
                        ({{$all}})</a>
                    <a href="{{ url('/admin/merchant?1') }}" class="mr-2 btn btn-outline-success ">{{ __('Accepted') }}
                        ({{$active}})</a>
                    <a href="{{ url('/admin/merchant?0') }}" class="mr-2 btn btn-outline-danger ">{{ __('Rejected') }}
                        ({{$inactive}})</a>
           
                </div>
          
                <br>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                            <tr>
                                <th>{{ __('SL.') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone No.') }}</th>
                                <th>{{ __('Plan') }}</th>
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
                                <td>{{$value->email}}</td>
                                <td>{{$value->phone}}</td>
                                <td>{{ $value->plan->name ?? '' }}</td>
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
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.merchant.show', $value->id) }}"><i
                                                class="fa fa-eye"></i>{{ __('View') }}</a>

                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.merchant.edit', $value->id) }}"><i
                                                class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                         <a class="dropdown-item has-icon"
                                            href="{{ route('admin.merchant.login', $value->id) }}"><i
                                                class="fa fa-key"></i>{{ __('Login') }}</a>        

                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                                            data-id={{ $value->id }}><i class="fa fa-trash"></i>{{ __('Delete') }}
                                        </a>
                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $value->id }}"
                                                action="{{ route('admin.merchant.destroy', $value->id) }}"
                                                method="POST">
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
                    {{ $data->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@isset($request->type)
@push('js')
<script type="text/javascript">
    "use strict";

    $('#type').val('{{ $request->type ?? '' }}')
</script>
@endpush
@endisset
