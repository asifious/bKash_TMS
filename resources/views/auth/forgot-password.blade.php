@extends('layouts.app')

@section('hideSidebar')@endsection

@section('content')
<div class="login-page">
    <section class="login-hero">
        <a href="{{ route('login') }}" class="brand-link hero-brand" aria-label="bKash TMS login">
            <span class="brand-mark">b</span>
            <span>
                <span class="brand-name">bKash TMS</span>
                <span class="brand-caption">Password recovery</span>
            </span>
        </a>

        <div>
            <h1>Reset access without calling support.</h1>
            <p>Enter your account email and we will send a secure password reset link.</p>
        </div>

        <div class="login-stats">
            <div class="login-stat">
                <strong>Secure</strong>
                <span>One-time reset link</span>
            </div>
            <div class="login-stat">
                <strong>60m</strong>
                <span>Token expiry</span>
            </div>
            <div class="login-stat">
                <strong>Email</strong>
                <span>Delivered reset flow</span>
            </div>
        </div>
    </section>

    <section class="login-panel">
        <div class="login-card">
            <a href="{{ route('login') }}" class="brand-link" aria-label="bKash TMS">
                <span class="brand-mark">b</span>
                <span>
                    <span class="brand-name">bKash TMS</span>
                    <span class="brand-caption">Recover account</span>
                </span>
            </a>

            <h2>Forgot password?</h2>
            <p class="helper">Use the email linked to your account.</p>

            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

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

            <form method="POST" action="{{ route('password.email') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" autocomplete="email" autofocus>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane" aria-hidden="true"></i>
                    <span>Send Reset Link</span>
                </button>
            </form>

            <div class="auth-card-footer">
                <a href="{{ route('login') }}">Back to login</a>
            </div>
        </div>
    </section>
</div>
@endsection
