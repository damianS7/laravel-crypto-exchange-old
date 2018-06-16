@extends('layouts.sign')
@section('title', 'Register')
@section('content')
<form class="form-signin" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <input type="text" name="email" class="form-control" placeholder="Your email" required autofocus>
    <input type="password" name="password" class="form-control" placeholder="Your password" required>
    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat your password" required>
    <button class="btn btn-primary btn-block" name="login" type="submit">Sign up</button>
</form>
<p><a href="{{ route('login') }}">I already have an account</a></p>

@endsection
