@extends('layouts.app')

@section('pageTitle', 'Admin Dashboard')

@section('content')
<div class="dashboard-grid">
    <article class="metric-card metric-blue">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-money-bill-wave" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Total Cash In</p>
        <h2 class="metric-value">{{ number_format($totalCashIn, 2) }}</h2>
    </article>

    <article class="metric-card metric-green">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-paper-plane" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Total Send Money</p>
        <h2 class="metric-value">{{ number_format($totalSendMoney, 2) }}</h2>
    </article>

    <article class="metric-card metric-amber">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-wallet" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Total Received</p>
        <h2 class="metric-value">{{ number_format($totalReceived, 2) }}</h2>
    </article>

    <article class="metric-card metric-pink">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-list" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Total Transactions</p>
        <h2 class="metric-value">{{ number_format($totalTransactions) }}</h2>
    </article>
</div>

<div class="dashboard-grid">
    <article class="metric-card metric-blue">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-calendar-day" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Today Cash In</p>
        <h2 class="metric-value">{{ number_format($todayCashIn, 2) }}</h2>
    </article>

    <article class="metric-card metric-green">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-arrow-up" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Today Send</p>
        <h2 class="metric-value">{{ number_format($todaySendMoney, 2) }}</h2>
    </article>

    <article class="metric-card metric-amber">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Today Received</p>
        <h2 class="metric-value">{{ number_format($todayReceived, 2) }}</h2>
    </article>

    <article class="metric-card">
        <div class="metric-head">
            <span class="metric-icon"><i class="fas fa-history" aria-hidden="true"></i></span>
        </div>
        <p class="metric-label">Yesterday Total</p>
        <h2 class="metric-value">{{ number_format($yesterdayTotal, 2) }}</h2>
    </article>
</div>

<div class="dashboard-chart-grid">
    <div class="card chart-card">
        <div class="card-header">
            <h3 class="card-title">Total Transaction Trend</h3>
        </div>
        <div class="card-body">
            <canvas id="adminTotalTrendChart"></canvas>
        </div>
    </div>

    <div class="card chart-card">
        <div class="card-header">
            <h3 class="card-title">Daily Transaction Trend</h3>
        </div>
        <div class="card-body">
            <canvas id="adminDailyTrendChart"></canvas>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Top Receiving Accounts</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($accountReceived as $row)
                        <li class="list-group-item">
                            <span>{{ $row->to_account_number }}</span>
                            <strong>{{ number_format($row->total, 2) }}</strong>
                        </li>
                    @empty
                        <li class="list-group-item"><span>No receiving account data yet.</span></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Transactions</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($recentTransactions as $t)
                        <tr>
                            <td>#{{ $t->id }}</td>
                            <td>{{ $t->user->name ?? '' }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $t->transaction_type)) }}</td>
                            <td>{{ number_format($t->amount, 2) }}</td>
                            <td>{{ $t->transaction_date }}</td>
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
    </div>
</div>
@endsection

@push('scripts')
<script>
    const adminTotalTrendCanvas = document.getElementById('adminTotalTrendChart');
    const adminDailyTrendCanvas = document.getElementById('adminDailyTrendChart');
    const sharedChartOptions = {
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
    };

    if (adminTotalTrendCanvas) {
        new Chart(adminTotalTrendCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($totalTrendLabels) !!},
                datasets: [{
                    label: 'Daily Total',
                    data: {!! json_encode($totalTrendData) !!},
                    backgroundColor: 'rgba(70, 95, 255, 0.78)',
                    borderRadius: 8,
                    categoryPercentage: 0.68,
                    barPercentage: 0.82,
                    maxBarThickness: 32
                }]
            },
            options: sharedChartOptions
        });
    }

    if (adminDailyTrendCanvas) {
        new Chart(adminDailyTrendCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($dailyTrendLabels) !!},
                datasets: [
                    {
                        label: 'Cash In',
                        data: {!! json_encode($dailyTrendSeries['cash_in']) !!},
                        backgroundColor: 'rgba(18, 183, 106, 0.78)',
                        borderRadius: 8,
                        categoryPercentage: 0.72,
                        barPercentage: 0.82,
                        maxBarThickness: 22
                    },
                    {
                        label: 'Send Money',
                        data: {!! json_encode($dailyTrendSeries['send_money']) !!},
                        backgroundColor: 'rgba(226, 19, 110, 0.78)',
                        borderRadius: 8,
                        categoryPercentage: 0.72,
                        barPercentage: 0.82,
                        maxBarThickness: 22
                    },
                    {
                        label: 'Received Money',
                        data: {!! json_encode($dailyTrendSeries['received_money']) !!},
                        backgroundColor: 'rgba(14, 165, 233, 0.78)',
                        borderRadius: 8,
                        categoryPercentage: 0.72,
                        barPercentage: 0.82,
                        maxBarThickness: 22
                    }
                ]
            },
            options: sharedChartOptions
        });
    }
</script>
@endpush
