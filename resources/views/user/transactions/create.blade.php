@extends('layouts.app')

@section('pageTitle', 'Create Transaction')

@section('content')
@php
    $selectedType = old('transaction_type', 'cash_in');
@endphp

<div class="transaction-form-layout">
    <section class="transaction-form-hero">
        <div>
            <p>New transaction</p>
            <h2>Record a clean transaction entry</h2>
            <span>Choose the movement type, accounts, amount, and reference number in one focused form.</span>
        </div>
        <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            <span>Back</span>
        </a>
    </section>

    <section class="card transaction-form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('user.transactions.store') }}">
                @csrf

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
                        <input id="transaction_date" type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input id="amount" type="text" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label for="transaction_id">Transaction ID</label>
                        <input id="transaction_id" type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id') }}" placeholder="Reference number">
                    </div>
                </div>

                <div class="transaction-account-flow">
                    <div class="form-group">
                        <label for="from_account_number">From Account</label>
                        <select id="from_account_number" name="from_account_number" class="form-control">
                            <option value="">Select source account</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc }}" {{ old('from_account_number') === $acc ? 'selected' : '' }}>{{ $acc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <span class="transaction-flow-arrow"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>

                    <div class="form-group">
                        <label for="to_account_number">To Account</label>
                        <input id="to_account_number" type="text" name="to_account_number" class="form-control" value="{{ old('to_account_number') }}" placeholder="Destination account">
                    </div>
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea id="note" name="note" class="form-control" placeholder="Optional transaction note">{{ old('note') }}</textarea>
                </div>

                <div class="transaction-form-actions">
                    <button class="btn btn-primary">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        <span>Save Transaction</span>
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
