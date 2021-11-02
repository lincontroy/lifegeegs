@extends('layouts.backend.app')

@section('title','Theme Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h4>{{__('Theme Settings')}}</h4>
            </div>
            @if (Session::has('message'))
                <div class="alert alert-danger">
                </div>
            @endif
            <form method="POST" action="{{ route('admin.theme.settings.update', $theme->id) }}" enctype="multipart/form-data" class="basicform">
              @csrf
              @method('PUT')
              @php 
                $theme = json_decode($theme->value) ?? '';
              @endphp
              <div class="card-body">
                <div class="form-row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>{{ __('Logo') }}</label>
                        <input type="file" class="form-control" name="logo" id="">
                        {{ __('Prev photo') }}: <img class="mt-2" src="{{ asset('uploads/logo.png') }}" alt="" width="100">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>{{ __('Favicon') }}</label>
                        <input type="file" class="form-control" name="favicon" id="">
                        {{ __('Prev photo') }}: <img class="mt-2" src="{{ asset('uploads/favicon.ico') }}" alt="" width="100">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>{{ __('Documentation Logo') }}</label>
                            <input type="file" class="form-control" name="docs_logo" id="">
                            {{ __('Prev photo') }}: <img class="mt-2" src="{{ asset('uploads/docs-logo.png') }}" alt="" width="100">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ __('Footer Description') }}</label>
                            <textarea name="footer_description" class="form-control">{{ $theme->footer_description ?? '' }}</textarea>
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="newsletter_address" class="form-control">{{ $theme->newsletter_address ?? '' }}</textarea>
                        </div>
                      </div>
                     
                      <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ __('Create Account Button Name') }}</label>
                            <input type="text" name="new_account_button" value="{{old('new_account_button') ? old('new_account_button') :$theme->new_account_button}}" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ __('Create Account Button Url') }}</label>
                            <input type="text" name="new_account_url" value="{{old('new_account_url') ? old('new_account_url') :$theme->new_account_url}}" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ __('Currency Symbol') }}</label>
                            <input type="text" value="{{ isset($currency_symbol) ? $currency_symbol->value : '' }}" name="currency_symbol" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="form-group field_wrapper">
                        <div class="row">
                            <div class="col-md-5"> 
                                <label for="">{{ __('Iconify Icon') }}</label> <br>
                            </div>
                            <div class="col-md-5">
                                <label for="">{{ __('Link') }}</label><br>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:void(0);" class="add_button btn btn-outline-primary btn-block btn-lg" title="Add field">Add <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        @foreach ($theme->social ?? [] as $key => $item)
                        <div class="row">
                            <div class="col-md-5"><br>
                                <input type="text" value="{{ $item->icon }}" data-key="{{ $key }}" class="form-control" name="social[{{ $key }}][icon]" value='fab fa-facebook'> 
                            </div>
                            <div class="col-md-5"><br>
                                <input type="text" value="{{ $item->link }}" class="form-control" name="social[{{ $key }}][link]" class=""> 
                            </div>
                            <div class="col-md-2">
                                <br>
                                <a href="javascript:void(0);" class="remove_button btn btn-danger btn-block btn-lg" title="Remove">Remove</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary btn-lg float-right w-100 basicbtn">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection






