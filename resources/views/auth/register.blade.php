@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-box">
    <h1>Register</h1>
    <p class="muted">Create a customer account to follow your bills and balances.</p>

    <form method="POST" action="{{ route('register') }}" class="form">
        @csrf
        <label for="name">Full name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" maxlength="50" required autofocus>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <p class="field-error">{{ $message }}</p> @enderror

        <label for="phone">Phone number</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="0812 3456 7890" required>
        @error('phone') <p class="field-error">{{ $message }}</p> @enderror

        <label for="password">Password (at least 8 characters)</label>
        <input id="password" type="password" name="password" required>
        @error('password') <p class="field-error">{{ $message }}</p> @enderror

        <label for="password_confirmation">Repeat password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit" class="btn">Create account</button>
    </form>

    <p class="muted">Already registered? <a href="{{ route('login') }}" class="text-link">Login</a></p>
</div>
@endsection
