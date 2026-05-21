@extends('layouts.app')

@section('pageTitle', 'Transaction Details')

@section('content')
@php
    $typeMeta = [
        'cash_in' => ['label' => 'Cash In', 'class' => 'cash-in', 'icon' => 'fa-money-bill-wave'],
        'send_money' => ['label' => 'Send Money', 'class' => 'send-money', 'icon' => 'fa-paper-plane'],
        'received_money' => ['label' => 'Received Money', 'class' => 'received-money', 'icon' => 'fa-hand-holding-usd'],
    ];
    $meta = $typeMeta[$t->transaction_type] ?? ['label' => ucwords(str_replace('_', ' ', $t->transaction_type)), 'class' => 'total', 'icon' => 'fa-receipt'];
@endphp

<div class="transaction-show screen-only">
    <section class="transaction-receipt-card">
        <div class="transaction-receipt-head">
            <div>
                <span class="transaction-type-badge {{ $meta['class'] }}">
                    <i class="fas {{ $meta['icon'] }}" aria-hidden="true"></i>
                    {{ $meta['label'] }}
                </span>
                <h2>Transaction #{{ $t->id }}</h2>
                <p>{{ $t->transaction_date }}</p>
            </div>
            <div class="transaction-show-actions">
                <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <span>Back</span>
                </a>
                <a href="{{ route('user.transactions.edit', $t->id) }}" class="btn btn-secondary">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                    <span>Edit</span>
                </a>
                <button onclick="window.print();" class="btn btn-primary">
                    <i class="fas fa-print" aria-hidden="true"></i>
                    <span>Print</span>
                </button>
            </div>
        </div>

        <div class="transaction-amount-panel {{ $meta['class'] }}">
            <span>Amount</span>
            <strong>{{ number_format($t->amount, 2) }}</strong>
            <p>{{ $t->transaction_id ? 'Reference: '.$t->transaction_id : 'No reference number added' }}</p>
        </div>

        <div class="transaction-route-panel">
            <div>
                <span>From Account</span>
                <strong>{{ $t->from_account_number ?: 'No source account' }}</strong>
            </div>
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
            <div>
                <span>To Account</span>
                <strong>{{ $t->to_account_number ?: 'No destination account' }}</strong>
            </div>
        </div>

        <div class="transaction-detail-grid">
            <div class="detail-item">
                <span>Date</span>
                <strong>{{ $t->transaction_date }}</strong>
            </div>
            <div class="detail-item">
                <span>Type</span>
                <strong>{{ $meta['label'] }}</strong>
            </div>
            <div class="detail-item">
                <span>Transaction ID</span>
                <strong>{{ $t->transaction_id ?: '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Created</span>
                <strong>{{ optional($t->created_at)->format('Y-m-d H:i') ?: '-' }}</strong>
            </div>
        </div>

        <div class="detail-note">
            <span>Note</span>
            <p>{{ $t->note ?: 'No note added.' }}</p>
        </div>
    </section>
</div>

<section class="print-transaction print-only">
    <header class="print-header">
        <div>
            <h1>Transaction Receipt</h1>
            <p>Transaction #{{ $t->id }}</p>
            <p>{{ $meta['label'] }}</p>
        </div>
        <div class="print-title">
            <span>Amount</span>
            <strong>{{ number_format($t->amount, 2) }}</strong>
        </div>
    </header>

    <div class="print-meta-grid">
        <div>
            <span>From Account</span>
            <strong>{{ $t->from_account_number ?: '-' }}</strong>
        </div>
        <div>
            <span>To Account</span>
            <strong>{{ $t->to_account_number ?: '-' }}</strong>
        </div>
        <div>
            <span>Date</span>
            <strong>{{ $t->transaction_date }}</strong>
            <span>Transaction ID</span>
            <strong>{{ $t->transaction_id ?: '-' }}</strong>
        </div>
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $meta['label'] }}</td>
                <td>{{ $t->transaction_id ?: '-' }}</td>
                <td>{{ $t->transaction_date }}</td>
                <td>{{ number_format($t->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="print-notes">
        <h2>Note</h2>
        <p>{{ $t->note ?: 'No note added.' }}</p>
    </div>

    <footer class="print-footer">
        <span>Generated from bKash TMS</span>
        <span>{{ now()->format('Y-m-d H:i') }}</span>
    </footer>
</section>
@endsection
