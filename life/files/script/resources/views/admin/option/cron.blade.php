@extends('layouts.backend.app')

@section('title','Cron Jobs')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Cron Jobs') }}</h4>

    </div>
    <div class="card-body">

     <form method="POST" action="{{ route('admin.option.update', $option->key) }}" class="basicform">
      @csrf
      @php 
      $option = json_decode($option->value);
      @endphp

    <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Make Alert To Customer The Subscription Will Ending Soon') }}</label>
          <div class="col-sm-12 col-md-7">
            <input class="form-control @error('days') is-invalid @enderror" name="days" type="text" value="{{ $option->days }}">
            <small>{{ __('Note: It Will Send Notification Everyday Within The Selected Days') }}</small>
        </div>
    </div>
    <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Assign Default Plan After Expired The Order') }}</label>
          <div class="col-sm-12 col-md-7">
            <select name="assign_default_plan" class="form-control">
                <option value="on" {{ $option->assign_default_plan == 'on' ? 'selected' : '' }}>{{ __('ON') }}</option>
                <option value="off" {{ $option->assign_default_plan == 'off' ? 'selected' : '' }}>{{ __('OFF') }}</option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Alert message before expire the order') }}</label>
          <div class="col-sm-12 col-md-7">
             <textarea class="form-control @error('alert_message') is-invalid @enderror" name="alert_message" cols="30" rows="10">{{ $option->alert_message }}</textarea>
        </div>
    </div> 
    <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Expire message after expired the order') }}</label>
          <div class="col-sm-12 col-md-7">
             <textarea class="form-control @error('expire_message') is-invalid @enderror" name="expire_message" cols="30" rows="10">{{ $option->expire_message }}</textarea>
        </div>
    </div>

    <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <input type="hidden" name="status" value="{{ $option->status }}">
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
          </div>
        </div>

</form>
</div>
</div>
</div>
</div>



<div class="row">
    <div class="col-12">            
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Make Payment Fraud Check For '.env('APP_NAME')) }} <code>{{ __('Once/day') }}</code></h4>
                
                
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/admin/fraudcheck') }}</p></div>
            </div>
        </div>
    </div> 

    <div class="col-12">            
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Make Payment Fraud Check For Merchant') }} <code>{{ __('Once/day') }}</code></h4>
                
                
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/merchant/fraudcheck') }}</p></div>
            </div>
        </div>
    </div>
    
    
    <div class="col-12">            
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Make Alert To The Customer Before Expired The Membership') }} <code>{{ __('Once/day') }}</code></h4>
                
                
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/alert-user/before/order/expired') }}</p></div>
            </div>
        </div>
    </div> 

    <div class="col-12">            
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Make Expired Membership') }} <code>{{ __('Once/day') }}</code></h4>
                
                
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/alert-user/after/order/expired') }}</p></div>
            </div>
        </div>
    </div> 
    
    

</div>
</div>
</div>

@endsection

