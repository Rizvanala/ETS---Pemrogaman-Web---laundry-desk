@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-box">
    <h1>Login</h1>
    <p class="muted">Staff and customers use the same form.</p>

    <form method="POST" action="{{ route('login') }}" class="form">
        @csrf
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email') <p class="field-error">{{ $message }}</p> @enderror

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @error('password') <p class="field-error">{{ $message }}</p> @enderror

        <label class="check"><input type="checkbox" name="remember" value="1"> Keep me logged in</label>

        <button type="submit" class="btn">Login</button>
    </form>

    <p class="muted">No account yet? <a href="{{ route('register') }}" class="text-link">Register as a customer</a></p>
</div>
@endsection
