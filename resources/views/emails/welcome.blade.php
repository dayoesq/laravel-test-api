{{--The user welcome email--}}
Hello {{$user->name}}
We are so excited to have you onboard! Please verify your email with this link:
{{route('verify', $user->verification_token)}}
