@extends('layouts.backend.app')

@section('title', 'Select Payment Getway')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Select Payment Getway'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (Session::has('alert'))
                                <div class="alert {{ Session::get('type') }}">
                                    {{ Session::get('alert') }}
                                </div>
                            @endif
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="card w-100">
                                <ul class="nav nav-pills mx-auto" id="myTab3" role="tablist">
                                    @foreach ($gateways as $gateway)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $gateway->first()->id == $gateway->id ? 'active' : '' }}"
                                                id="getway-tab{{ $gateway->id }}" data-toggle="tab"
                                                href="#getway{{ $gateway->id }}" role="tab" aria-controls="home"
                                                aria-selected="true">
                                                <div class="card-body">
                                                    <img class="payment-img" src="{{ asset($gateway->logo) }}"
                                                        alt="{{ $gateway->name }}" width="100">
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="card-footer">
                                    <div class="tab-content" id="myTabContent2">
                                        @foreach ($gateways as $key => $gateway)
                                            @php $data = json_decode($gateway->data) @endphp
                                            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                                id="getway{{ $gateway->id }}" role="tabpanel"
                                                aria-labelledby="getway-tab{{ $gateway->id }}">
                                                <div class="">
                                                    <table class="table">
                                                        <tr>
                                                            <td><strong>{{ __('Amount') }}</strong></td>
                                                            <td class="float-right">{{ $plan->price }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{ __('Currency') }}</strong></td>
                                                            <td class="float-right">
                                                                {{ strtoupper($gateway->currency_name) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{ __('Charge') }}</strong></td>
                                                            <td class="float-right">{{ $gateway->charge }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{ __('Rate') }}</strong></td>
                                                            <td class="float-right">{{ $gateway->rate }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>{{ __('In') }}
                                                                    ({{ $gateway->currency_name }})</strong></td>
                                                            <td class="float-right">
                                                                {{ $inr = $gateway->rate * $plan->price }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{ __('Total') }}
                                                                    ({{ $gateway->currency_name }})</strong>
                                                            </td>
                                                            <td class="float-right">
                                                               {{--  {{ ($plan->price + ($plan->price / 100) * $gateway->charge) * $gateway->rate }} --}}

                                                                {{ $plan->price*$gateway->rate + $gateway->charge }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <form action="{{ route('merchant.plan.deposit') }}" method="post"
                                                    class="paymentform" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        @if ($gateway->phone_required == 1)
                                                            <table class="table">
                                                                <tr>
                                                                    <td><label for="">Phone</label></td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="phone"
                                                                            required
                                                                            {{ Session::has('phone_error') ? 'is-invalid' : '' }}>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        @endif

                                                        @if($gateway->is_auto == 0)
                                                        @php
                                                        $data=json_decode($gateway->data);
                                                        @endphp
                                                        <table class="table">
                                                            <tr>
                                                                <td>
                                                                    <label>{{ __('Instruction') }}</label>
                                                                    <p>{{ $data->instruction ?? '' }}</p>
                                                                </td>
                                                            </tr>
                                                          
                                                        </table>
                                                        @endif
                                                        
                                                        @if ($gateway->image_accept == 1)
                                                        <table class="table">
                                                            <tr>
                                                                <td>
                                                                    <label for="screenshot">{{ __('Upload Screenshot') }}</label>
                                                                    <input type="file" name="screenshot"
                                                                        class="form-control"
                                                                        value="" required/>
                                                                </td>
                                                            </tr>
                                                          
                                                        </table>
                                                        @endif
                                                        
                                                        <input type="hidden" name="id" value="{{ $gateway->id }}">
                                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                                        <button type="submit"
                                                            class="btn btn-primary paymentbtn btn-lg w-100">{{ __('Submit Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach
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

@push('js')
    <script>
        "use strict";
        $('.paymentform').on('submit', function(e) {
            $('.paymentbtn').attr("disabled", "disabled");
            $('.paymentbtn').text("Please wait...");
        });

    </script>
@endpush
