@extends('layouts.app')

@section('pageTitle', 'Transactions')

@section('content')
@php
    $typeMeta = [
        'cash_in' => ['label' => 'Cash In', 'class' => 'cash-in', 'icon' => 'fa-money-bill-wave'],
        'send_money' => ['label' => 'Send Money', 'class' => 'send-money', 'icon' => 'fa-paper-plane'],
        'received_money' => ['label' => 'Received Money', 'class' => 'received-money', 'icon' => 'fa-hand-holding-usd'],
    ];
@endphp

<div class="transaction-workspace">
    <div class="transaction-toolbar">
        <div>
            <h2>Transactions</h2>
            <p>Track every cash in, send money, and received money entry.</p>
        </div>
        <a href="{{ route('user.transactions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus" aria-hidden="true"></i>
            <span>New Transaction</span>
        </a>
    </div>

    <div class="transaction-stats-grid">
        <article class="transaction-stat-card cash-in">
            <span><i class="fas fa-money-bill-wave" aria-hidden="true"></i></span>
            <p>Cash In</p>
            <strong>{{ number_format($stats['cash_in'], 2) }}</strong>
        </article>
        <article class="transaction-stat-card send-money">
            <span><i class="fas fa-paper-plane" aria-hidden="true"></i></span>
            <p>Send Money</p>
            <strong>{{ number_format($stats['send_money'], 2) }}</strong>
        </article>
        <article class="transaction-stat-card received-money">
            <span><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></span>
            <p>Received</p>
            <strong>{{ number_format($stats['received_money'], 2) }}</strong>
        </article>
        <article class="transaction-stat-card total">
            <span><i class="fas fa-list" aria-hidden="true"></i></span>
            <p>Total Records</p>
            <strong>{{ number_format($stats['total']) }}</strong>
        </article>
    </div>

    <div class="card transaction-table-card">
        <div class="card-header">
            <h3 class="card-title">Recent Transactions</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm transaction-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Accounts</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        @php($meta = $typeMeta[$t->transaction_type] ?? ['label' => ucwords(str_replace('_', ' ', $t->transaction_type)), 'class' => 'total', 'icon' => 'fa-receipt'])
                        <tr>
                            <td><strong>#{{ $t->id }}</strong></td>
                            <td>
                                <span class="transaction-type-badge {{ $meta['class'] }}">
                                    <i class="fas {{ $meta['icon'] }}" aria-hidden="true"></i>
                                    {{ $meta['label'] }}
                                </span>
                            </td>
                            <td>
                                <div class="transaction-account-pair">
                                    <span>{{ $t->from_account_number ?: 'No source' }}</span>
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    <span>{{ $t->to_account_number ?: 'No destination' }}</span>
                                </div>
                            </td>
                            <td><strong>{{ number_format($t->amount,2) }}</strong></td>
                            <td>{{ $t->transaction_date }}</td>
                            <td>
                                <div class="card-tools">
                                    <a href="{{ route('user.transactions.show',$t->id) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('user.transactions.edit',$t->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
