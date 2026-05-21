@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Create Invoice</div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.invoices.store') }}">
            @csrf
            <div class="form-group">
                <label>Invoice Date</label>
                <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
            </div>
            <div class="form-group">
                <label>Account Number</label>
                <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control" value="{{ old('amount') }}">
            </div>
            <div class="form-group">
                <label>Note</label>
                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
            </div>
            <button class="btn btn-primary">Save Invoice</button>
        </form>
    </div>
</div>
@endsection
