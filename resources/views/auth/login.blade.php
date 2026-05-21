@extends('layouts.app')

@section('hideSidebar')@endsection

@section('content')
<div class="login-page">
    <section class="login-hero">
        <a href="{{ route('login') }}" class="brand-link hero-brand" aria-label="bKash TMS login">
            <span class="brand-mark"><img src="{{ asset('images/bkash-logo.webp') }}" alt="bKash Logo" ></span>
            <span>
                <span class="brand-name" style="font-size: 30px;">bKash TMS</span>
                <span class="brand-caption">Transaction Management System</span>
            </span>
        </a>

        <div>
            <h1>Smart transaction control for every bKash workflow.</h1>
            <p>Review activity, manage accounts, track daily totals, and keep reports ready from one clean dashboard.</p>
        </div>

        <div class="login-stats">
            <div class="login-stat">
                <strong>Live</strong>
                <span>Transaction view</span>
            </div>
            <div class="login-stat">
                <strong>Fast</strong>
                <span>Reports and invoices</span>
            </div>
            <div class="login-stat">
                <strong>Secure</strong>
                <span>Role-based access</span>
            </div>
        </div>

        <div class="login-hero-footer">
            <p>Designed for bKash agents and merchants by 
                <a href="https://brimetech.com" target="_blank" class="text-blue-500 hover:underline">BrimeTech</a>.
            </p>
        </div>



    </section>

    <section class="login-panel">
        <div class="login-card">
            <a href="{{ route('login') }}" class="brand-link" aria-label="bKash TMS">
                <span class="brand-mark"><img src="{{ asset('images/bkash-logo.webp') }}" alt="bKash Logo" ></span>
                <span>
                    <span class="brand-name">bKash TMS</span>
                    <span class="brand-caption">Welcome back</span>
                </span>
            </a>

            <h2>Sign in</h2>
            <p class="helper">Enter your username and password to continue.</p>

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

            <form method="POST" action="{{ route('login.post') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control" autocomplete="username" autofocus>
                </div>
                <div class="form-group">
                    <div class="auth-label-row">
                        <label for="password">Password</label>
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                    <input id="password" type="password" name="password" class="form-control" autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <span>Login</span>
                </button>
            </form>

            <div class="login-hero-footer" style="margin-top: 2rem; text-align: center;">
                <p>Designed and Developed by 
                    <a href="https://brimetech.com" target="_blank" class="text-blue-500 hover:underline">BrimeTech</a>.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection
