@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Users Report</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ ucfirst($u->role) }}</td>
                        <td>{{ $u->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="card-tools">
                                <a href="{{ route('admin.reports.transactions', ['user_id' => $u->id]) }}" class="btn btn-sm btn-secondary">Transactions</a>
                                <a href="{{ route('admin.reports.invoices', ['user_id' => $u->id]) }}" class="btn btn-sm btn-secondary">Invoices</a>
                                <a href="{{ route('admin.activity-logs.index', ['user_id' => $u->id]) }}" class="btn btn-sm btn-secondary">Logs</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
