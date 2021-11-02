@component('mail::message')

@if(isset($data))
@foreach ($data as $key => $item)
    @if ( $key != 'type')
    {{ $key }}: {{ $item }} <br>
    @endif
@endforeach
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
