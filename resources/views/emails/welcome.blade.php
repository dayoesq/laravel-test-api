{{--Welcome email HTML template--}}
@component('mail::message')
    # Email Confirmation

    Hello {{$user->name}}
    We are so excited to have you onboard! Please verify your email with this link:

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

{{--The user welcome email--}}
{{--Hello {{$user->name}}
We are so excited to have you onboard! Please verify your email with this link:
{{route('verify', $user->verification_token)}}--}}
