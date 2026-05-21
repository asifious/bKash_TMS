@extends('layouts.app')

@section('pageTitle', 'Transaction Details')

@section('content')
@php
    $typeLabel = ucwords(str_replace('_', ' ', $transaction->transaction_type));
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transaction #{{ $transaction->id }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.reports.transactions') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
            <button onclick="window.print();" class="btn btn-sm btn-primary">
                <i class="fas fa-print" aria-hidden="true"></i>
                <span>Print</span>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <span>User</span>
                <strong>{{ $transaction->user->name ?? 'Deleted user' }}</strong>
            </div>
            <div class="detail-item">
                <span>User Email</span>
                <strong>{{ $transaction->user->email ?? 'Not available' }}</strong>
            </div>
            <div class="detail-item">
                <span>Type</span>
                <strong>{{ $typeLabel }}</strong>
            </div>
            <div class="detail-item">
                <span>Date</span>
                <strong>{{ $transaction->transaction_date }}</strong>
            </div>
            <div class="detail-item">
                <span>From Account</span>
                <strong>{{ $transaction->from_account_number ?: '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>To Account</span>
                <strong>{{ $transaction->to_account_number ?: '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Amount</span>
                <strong>{{ number_format($transaction->amount, 2) }}</strong>
            </div>
            <div class="detail-item">
                <span>Transaction ID</span>
                <strong>{{ $transaction->transaction_id ?: '-' }}</strong>
            </div>
        </div>

        <div class="detail-note">
            <span>Note</span>
            <p>{{ $transaction->note ?: 'No note added.' }}</p>
        </div>
    </div>
</div>
@endsection
