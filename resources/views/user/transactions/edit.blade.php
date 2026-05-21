@extends('layouts.app')

@section('pageTitle', 'Edit Transaction')

@section('content')
@php
    $selectedType = old('transaction_type', $t->transaction_type);
@endphp

<div class="transaction-form-layout">
    <section class="transaction-form-hero">
        <div>
            <p>Edit transaction</p>
            <h2>Transaction #{{ $t->id }}</h2>
            <span>Update the movement type, account path, amount, reference, or note.</span>
        </div>
        <a href="{{ route('user.transactions.show', $t->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            <span>Back</span>
        </a>
    </section>

    <section class="card transaction-form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('user.transactions.update', $t->id) }}">
                @csrf
                @method('PUT')

                <div class="transaction-type-picker">
                    <label class="{{ $selectedType === 'cash_in' ? 'active' : '' }}">
                        <input type="radio" name="transaction_type" value="cash_in" {{ $selectedType === 'cash_in' ? 'checked' : '' }}>
                        <span><i class="fas fa-money-bill-wave" aria-hidden="true"></i></span>
                        <strong>Cash In</strong>
                    </label>
                    <label class="{{ $selectedType === 'send_money' ? 'active' : '' }}">
                        <input type="radio" name="transaction_type" value="send_money" {{ $selectedType === 'send_money' ? 'checked' : '' }}>
                        <span><i class="fas fa-paper-plane" aria-hidden="true"></i></span>
                        <strong>Send Money</strong>
                    </label>
                    <label class="{{ $selectedType === 'received_money' ? 'active' : '' }}">
                        <input type="radio" name="transaction_type" value="received_money" {{ $selectedType === 'received_money' ? 'checked' : '' }}>
                        <span><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></span>
                        <strong>Received Money</strong>
                    </label>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="transaction_date">Date</label>
                        <input id="transaction_date" type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', $t->transaction_date) }}">
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input id="amount" type="text" name="amount" class="form-control" value="{{ old('amount', $t->amount) }}">
                    </div>

                    <div class="form-group">
                        <label for="transaction_id">Transaction ID</label>
                        <input id="transaction_id" type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id', $t->transaction_id) }}">
                    </div>
                </div>

                <div class="transaction-account-flow">
                    <div class="form-group">
                        <label for="from_account_number">From Account</label>
                        <select id="from_account_number" name="from_account_number" class="form-control">
                            <option value="">Select source account</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc }}" {{ old('from_account_number', $t->from_account_number) === $acc ? 'selected' : '' }}>{{ $acc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <span class="transaction-flow-arrow"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>

                    <div class="form-group">
                        <label for="to_account_number">To Account</label>
                        <input id="to_account_number" type="text" name="to_account_number" class="form-control" value="{{ old('to_account_number', $t->to_account_number) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea id="note" name="note" class="form-control">{{ old('note', $t->note) }}</textarea>
                </div>

                <div class="transaction-form-actions">
                    <button class="btn btn-primary">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        <span>Update Transaction</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.transaction-type-picker input').forEach(function (input) {
        input.addEventListener('change', function () {
            document.querySelectorAll('.transaction-type-picker label').forEach(function (label) {
                label.classList.toggle('active', label.contains(input) && input.checked);
            });
        });
    });
</script>
@endpush
