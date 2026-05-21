@extends('layouts.app')

@section('pageTitle', 'Edit Invoice')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Invoice {{ $inv->invoice_no }}</h3>
        <a href="{{ route('user.invoices.show', $inv->id) }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            <span>Back</span>
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.invoices.update', $inv->id) }}">
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <div class="form-group">
                    <label for="invoice_date">Invoice Date</label>
                    <input id="invoice_date" type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', $inv->invoice_date) }}">
                </div>

                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input id="customer_name" type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $inv->customer_name) }}">
                </div>

                <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input id="account_number" type="text" name="account_number" class="form-control" value="{{ old('account_number', $inv->account_number) }}">
                </div>

                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input id="amount" type="text" name="amount" class="form-control" value="{{ old('amount', $inv->amount) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $inv->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="note">Note</label>
                <textarea id="note" name="note" class="form-control">{{ old('note', $inv->note) }}</textarea>
            </div>

            <div class="profile-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    <span>Update Invoice</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
