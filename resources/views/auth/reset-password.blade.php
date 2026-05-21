@extends('layouts.app')

@section('hideSidebar')@endsection

@section('content')
<div class="login-page">
    <section class="login-hero">
        <a href="{{ route('login') }}" class="brand-link hero-brand" aria-label="bKash TMS login">
            <span class="brand-mark">b</span>
            <span>
                <span class="brand-name">bKash TMS</span>
                <span class="brand-caption">Set new password</span>
            </span>
        </a>

        <div>
            <h1>Create a fresh password and get back in.</h1>
            <p>Use a strong password that you do not reuse on another service.</p>
        </div>

        <div class="login-stats">
            <div class="login-stat">
                <strong>New</strong>
                <span>Password required</span>
            </div>
            <div class="login-stat">
                <strong>Safe</strong>
                <span>Token verified</span>
            </div>
            <div class="login-stat">
                <strong>Fast</strong>
                <span>Return to dashboard</span>
            </div>
        </div>
    </section>

    <section class="login-panel">
        <div class="login-card">
            <a href="{{ route('login') }}" class="brand-link" aria-label="bKash TMS">
                <span class="brand-mark">b</span>
                <span>
                    <span class="brand-name">bKash TMS</span>
                    <span class="brand-caption">Reset password</span>
                </span>
            </a>

            <h2>Reset password</h2>
            <p class="helper">Enter your email and new password.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="login-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" class="form-control" autocomplete="email" autofocus>
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input id="password" type="password" name="password" class="form-control" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    <span>Reset Password</span>
                </button>
            </form>

            <div class="auth-card-footer">
                <a href="{{ route('login') }}">Back to login</a>
            </div>
        </div>
    </section>
</div>
@endsection
