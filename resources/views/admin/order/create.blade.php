@extends('layouts.backend.app')

@section('title','Create Order')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Order Create','button_name'=> 'All Order','button_link'=>
    route('admin.order.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create Order') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.order.store') }}" class="basicform_with_reset">
                @csrf
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" placeholder="User Email" required name="email">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Plan') }}</label>
                        <div class="col-sm-12 col-md-7" >
                            <select name="plan_id" class="form-control selectric">
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Gateway') }}</label>
                        <div class="col-sm-12 col-md-7" >
                            <select name="getway_id" class="form-control selectric">
                                @foreach ($getways as $getway)
                                    <option value="{{ $getway->id }}">{{ $getway->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Payment ID') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" placeholder="Payment ID" required name="payment_id">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Send Email to customer?') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="email_status" class="form-control">
                                <option value="1">{{ __('Yes') }}
                                </option>
                                <option value="0" selected>{{ __('No') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7" name="status">
                            <select name="status" class="form-control">
                                <option value="2">
                                    {{ __('Pending') }}
                                </option>
                                <option value="1">
                                    {{ __('Approved') }}
                                </option>
                                <option value="0">
                                    {{ __('Cancel') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
