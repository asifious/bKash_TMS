@extends('layouts.app')

@section('pageTitle', 'Dashboard')

@section('content')
<div class="dashboard-grid">
    <article class="metric-card metric-blue">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-plus" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Cash In</p>
        <h2 class="metric-value">{{ number_format($totalCashIn, 2) }}</h2>
    </article>

    <article class="metric-card metric-green">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-paper-plane" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Send Money</p>
        <h2 class="metric-value">{{ number_format($totalSend, 2) }}</h2>
    </article>

    <article class="metric-card metric-amber">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Received</p>
        <h2 class="metric-value">{{ number_format($totalReceived, 2) }}</h2>
    </article>

    <article class="metric-card metric-pink">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-hashtag" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Unique Accounts</p>
        <h2 class="metric-value">{{ number_format($uniqueAccounts) }}</h2>
    </article>
</div>

@if($announcements->count())
    <div class="alert alert-info">
        <i class="fas fa-bullhorn" aria-hidden="true"></i>
        <div>
            <strong>{{ $announcements->first()->title }}</strong>
            <p class="empty-note">{{ $announcements->first()->message }}</p>
        </div>
    </div>
@endif

<div class="card chart-card">
    <div class="card-header">
        <h3 class="card-title">Transaction Trend by Type</h3>
    </div>
    <div class="card-body">
        <canvas id="userTrendChart"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recent Transactions</h3>
        <a href="{{ route('user.transactions.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus" aria-hidden="true"></i>
            <span>New</span>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $t)
                    <tr>
                        <td>#{{ $t->id }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $t->transaction_type)) }}</td>
                        <td>{{ number_format($t->amount, 2) }}</td>
                        <td>{{ $t->transaction_date }}</td>
                        <td><a href="{{ route('user.transactions.show', $t->id) }}" class="btn btn-sm btn-secondary">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No recent transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const userTrendCanvas = document.getElementById('userTrendChart');

    if (userTrendCanvas) {
        new Chart(userTrendCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Cash In',
                        data: {!! json_encode($chartSeries['cash_in']) !!},
                        backgroundColor: 'rgba(18, 183, 106, 0.78)',
                        borderRadius: 8,
                        maxBarThickness: 34
                    },
                    {
                        label: 'Send Money',
                        data: {!! json_encode($chartSeries['send_money']) !!},
                        backgroundColor: 'rgba(226, 19, 110, 0.78)',
                        borderRadius: 8,
                        maxBarThickness: 34
                    },
                    {
                        label: 'Received Money',
                        data: {!! json_encode($chartSeries['received_money']) !!},
                        backgroundColor: 'rgba(14, 165, 233, 0.78)',
                        borderRadius: 8,
                        maxBarThickness: 34
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(17, 24, 39, 0.06)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
