@extends('layouts.backend.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Dashboard') }}</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Earning') }}</h4>
                        </div>
                        <div class="card-body" id="total_earning">
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="loader">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Requests') }}</h4>
                        </div>
                        <div class="card-body" id="total_request">
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="loader">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Payment') }}</h4>
                        </div>
                        <div class="card-body" id="total_payment">
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="loader">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Expire Date') }}</h4>
                        </div>
                        <div class="card-body" id="expire_date">
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">{{ __('API Keys') }}
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="chart_loader">
                        </h4>
                        <div class="card-header-action">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="far fa-edit"></i>{{ __('Edit') }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ __('NAME') }}</th>
                                        <th>{{ __('TOKEN') }}</th>
                                        <th>{{ __('CREATED AT') }}</th>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Publishable key') }}</td>
                                        <td>{{ Auth::User()->public_key }}</td>
                                        <td>{{ Auth::User()->created_at->isoFormat('ll') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Secret key') }}</td>
                                        <td>{{ Auth::User()->private_key }}</td>
                                        <td>{{ Auth::User()->created_at->isoFormat('ll') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Currency') }}</td>
                                        <td>{{ Auth::User()->currency }}</td>
                                        <td>{{ Auth::User()->created_at->isoFormat('ll') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                    <h4 class="card-header-title plan_name"></h4>
                    <span class="badge badge-soft-secondary plan_expire"></span>
                    <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="expire_loader">
                    </div>
                    <div class="card-header">
                    <h4 class="card-header-title">{{ __('Storage Used') }}</h4>
                    <span class="badge badge-soft-secondary storage"></span>
                    </div>
                    <div class="card-header">
                    <h4 class="card-header-title">{{ __('Daily Requests') }}</h4>
                    <span class="badge badge-soft-secondary daily_request"></span>
                    </div>
                    <div class="card-header">
                    <h4 class="card-header-title">{{ __('Monthly Requests') }}</h4>
                    <span class="badge badge-soft-secondary monthly_request"></span>
                    </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">{{ __('Earnings performance') }}
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="chart_loader">
                        </h4>
                        <div class="card-header-action">
                            <select class="form-control" id="day" name="day">
                                <option value="7" selected>{{ __('Last 7 Days') }}</option>
                                <option value="15">{{ __('Last 15 Days') }}</option>
                                <option value="30">{{ __('Last 30 Days') }}</option>
                                <option value="365">{{ __('Last 365 Days') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="earningchart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4><a href="{{ route('merchant.payment-report.index') }}">{{ __('Recent Payments') }}</a>
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="payment_loader">
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap card-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('SL.') }}</th>
                                        <th>{{ __('Gateway') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Trx Id') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('View') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="payments">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Credentials') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('merchant.dashboard.keys.update') }}" class="basicform_with_reload">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>{{ __('Public Key') }}<sup>*</sup></label>
                    <input type="text" class="form-control mb-2" name="public_key"
                        value="{{ old('public_key') ? old('public_key') : Auth()->user()->public_key }}">
                    <button id="public_key"
                        class="btn btn-primary btn-sm">{{ __('Generate') }}</button>
                </div>
                <div class="form-group">
                    <label>{{ __('Private Key') }} <sup>*</sup></label>
                    <input type="text" class="form-control mb-2" name="private_key"
                        value="{{ old('private_key') ? old('private_key') : Auth()->user()->private_key }}">
                    <button id="private_key"
                        class="btn btn-primary btn-sm">{{ __('Generate') }}</button>
                </div>
                <div class="form-group">
                    <label>{{ __('Currency') }}<sup>*</sup></label>
                    <input type="text" class="form-control" name="currency"
                        value="{{ old('currency') ? old('currency') : Auth()->user()->currency }}">
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit"
                            class="btn btn-primary btn-lg float-right basicbtn">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>


  <input type="hidden" value="{{ url('merchant/earning/') }}" id="earningurl">
  <input type="hidden" value="{{ url('merchant/stats/') }}" id="statsurl">
  <input type="hidden" value="{{ url('merchant/payment-report/') }}" id="paymentview">
  <input type="hidden" value="{{ url('merchant/keygenerate') }}" id="keygenerate">
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/chart.js') }}"></script>
    <script src="{{ asset('backend/admin/assets/js/userdashboard.js') }}"></script>
@endpush
