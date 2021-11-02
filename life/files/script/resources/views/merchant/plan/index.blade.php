@extends('layouts.backend.app')

@section('title', 'Select your plan')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Select your plan'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            @if (Session::has('message'))
                <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }}</div>
            @endif
        </div>
        @foreach ($plans ?? [] as $plan)
            <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing {{ $plan->is_featured ? 'pricing-highlight' : '' }}">
                    <div class="pricing-title">
                        {{ $plan->name }}
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>
                                {{ App\Models\Option::where('key', 'currency_symbol')->first()->value }}{{ $plan->price }}
                            </div>
                            <div>
                                @if ($plan->duration == 7)
                                    {{ __('Per Week') }}
                                @elseif($plan->duration == 30)
                                    {{ __('Per Month') }}
                                @elseif($plan->duration == 365)
                                    {{ __('Per Year') }}
                                @else
                                    {{ $plan->duration }} {{ __('Days') }}
                                @endif
                            </div>
                        </div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">{{ $plan->storage_limit }}
                                    {{ __('MB Storage limit') }}
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">{{ $plan->monthly_req }} {{ __('Monthly Request') }}
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">{{ $plan->daily_req }} {{ __('Daily Request') }}
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon {{ !$plan->captcha ? 'bg-danger text-white' : '' }}">
                                    <i class="fas fa-{{ $plan->captcha ? 'check' : 'times' }}"></i>
                                </div>
                                <div class="pricing-item-label">
                                    {{ __('Google Captcha') }}</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon {{ !$plan->menual_req ? 'bg-danger text-white' : '' }}">
                                    <i class="fas fa-{{ $plan->menual_req ? 'check' : 'times' }}"></i>
                                </div>
                                <div class="pricing-item-label">
                                    {{ __('Menual Request') }}</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon {{ !$plan->fraud_check ? 'bg-danger text-white' : '' }}">
                                    <i class="fas fa-{{ $plan->fraud_check ? 'check' : 'times' }}"></i>
                                </div>
                                <div class="pricing-item-label">
                                    {{ __('Fraud Check') }}</div>
                            </div>

                           
                           
                           
                            <div class="pricing-item">
                                <div class="pricing-item-icon {{ !$plan->mail_activity ? 'bg-danger text-white' : '' }}">
                                    <i class="fas fa-{{ $plan->mail_activity ? 'check' : 'times' }}"></i>
                                </div>
                                <div class="pricing-item-label">
                                    {{ __('Mail Activity') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="{{ route('merchant.plan.gateways', $plan->id) }}">{{ $plan->is_trial == 0 ? __('Activate') : __('Free Trial') }}<i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Your Transactions') }}</h4>
        </div>
        <div class="card-body">
            <table class="table mt-2">
                <thead>
                    <tr>
                      
                        <th>{{ __('Payment Id') }}</th>
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Getway') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Payment Status') }}</th>
                        <th>{{ __('Order At') }}</th>
                        <th>{{ __('Expire') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders ?? [] as $order)

                        <tr>
                            
                            <td>{{ $order->payment_id }}</td>
                            <td>{{ $order->plan->name }}</td>
                            <td>{{ $order->getway->name }}</td>
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
                                    4 => ['class' => 'badge-danger', 'text' => 'Trashed'],
                                ][$order->status];
                                @endphp
                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                            </td>
                            <td>{{ $order->created_at->isoFormat('LL') }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->exp_date)->isoFormat('LL') }}</td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item has-icon" href="{{ route('merchant.plan.show', $order->id) }}"><i class="fa fa-eye"></i>{{ __('View') }}</a>
                                    <a class="dropdown-item has-icon" href="{{ url('merchant/plan-invoice', $order->id) }}"><i class="far fa-file-pdf"></i>{{ __('PDF') }}</a>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
