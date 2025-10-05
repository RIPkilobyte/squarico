@component('mail::message')

You are receiving this email because we received a password reset request for your account.

<a href="{{ $url }} ">Reset Password</a>

This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.

If you did not request a password reset, no further action is required.
@endcomponent
