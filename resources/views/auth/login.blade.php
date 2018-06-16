@extends('layouts.sign')
@section('title', 'Login')
@section('content')
<form class="form-signin" action="{{ route('login') }}" method="POST">
    {{ csrf_field() }}
    <input type="text" name="email" class="form-control" placeholder="email" required autofocus>
    <input type="password" name="password" class="form-control" placeholder="password" required>
    <button class="btn btn-primary btn-block" name="login" type="submit">Sign in</button>
</form>
<p><a href="{{ route('register') }}">Don't you have an account?</a></p>
<p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
@endsection
