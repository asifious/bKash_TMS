@extends('layouts.app')

@section('pageTitle', 'Invoice Details')

@section('content')
@php
    $dateFormat = $settings['date_format'] ?? 'Y-m-d';
    $subtotal = (float) $invoice->amount;
    $taxRate = (float) ($settings['invoice_tax_rate'] ?? 0);
    $taxLabel = $settings['invoice_tax_label'] ?: 'Tax';
    $taxAmount = round($subtotal * ($taxRate / 100), 2);
    $total = $subtotal + $taxAmount;
    $decimalPlaces = (int) ($settings['decimal_places'] ?? 2);
    $decimalSeparator = $settings['decimal_separator'] ?? '.';
    $thousandSeparator = $settings['thousand_separator'] ?? ',';
    $currencySymbol = $settings['currency_symbol'] ?? 'BDT';
    $currencyPosition = $settings['currency_position'] ?? 'before';
    $formatMoney = function ($amount) use ($decimalPlaces, $decimalSeparator, $thousandSeparator, $currencySymbol, $currencyPosition) {
        $formatted = number_format((float) $amount, $decimalPlaces, $decimalSeparator, $thousandSeparator);

        return $currencyPosition === 'after' ? $formatted.' '.$currencySymbol : $currencySymbol.' '.$formatted;
    };
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Invoice {{ $invoice->invoice_no }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.reports.invoices') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
            <button onclick="window.print();" class="btn btn-sm btn-primary">
                <i class="fas fa-print" aria-hidden="true"></i>
                <span>Print</span>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <span>Created By</span>
                <strong>{{ $invoice->user->name ?? 'Deleted user' }}</strong>
            </div>
            <div class="detail-item">
                <span>User Email</span>
                <strong>{{ $invoice->user->email ?? 'Not available' }}</strong>
            </div>
            <div class="detail-item">
                <span>Invoice Date</span>
                <strong>{{ \Illuminate\Support\Carbon::parse($invoice->invoice_date)->format($dateFormat) }}</strong>
            </div>
            <div class="detail-item">
                <span>Due Date</span>
                <strong>{{ $dueDate->format($dateFormat) }}</strong>
            </div>
            <div class="detail-item">
                <span>Customer</span>
                <strong>{{ $invoice->customer_name }}</strong>
            </div>
            <div class="detail-item">
                <span>Account Number</span>
                <strong>{{ $invoice->account_number ?: '-' }}</strong>
            </div>
        </div>

        <div class="invoice-items-frame mt-2">
            <table class="invoice-item-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $invoice->description ?: 'Invoice service' }}</strong>
                            @if($invoice->note)
                                <span>{{ $invoice->note }}</span>
                            @endif
                        </td>
                        <td>1</td>
                        <td>{{ $formatMoney($subtotal) }}</td>
                        <td>{{ $formatMoney($subtotal) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-total-box admin-total-box">
            <div><span>Sub Total:</span><strong>{{ $formatMoney($subtotal) }}</strong></div>
            <div><span>{{ $taxLabel }}:</span><strong>{{ $taxRate > 0 ? $formatMoney($taxAmount) : 'N/A' }}</strong></div>
            <div><span>Total:</span><strong>{{ $formatMoney($total) }}</strong></div>
        </div>
    </div>
</div>
@endsection
