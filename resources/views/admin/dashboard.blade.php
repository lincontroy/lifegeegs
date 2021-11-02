@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>{{ __('Dashboard') }}</h1>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{ __('Total Order') }}</h4>
            </div>
            <div class="card-body">
              {{ $all }}
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
              <h4>{{ __('Pending Order') }}</h4>
            </div>
            <div class="card-body">
              {{ $pending }}
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
              <h4>{{ __('Expired Order') }}</h4>
            </div>
            <div class="card-body">
              {{ $expired }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-circle"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{ __('Active Merchant') }}</h4>
            </div>
            <div class="card-body">
              {{ $activeMerchant }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title">{{ __('Request performance') }} 
              <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="earning_loader"></h4>
            <div class="card-header-action">
              <select class="form-control" id="select_type_change" name="type_id">
                <option value="7">{{ __('Last 7 Days') }}</option>
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
      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ __('Recent Orders') }}</h4>
          </div>
          <div class="card-body recentOrders">
            <ul class="list-unstyled list-unstyled-border">
              
                @forelse ($orders as $value)
                <li class="media">
                  <a href="{{ route('admin.merchant.show', $value->user->id) }}" class="mr-2">
                    @if($value->user->image)
                      <img width="50" src="{{ asset($value->user->image) }}" alt="" class="rounded-circle profile-widget-picture">                        
                    @else
                      <img width="50" src="https://ui-avatars.com/api/?name={{$value->user->name}}" alt="">
                    @endif
                  </a>
                    <div class="media-body">
                        <div class="float-right text-primary"><a href="#">{{ $value->created_at->diffForHumans() }}</a></div>
                        <div class="media-title"><a href="{{ route('admin.order.show', $value->id) }}">{{ $value->user->name }}</a></div>
                        <div class="media-title"><a href="{{ route('admin.order.show', $value->id) }}">{{ __('Plan: ').$value->plan->name }}</a>
                        </div>
                      
                    </div>
                </li>
                @empty
                <li class="media">
                    <div class="media-body">
                    <div class="float-right text-primary"><a href="#"></a></div>
                    <div class="media-title  mt-3"><a href="#">{{ __('No Record') }}</a></div>
                    </div>
                </li>
                @endforelse
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ __('Plan Report') }}
              <img src="{{ asset('frontend/assets/img/loader.gif') }}" height="40" class="plan_loader">
            </h4>
            <div class="card-header-action">
              <select class="form-control" id="planduration">
                <option value="7">{{ __('Last 7 Days') }}</option>
                <option value="15">{{ __('Last 15 Days') }}</option>
                <option value="30">{{ __('Last 30 Days') }}</option>
                <option value="365">{{ __('Last 365 Days') }}</option>
              </select>
            </div>
          </div>
          <div class="card-body">
            <canvas id="planchart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4><a href="{{ route('admin.order.index') }}">{{ __('Recent Expired Orders') }}</a></h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
            <table class="table table-hover table-nowrap card-table text-center">
              <thead>
              <tr>
                  <th>{{ __('SL.') }}</th>
                  <th>{{ __('User') }}</th>
                  <th>{{ __('Plan') }}</th>
                  <th>{{ __('Gateway') }}</th>
                  <th>{{ __('Amount') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Action') }}</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($expiredOrders as $order)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $order->user->name }}</td>
                      <td>{{ $order->plan->name }}</td>
                      <td>{{ $order->getway->name }}</td>
                      <td>{{ $order->amount }}</td>
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
      <div class="col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4><a href="{{ route('admin.order.index') }}">{{ __('Recent Pending Orders') }}</a></h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
            <table class="table table-hover table-nowrap card-table text-center">
                <thead>
                  <tr>
                      <th>{{ __('SL.') }}</th>
                      <th>{{ __('User') }}</th>
                      <th>{{ __('Plan') }}</th>
                      <th>{{ __('Gateway') }}</th>
                      <th>{{ __('Amount') }}</th>
                      <th>{{ __('Status') }}</th>
                      <th>{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pendingOrders as $pendingOrder)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $pendingOrder->user->name }}</td>
                      <td>{{ $pendingOrder->plan->name }}</td>
                      <td>{{ $pendingOrder->getway->name }}</td>
                      <td>{{ $pendingOrder->amount }}</td>
                      <td>
                          @php
                              $status = [
                              0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                              1 => ['class' => 'badge-primary', 'text' => 'Accepted'],
                              2 => ['class' => 'badge-danger', 'text' => 'Expired'],
                              3 => ['class' => 'badge-warning', 'text' => 'Pending'],
                              4 => ['class' => 'badge-danger', 'text' => 'Trash'],
                          ][$pendingOrder->status];
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
                                  href="{{ route('admin.order.show', $pendingOrder->id) }}"><i
                                      class="fa fa-eye"></i>{{ __('View') }}</a>
                              <a class="dropdown-item has-icon"
                                  href="{{ route('admin.order.edit', $pendingOrder->id) }}"><i
                                      class="fa fa-edit"></i>{{ __('Edit') }}</a>
                              <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-id={{ $pendingOrder->id }}><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                              <!-- Delete Form -->
                              <form class="d-none" id="delete_form_{{ $pendingOrder->id }}"
                                    action="{{ route('admin.order.destroy', $pendingOrder->id) }}" method="POST">
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
  </section>
<input type="hidden" value="{{ route('admin.transaction.date.wise.data') }}" id="date_wise_url">
<input type="hidden" value="{{ route('admin.plan.date.wise') }}" id="plan_datewise_url">

@endsection

@push('js')
<script src="{{ asset('backend/admin/assets/js/chart.js') }}"></script>
<script src="{{ asset('backend/admin/assets/js/admin_dashboard.js') }}"></script>
@endpush
