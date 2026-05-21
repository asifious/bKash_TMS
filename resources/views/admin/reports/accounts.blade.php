@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Accounts Report</div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead><tr><th>ID</th><th>Account Number</th><th>Name</th><th>Type</th><th>Status</th></tr></thead>
            <tbody>@foreach($accounts as $a)<tr><td>{{ $a->id }}</td><td>{{ $a->account_number }}</td><td>{{ $a->account_name }}</td><td>{{ $a->type }}</td><td>{{ $a->status ? 'Active' : 'Inactive' }}</td></tr>@endforeach</tbody>
        </table>
        {{ $accounts->links() }}
    </div>
</div>
@endsection
