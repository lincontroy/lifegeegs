@extends('layouts.backend.app')

@section('title', 'Merchant Payment Report')

@section('head')
    @include('layouts.backend.partials.headersection', ['title'=>'Merchant Payment Report'])
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
                        <div class="col-6">
                            <form action="{{ url('/merchant/payment-report') }}" type="get">
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
                        <div class="col-6 mt-2">
                            <form action="{{ url('/merchant/payment-report') }}" type="get">
                                <div class="input-group form-row mt-3">
                                    <input type="text" class="form-control" placeholder="Search ..." required=""
                                        name="value" autocomplete="off" value="">
                                    <select class="form-control" name="type">
                                        <option value="amount">{{ __('amount') }}</option>
                                        <option value="getway_name">{{ __('gateway name') }}</option>
                                        <option value="trx_id">{{ __('trx id') }}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="buttons">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="table-2">
                            <thead>
                                <tr>
                                    <th>{{ __('SL.') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('gateway name') }}</th>
                                    <th>{{ __('Trx Id') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = ($data->currentpage() - 1) * $data->perpage() + 1;
                                @endphp
                                @forelse($data as $key =>$value)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $value->amount ?? 'null' }}</td>
                                        <td>{{ $value->getway->name ?? 'null' }}</td>
                                        <td>{{ $value->trx_id ?? 'null' }}</td>
                                        <td>
                                            @if ($value->status == 1)
                                            <span class="badge badge-success">Success</span>
                                            @elseif($value->status == 2)
                                            <span class="badge badge-warning">Pending</span>
                                            @elseif($value->status == 0)
                                            <span class="badge badge-danger">Inactive</span>
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
                                                    href="{{ route('merchant.payment-report.show', $value->id) }}"><i
                                                        class="far fa-eye"></i>{{ __('View') }}</a>
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
