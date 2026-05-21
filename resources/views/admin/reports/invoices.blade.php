@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Invoices Report</h3>
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
            <input type="text" name="customer_name" class="form-control mr-2" placeholder="Customer" value="{{ request('customer_name') }}">
            <button class="btn btn-primary">
                <i class="fas fa-search" aria-hidden="true"></i>
                <span>Search</span>
            </button>
        </form>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Account</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td>{{ $inv->invoice_no }}</td>
                        <td>{{ $inv->user->name ?? 'Deleted user' }}</td>
                        <td>{{ $inv->invoice_date }}</td>
                        <td>{{ $inv->customer_name }}</td>
                        <td>{{ $inv->account_number ?: '-' }}</td>
                        <td>{{ number_format($inv->amount,2) }}</td>
                        <td>
                            <a href="{{ route('admin.invoices.show', $inv->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $invoices->appends(request()->query())->links() }}
    </div>
</div>
@endsection
