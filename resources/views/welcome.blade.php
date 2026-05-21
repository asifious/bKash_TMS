@extends('layouts.app')

@section('hideSidebar')@endsection

@section('content')
<div class="welcome-page">
    <div class="welcome-card">
        <a href="{{ route('login') }}" class="brand-link" aria-label="bKash TMS">
            <span class="brand-mark">b</span>
            <span>
                <span class="brand-name">bKash TMS</span>
                <span class="brand-caption">Transaction Management System</span>
            </span>
        </a>

        <h1>Modern transaction management for bKash operations.</h1>
        <p>Use the secure dashboard to manage users, account numbers, transactions, invoices, activity logs, and reports.</p>

        <a href="{{ route('login') }}" class="btn btn-primary">
            <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
            <span>Go to Login</span>
        </a>
    </div>
</div>
@endsection
