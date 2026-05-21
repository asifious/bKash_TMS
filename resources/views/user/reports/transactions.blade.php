@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">My Transaction Report <div class="card-tools"><button onclick="window.print();" class="btn btn-sm btn-secondary">Print</button><button onclick="window.print();" class="btn btn-sm btn-info">Save as PDF</button></div></div>
    <div class="card-body">
        <form method="GET" class="form-inline mb-3">
            <input type="date" name="from_date" class="form-control mr-2" value="{{ request('from_date') }}">
            <input type="date" name="to_date" class="form-control mr-2" value="{{ request('to_date') }}">
            <button class="btn btn-primary">Filter</button>
        </form>
        <table class="table table-sm table-bordered">
            <thead><tr><th>ID</th><th>Type</th><th>Amount</th><th>Date</th></tr></thead>
            <tbody>@foreach($transactions as $t)<tr><td>{{ $t->id }}</td><td>{{ $t->transaction_type }}</td><td>{{ number_format($t->amount,2) }}</td><td>{{ $t->transaction_date }}</td></tr>@endforeach</tbody>
        </table>
        {{ $transactions->links() }}
    </div>
</div>
@endsection
