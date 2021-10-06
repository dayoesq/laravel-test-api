{{--Confirm mail change--}}
Hello {{$user->name}}
You recently changed your email, please verify your new email with this link:
{{route('verify', $user->verification_token)}}
