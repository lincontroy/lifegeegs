@extends('layouts.backend.app')

@section('title', 'Edit Request')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit Create','button_name'=> 'All Requests','button_link'=>
    route('merchant.request.index')])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit Request') }}</h4>
                </div>
                <form method="POST" action="{{ route('merchant.request.update', $request->id) }}" class="basicform">
                    @csrf
                    @method('PUT')
                    @php $info = json_decode($request->requestmeta->value) @endphp
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Purpose') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="purpose" value="{{ $info->purpose ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Amount') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" step="0.01" class="form-control" name="amount"
                                    value="{{ $request->amount }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Test') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="is_test">
                                    <option value="1" {{ $request->is_test == 1 ? 'selected' : '' }}>{{ __('Yes') }}
                                    </option>
                                    <option value="0" {{ $request->is_test == 0 ? 'selected' : '' }}>{{ __('No') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Captcha Status') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="captcha_status">
                                    <option value="1" {{ $request->captcha_status == 1 ? 'selected' : '' }}>
                                        {{ __('Active') }}</option>
                                    <option value="0" {{ $request->captcha_status == 0 ? 'selected' : '' }}>
                                        {{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                            <div class="col-sm-12 col-md-7" name="status">
                                <select name="status" class="form-control">
                                    <option value="1" {{ $request->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                    </option>
                                    <option value="0" {{ $request->status == 0 ? 'selected' : '' }}>
                                        {{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('URL') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control mb-2" id="url" readonly="">
                                <button id="generateUrl" class="btn btn-primary btn-lg" data-param={{ $param }}
                                    data-url="{{ url('/checkout') }}">{{ __('Generate URL') }}</button>
                                <button id="copyUrl" class="btn btn-primary d-none btn-lg">{{ __('Copy URL') }}</button>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary basicbtn w-100 btn-lg"
                                    type="submit">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/request.js') }}"></script>
@endpush
