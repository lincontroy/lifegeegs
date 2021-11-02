@extends('layouts.backend.app')

@section('title','User Plan')

@section('head')
    @include('layouts.backend.partials.headersection', ['title'=>'User Plan'])
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
                <div class="row">
                    <div class="col-5">
                        <form action="{{ url('/admin/user-plan') }}" type="get">
                            <div class="form-row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>{{ __('Start Date') }}</label>
                                        <input type="date" class="form-control" name="start_date" required="">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>{{ __('End Date') }}</label>
                                        <input type="date" class="form-control" name="end_date" required="">
                                    </div>
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3 mt-2">
                        <form action="{{ url('/admin/user-plan') }}" type="get">
                            <div class="input-group form-row mt-3">
                                <select class="form-control" name="select_day">
                                    <option value="today">{{ __('Today') }}</option>
                                    <option value="thisWeek">{{ __('This Week') }}</option>
                                    <option value="thisMonth">{{ __('This Month') }}</option>
                                    <option value="thisYear">{{ __('This Year') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 mt-2">
                        <form action="/admin/user-plan" type="get">
                            <div class="input-group form-row mt-3">
                                <input type="text" class="form-control" placeholder="Search ..." required="" name="value" autocomplete="off" value="">
                                <select class="form-control" name="type">
                                    <option value="customer_name">{{ __('Customer name') }}</option>
                                    <option value="customer_email">{{ __('Customer email') }}</option>
                                    <option value="plan_name">{{ __('Plan Name') }}</option>
                                    <option value="storage_limit">{{ __('Storage Limit') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('User Plan Name') }}</th>
                            <th>{{ __('user Phone') }}</th>
                            <th>{{ __('user Email') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Storage Limit') }}</th>
                            <th>{{ __('Created Date') }}</th>
                            <th>{{ __('Created Time') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $key =>$value)
                            <tr>
                                <td>{{$value->user->name ?? 'null'}}</td>
                                <td>{{$value->user->phone ?? 'null'}}</td>
                                <td>{{$value->user->email ?? 'null'}}</td>
                                <td>{{$value->name ?? 'null'}}</td>
                                <td>{{$value->user->storage_limit ?? 'null'}}</td>
                                <td>{{$value->created_at->format('d.m.Y') ?? 'null'}}</td>
                                <td>{{$value->created_at->diffForHumans() ?? 'null'}}</td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.user-plan-report.edit', $value->id) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon" href="{{ route('admin.user-plan-report.show', $value->id) }}"><i class="far fa-eye"></i>{{ __('View') }}</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
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

