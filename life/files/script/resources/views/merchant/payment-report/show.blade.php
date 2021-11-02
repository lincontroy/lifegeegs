@extends('layouts.backend.app')

@section('title', 'Payment Report')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Payment Report'])
@endsection
@section('content')
    <style>
        .container {
            width: 21cm;
            min-height: 29.7cm;
        }

        .invoice {
            background: #fff;
            width: 100%;
            padding: 50px;
        }

        .logo {
            width: 2.5cm;
        }

        .document-type {
            text-align: right;
            color: #444;
        }

        .conditions {
            font-size: 0.7em;
            color: #666;
        }

        .bottom-page {
            font-size: 0.7em;
        }   
    </style>
    <div class="container">
        @php $request_info = $data->request->requestmeta ? json_decode($data->request->requestmeta->value) : ''; 
        $info = $data->meta ? json_decode($data->meta->value) : ''
        @endphp
        <div class="invoice" id="printableArea">
            <div class="row">
                <div class="col-7">
                    <h4 class="display-5">{{ __('Payment Invoice') }}</h4>
                </div>
                <div class="col-5">
                    <h4 class="document-type display-5 text-right">{{ config('app.name') }}</h4>
                    <p class="text-right"><strong>Today's Date : {{ \Carbon\Carbon::now()->format('M d Y') }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <strong>{{ __('Billed To:') }}</strong><br>
                        {{ $data->user->name }}<br>
                        {{ $data->user->email }}<br>
                        {{ $data->user->phone ?? null }}<br>
                    </address>
                </div>
                <div class="col-md-6 text-md-right">
                    <address>
                        <strong>{{ __('Payment Date:') }}</strong><br>
                        {{ $data->created_at->format('M d Y') }}<br>
                    </address>
                </div>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width=40%>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                    </tr>
                    @if (!empty($request_info->purpose))
                        <tr>
                            <td>{{ __('Purpose') }}</td>
                            <td>{{ $request_info->purpose }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>{{ __('Gateway Method Name') }}</td>
                        <td>{{ $data->getway->name ?? 'null' }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Currency') }}</td>
                        <td>{{ $data->currency ?? 'null' }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Amount (USD)') }}</td>
                        <td>{{ $data->main_amount ?? 'null' }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Total') . "($data->currency)" }}</td>
                      
                        <td>{{ $data->amount ?? 'null' }}</td>
                    </tr>
                    
                    <tr>
                        <td>{{ __('Trx Id') }}</td>
                        <td>{{ $data->trx_id ?? 'null' }}</td>
                    </tr>
                   
                    <tr>
                        <td>{{ __('IP') }}</td>
                        <td>{{ $data->request->ip ?? 'null' }}</td>
                    </tr>
                    @if (!empty($request_info->phone))
                        <tr>
                            <td>{{ __('Phone') }}</td>
                            <td>{{ $request_info->phone }}</td>
                        </tr>
                    @endif

                    @if (!empty($request_info->name))
                        <tr>
                            <td>{{ __('Name') }}</td>
                            <td>{{ $request_info->name }}</td>
                        </tr>
                    @endif

                    @if (!empty($request_info->email))
                        <tr>
                            <td>{{ __('Email') }}</td>
                            <td>{{ $request_info->email }}</td>
                        </tr>
                    @endif

                    @if (!empty($request_info->fallback))
                        <tr>
                            <td>{{ __('FallBack URL') }}</td>
                            <td>{{ $request_info->fallback }}</td>
                        </tr>
                    @endif

                    


                    <tr>
                        <td>{{ __('Status') }}</td>
                        <td>
                            @if ($data->status = 1)
                                <span>Success</span>
                            @elseif($data->status == 2)
                                <span>Pending</span>
                            @elseif($data->status == 0)
                                <span>Inactive</span>
                            @endif
                        </td>
                    </tr>

                    @if (!empty($info->screenshot))
                    <tr class="dontprint">
                        <td>{{ __('Attachment') }}</td>
                        <td><a href="{{ asset($info->screenshot) }}" target='_blank'><img src="{{ asset($info->screenshot) }}"  class="w-50" alt=""></a></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <button class="btn btn-warning btn-icon icon-left" onclick="printDiv('printableArea')"><i class="fas fa-print"></i>
            Print
        </button>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.onbeforeprint = function(event) { 
                $('.dontprint').hide()
            };
            window.print();

            document.body.innerHTML = originalContents;
        }

    </script>
@endpush
