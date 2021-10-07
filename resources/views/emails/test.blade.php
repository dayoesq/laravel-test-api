{{--Confirm email change HTML template--}}
@component('mail::message')
# Email Confirmation

You recently changed your email, please confirm your new email with this link:
route('verify', $user->verification_token)

@component('mail::button', ['url' => ''])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


{{--Confirm mail change--}}
{{--
Hello {{$user->name}}
You recently changed your email, please verify your new email with this link:
{{route('verify', $user->verification_token)}}--}}
