@extends('layouts.backend.app')

@section('title', 'Request View')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Request View'])
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Request Information') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @forelse($jsonData as $key => $value )
                                    <tr>
                                        <td>{{ ucwords($key) }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @empty
                                @endforelse
                                <tr>
                                    <td>{{ __('Status') }}</td>
                                    <td>
                                        @if ($data->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Request Created Date') }}</td>
                                    <td><b>{{ $data->created_at->format('d.m.Y') }}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Request Created At') }}</td>
                                    <td><b>{{ $data->created_at->diffForHumans() }}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Amount') }}</td>
                                    <td><b>{{ $data->amount }}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Type') }}</td>
                                    <td>
                                        @if ($data->type == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Is test') }}</td>
                                    <td>
                                        @if ($data->is_test == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Ip') }}</td>
                                    <td><b>{{ $data->ip ?? 'null' }}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Status') }}</td>
                                    <td>
                                        @if ($data->captcha_status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('Deactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Download Invoice') }}</td>
                                    <td><b> <a href="{{ url('merchant/request-invoice', $data->id) }}"
                                                class="btn btn-icon btn-primary btn-lg">{{ __('Download PDF') }}</a></b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
