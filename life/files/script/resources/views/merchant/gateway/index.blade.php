@extends('layouts.backend.app')

@section('title', 'Payment gateway Install')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Payment Gateway'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            @if (Session::has('message'))
                <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }}</div>
            @endif
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-center" id="home-tab4" data-toggle="tab" href="#home4"
                                        role="tab" aria-controls="home"
                                        aria-selected="true">{{ __('Manual Payment') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center" id="profile-tab4" data-toggle="tab" href="#profile4"
                                        role="tab" aria-controls="profile"
                                        aria-selected="false">{{ __('Alternative Payment') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content no-padding" id="myTab2Content">
                                <div class="tab-pane fade show active" id="home4" role="tabpanel"
                                    aria-labelledby="home-tab4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered  card-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Payment Gateway Name') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($gateway_manual ?? [] as $gateway)
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0"><b>{{ $gateway->name }}</b></p>
                                                            <small class="show"></small>
                                                            <p class="mb-0 text-muted small">
                                                                {{ $gateway->usergetwaycreds ? 'Installed' : '' }}</p>
                                                        </td>
                                                        <td width="70" class="text-right">
                                                            <a href="{{ route('merchant.gateway.edit', $gateway->id) }}"
                                                                class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered card-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Payment Gateway Name') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($gateway_auto ?? [] as $gateway)
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0"><b>{{ $gateway->name }}</b></p>
                                                            <small class="show"></small>
                                                            <p class="mb-0 text-muted small">
                                                                {{ $gateway->usergetwaycreds ? 'Installed' : '' }}</p>
                                                        </td>
                                                        <td width="70" class="text-right">
                                                            <a href="{{ route('merchant.gateway.edit', $gateway->id) }}"
                                                                class="btn btn-success"><i class="fa fa-edit"></i></a>
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
                </div>
            </div>
        </div>
    </div>
@endsection
