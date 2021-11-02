@extends('layouts.backend.app')

@section('title', 'Request Lists')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Requests List','button_name'=> 'Add New','button_link'=>
    route('merchant.request.create')])
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
                    <div class="table-responsive">
                        <table class="table" id="table-2">
                            <thead>
                                <tr>
                                    <th>{{ __('SL.') }}</th>
                                    <th>{{ __('Request Purpose') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Total Amount') }}</th>
                                    <th>{{ __('IP') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Copy URL') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests ?? [] as $key => $request)
                                    @php $info =  $request->requestmeta ? json_decode($request->requestmeta->value) : '' @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $info->purpose ?? '' }}</td>
                                        <td>{{ $request->amount }}</td>
                                        <td>{{ $request->calculated_amount }}</td>
                                        <td>{{ $request->ip }}</td>
                                        <td>
                                            @if ($request->status == 1)
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <input class="copy_to_chilpboard" type="text"
                                            id="copy_to_chilpboard_{{ $request->id }}"
                                            value="{{ url('checkout') . '/' . encrypt($request->id) }}">
                                        <td><a href="#" onclick="copy('copy_to_chilpboard_{{ $request->id }}')"
                                                class="btn btn-info">{{ __('Copy URL') }}</a></td>
                                        <td>
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item has-icon"
                                                    href="{{ route('merchant.request.edit', $request->id) }}"><i
                                                        class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                                <a class="dropdown-item has-icon"
                                                    href="{{ route('merchant.request.show', $request->id) }}"><i
                                                        class="fa fa-eye"></i>{{ __('View') }}</a>
                                                <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                                                    data-id={{ $request->id }}><i
                                                        class="fa fa-trash"></i>{{ __('Delete') }}
                                                </a>
                                                <!-- Delete Form -->
                                                <form class="d-none" id="delete_form_{{ $request->id }}"
                                                    action="{{ route('merchant.request.destroy', $request->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $requests->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        function copy(id) {
            var copyText = document.getElementById(id);
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Successfully Copied!'
            })
        }

    </script>
@endpush
