@extends('layouts.backend.app')

@section('title','Service Lists')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Service List','button_name'=> 'Add New','button_link'=> route('admin.service.create')])
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
                    <table class="table" id="table-2">
                        <thead>
                            <tr>
                                <th>{{ __('SL.') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = ($data->currentpage()-1)* $data->perpage() + 1;
                            @endphp
                            @forelse($data as $key => $value)
                            @php $json = json_decode($value->termMeta->value ) @endphp
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$value->title}}</td>
                                <td><img src="{{ asset($json->image ?? 'no-img.png') }}" alt="" height="50", width="100"></td>
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
                                            href="{{ route('admin.service.edit', $value->id) }}"><i
                                                class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-id={{ $value->id }}><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $value->id }}" action="{{ route('admin.service.destroy', $value->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <p class="text-danger">{{ __('No data') }}</p>
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

