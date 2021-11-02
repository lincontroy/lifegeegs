@extends('layouts.backend.app')

@section('title','Language Lists')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Language List'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.language.set') }}" method="POST" id="basicform">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option disabled selected>{{ __('Select Option') }}</option>
                            <option value="active">{{ __('Active Language') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 pl-0">
                  <button type="submit" class="btn btn-primary btn-lg">{{ __('Submit') }}</button>
                </div>
                <div class="col-lg-6">
                    <div class="add-new-btn f-right">
                        <a href="{{ route('admin.language.create') }}" class="btn btn-primary float-right">{{ __('Add New Language') }}</a>
                    </div>
                </div>
            </div>
            @if (Session::has('message'))
              <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped" id="table-2">
                  <thead>
                    <tr>
                      <th>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input checkAll" id="checkAll">
                          <label class="custom-control-label" for="checkAll"></label>
                        </div>
                      </th>
                      <th>{{ __('Language Code') }}</th>
                                         
                      <th>{{ __('Language Name') }}</th>
                       <th>{{ __('Status') }}</th>
                      <th>{{ __('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($languages as $key=>$language)
                    <tr>
                      <td>
                        <div class="custom-checkbox custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" name="id[]" id="checkbox-{{ $key }}" value="{{ $language->id }}" {{ $language->status == 1 ? 'checked' : '' }}>
                          <label for="checkbox-{{ $key }}" class="custom-control-label">&nbsp;</label>
                        </div>
                      </td>
                      <td>{{ $language->name }}</td>
                    
                      <td>{{ $language->data }}</td>
                      <td><span class="badge badge-{{ $language->status == 1 ? 'success' : 'danger' }}">{{ $language->status == 1 ? 'Active' : 'Disabled' }}</span></td>
                      </form>
                      <td>
                        <div class="dropdown d-inline">
                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Action') }}
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item has-icon" href="{{ route('admin.language.edit',$language->id) }}"><i class="fa fa-eye"></i>{{ __('Edit') }}</a>
                            
                            <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-id={{ $language->id }}><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                            <!-- Delete Form -->
                            <form class="d-none" id="delete_form_{{ $language->id }}" action="{{ route('admin.language.destroy', $language->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $languages->links('vendor.pagination.bootstrap-4') }}
              </div>
          </div>
      </div>
  </div>
</div>
@endsection



