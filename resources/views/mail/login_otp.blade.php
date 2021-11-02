@component('mail::message')
# Message From Lenden For Confirmation

OTP CODE: {{ $body['otp_number'] }}

Thanks,
{{ config('app.name') }}
@endcomponent
