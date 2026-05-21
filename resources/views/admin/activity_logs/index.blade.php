@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Activity Logs</div>
    <div class="card-body">
        <form method="GET" class="form-inline mb-3">
            <div class="form-group mr-2"><input type="date" name="from_date" class="form-control" placeholder="From" value="{{ request('from_date') }}"></div>
            <div class="form-group mr-2"><input type="date" name="to_date" class="form-control" placeholder="To" value="{{ request('to_date') }}"></div>
            <div class="form-group mr-2"><select name="user_id" class="form-control"><option value="">All Users</option>@foreach($users as $u)<option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>@endforeach</select></div>
            <div class="form-group mr-2"><input type="text" name="action" class="form-control" placeholder="Action" value="{{ request('action') }}"></div>
            <button class="btn btn-primary">Filter</button>
        </form>
        <table class="table table-sm table-bordered">
            <thead><tr><th>Date</th><th>User</th><th>Role</th><th>Action</th><th>Description</th><th>IP</th></tr></thead>
            <tbody>@foreach($logs as $log)<tr><td>{{ $log->created_at }}</td><td>{{ $log->user_name }}</td><td>{{ $log->role }}</td><td>{{ $log->action }}</td><td>{{ $log->description }}</td><td>{{ $log->ip_address }}</td></tr>@endforeach</tbody>
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection
