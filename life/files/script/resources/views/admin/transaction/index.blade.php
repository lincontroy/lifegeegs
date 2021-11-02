@extends('layouts.backend.app')

@section('title','All Transaction')

@section('head')
@include('layouts.backend.partials.headersection', ['title'=>'All Transaction'])
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
                        <form action="">
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
                        <form action="">
                            <div class="input-group form-row mt-3">
                                <input type="text" class="form-control" placeholder="Search..." required="" name="value" autocomplete="off" value="">
                                <select class="form-control" name="type">
                                <option value="trxid">{{ __('Transaction ID') }}</option>
                                </select>
                                <div class="input-group-append">                                            
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                            <tr>
                                <th>{{ __('SL.') }}</th>
                                <th>{{ __('Merchant Name') }}</th>
                                <th>{{ __('Phone No.') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ __('1') }}</td>
                                <td>{{ __('John Doe') }}</td>
                                <td>{{ __('415445561') }}</td>
                                <td>{{ __('johndoe@gmail.com') }}</td>
                                <td>
                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon" href="{{ route('admin.merchant.edit', 1) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                    </div>
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

