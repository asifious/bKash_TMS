@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">My Invoice Report <div class="card-tools"><button onclick="window.print();" class="btn btn-sm btn-secondary">Print</button><button onclick="window.print();" class="btn btn-sm btn-info">Save as PDF</button></div></div>
    <div class="card-body">
        <form method="GET" class="form-inline mb-3">
            <input type="date" name="from_date" class="form-control mr-2" value="{{ request('from_date') }}">
            <input type="date" name="to_date" class="form-control mr-2" value="{{ request('to_date') }}">
            <button class="btn btn-primary">Filter</button>
        </form>
        <table class="table table-sm table-bordered">
            <thead><tr><th>No</th><th>Date</th><th>Customer</th><th>Amount</th></tr></thead>
            <tbody>@foreach($invoices as $inv)<tr><td>{{ $inv->invoice_no }}</td><td>{{ $inv->invoice_date }}</td><td>{{ $inv->customer_name }}</td><td>{{ number_format($inv->amount,2) }}</td></tr>@endforeach</tbody>
        </table>
        {{ $invoices->links() }}
    </div>
</div>
@endsection
