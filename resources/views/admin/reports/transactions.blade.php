@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transactions Report</h3>
        <div class="card-tools">
            <button onclick="window.print();" class="btn btn-sm btn-secondary">
                <i class="fas fa-print" aria-hidden="true"></i>
                <span>Print</span>
            </button>
            <button onclick="window.print();" class="btn btn-sm btn-info">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
                <span>Save as PDF</span>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="form-inline mb-3">
            <select name="user_id" class="form-control mr-2">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            <input type="date" name="from_date" class="form-control mr-2" value="{{ request('from_date') }}">
            <input type="date" name="to_date" class="form-control mr-2" value="{{ request('to_date') }}">
            <select name="type" class="form-control mr-2">
                <option value="">All Types</option>
                <option value="cash_in" {{ request('type')=='cash_in' ? 'selected':'' }}>Cash In</option>
                <option value="send_money" {{ request('type')=='send_money' ? 'selected':'' }}>Send Money</option>
                <option value="received_money" {{ request('type')=='received_money' ? 'selected':'' }}>Received</option>
            </select>
            <button class="btn btn-primary">
                <i class="fas fa-search" aria-hidden="true"></i>
                <span>Search</span>
            </button>
        </form>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>#{{ $t->id }}</td>
                        <td>{{ $t->user->name ?? 'Deleted user' }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $t->transaction_type)) }}</td>
                        <td>{{ $t->from_account_number ?: '-' }}</td>
                        <td>{{ $t->to_account_number ?: '-' }}</td>
                        <td>{{ number_format($t->amount,2) }}</td>
                        <td>{{ $t->transaction_date }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $t->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
@endsection
