@extends('layouts.backend.app')

@section('title','Quick Start Edit')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Quick Start Edit'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Edit Service') }}</h4>
            </div>
            <form method="POST" action="{{ url('admin/quick-start-section-store') }}" class="basicform">
                @csrf
                @php $json = json_decode($data->quickStart->value ) @endphp
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="title" value="{{old('title') ? old('title') :$data->title}}">
                        </div>
                    </div>
                    <div class="form-group field_wrapper">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('List') }}<sup>*</sup></label>
                            <div class="col-sm-12 col-md-7">
                                <a href="javascript:void(0);" class="add_button_field btn btn-outline-primary btn-block btn-lg" title="Add field">{{ __('Add') }} <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        @foreach ($json->list ?? [] as $key => $value)
                        <div class="form-group row mb-4" id="close">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7 ">
                                <div class="input-group">
                                    <input type='text' name='list[]' class='form-control' value="{{ $value }}" data-key="{{ $key }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <a href="javascript:void(0);" class="remove_button mt-0 btn btn-danger btn-block" title="Remove"><i class='fa fa-trash'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" id="des" name="des" rows="4" cols="50">{{ $json->des ?? null }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Button Name') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="button_name" value="{{old('button_name') ? old('button_name') :$json->button_name}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Button Link') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="button_link" value="{{old('button_link') ? old('button_link') :$json->button_link}}">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-7 text-center" >
                            <img src="{{ asset($json->image ?? 'no-img.png') }}" alt="" height="50", width="100">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Image') }} </label>
                        <div class="col-sm-12 col-md-7" >
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control">
                                <option value="1" {{$data->status == 1 ? 'selected':""}}>{{ __('Active') }}</option>
                                <option value="0" {{$data->status == 0 ? 'selected':""}}>{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary basicbtn btn-lg w-100" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    'use strict';

    $(document).ready(function(){
        var x = 0; //Initial field counter is 1
        var count = 100;
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button_field'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
    
        //Once add button is clicked
        $(addButton).on('click',function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                 //Increment field counter
                var fieldHTML = `
                <div class="form-group row mb-4" id="close">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7 ">
                                <div class="input-group">
                                    <input type='text' name='list[]' class='form-control'>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <a href="javascript:void(0);" class="remove_button mt-0 btn btn-danger btn-block" title="Remove"><i class='fa fa-trash'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>` //New input field html 
                x++;
                count++;
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).closest("#close").remove();
            x--; //Decrement field counter
        });
    });
</script>
 @endpush
