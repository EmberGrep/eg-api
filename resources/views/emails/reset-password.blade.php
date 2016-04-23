@extends('emails/_layout')

@section('body')
<h2>Lost your password?</h2>

<p>
    Things happen, we all forget sometimes.
</p>

<p>
    To reset your password, complete this form: <a href="https://embergrep.com/password/reset?token={{$token}}">https://embergrep.com/password/reset?token={{$token}}{{$token}}.<br/>
    This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
</p>

<p>
    If you did not request this password reset, ignore this email or contact,
    <a href="mailto:ryan@embergrep.com">ryan@embergrep.com</a>
</p>

@endsection
