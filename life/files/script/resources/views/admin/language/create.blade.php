@extends('layouts.backend.app')

@section('title','Create Language')

@push('css')
  <link rel="stylesheet" href="{{ asset('backend/admin/assets/css/select2.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h4>{{ __('Language Create') }}</h4>
            </div>
            @if ($errors->any())
              <div class="alert alert-danger">
                  <strong>{{ __('woops!') }}</strong> {{ __('There were some problems with your input.') }}<br><br>
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif
            <form method="POST" action="{{ route('admin.language.store') }}" class="basicform_with_reset">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                        <label>{{ __('Select Language') }}</label>
                        <select name="name" class="form-control select2">
                            @foreach ($langlist as $language)
                                <option value="{{ $language['code'] }}">{{ $language['name'].' -- '.$language['nativeName'].' -- ' }} ({{ $language['code'] }})</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Submit') }}</button>
                  </div>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/select2.min.js') }}"></script>
@endpush


