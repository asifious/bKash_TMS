@extends('layouts.app')

@section('pageTitle', 'View Invoice')

@section('content')
@php
    $dateFormat = $settings['date_format'] ?? 'Y-m-d';
    $invoiceDate = \Illuminate\Support\Carbon::parse($inv->invoice_date);
    $companyName = $settings['company_name'] ?: ($settings['application_name'] ?? config('app.name', 'bKash TMS'));
    $companyAddress = trim($settings['company_address'] ?? '');
    $companyPhone = trim($settings['company_phone'] ?? '');
    $companyTaxLabel = $settings['vat_number_label'] ?: 'GSTIN';
    $companyTaxValue = trim($settings['gstin'] ?? '');
    $logoPath = $settings['application_logo'] ?? '';
    $showLogo = ($settings['show_invoice_logo'] ?? '1') == '1' && $logoPath;
    $issuerName = optional($inv->user)->name ?: $companyName;
    $issuerEmail = optional($inv->user)->email;
    $issuerPhone = optional($inv->user)->phone;
    $lineDescription = trim($inv->description ?: 'Invoice service');
    $subtotal = (float) $inv->amount;
    $taxRate = (float) ($settings['invoice_tax_rate'] ?? 0);
    $taxLabel = $settings['invoice_tax_label'] ?: 'Tax';
    $taxAmount = round($subtotal * ($taxRate / 100), 2);
    $total = $subtotal + $taxAmount;
    $paidAmount = 0;
    $remainingAmount = max($total - $paidAmount, 0);
    $statusLabel = $remainingAmount > 0 ? 'Pending Payment' : 'Paid';
    $statusClass = $remainingAmount > 0 ? 'warning' : 'success';
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

<div class="invoice-screen screen-only">
    <div class="invoice-toolbar">
        <div>
            <h2>View Invoice</h2>
            <p>{{ $inv->invoice_no }} issued to {{ $inv->customer_name }}</p>
        </div>
        <div class="invoice-toolbar-actions">
            <a href="{{ route('user.invoices.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
            <a href="{{ route('user.invoices.edit', $inv->id) }}" class="btn btn-secondary">
                <i class="fas fa-edit" aria-hidden="true"></i>
                <span>Edit</span>
            </a>
            <button type="button" onclick="window.print();" class="btn btn-primary">
                <i class="fas fa-print" aria-hidden="true"></i>
                <span>Print Invoice</span>
            </button>
        </div>
    </div>

    <div class="invoice-tabbar" role="tablist" aria-label="Invoice sections">
        <button type="button" class="invoice-tab active" data-invoice-tab="overview">Overview</button>
        <button type="button" class="invoice-tab" data-invoice-tab="terms">Note &amp; Terms</button>
        <button type="button" class="invoice-tab" data-invoice-tab="history">Payment History</button>
    </div>

    <section class="invoice-tab-panel" data-invoice-panel="overview">
        <div class="invoice-overview-grid">
            <article class="invoice-document">
                <div class="invoice-document-head">
                    <div class="invoice-brand-area">
                        @if($showLogo)
                            <img src="{{ asset($logoPath) }}" alt="{{ $companyName }}" class="invoice-logo">
                        @else
                            <span class="invoice-brand-mark"><i class="fas fa-infinity" aria-hidden="true"></i></span>
                        @endif
                    </div>

                    <div class="invoice-id-block">
                        <span>Invoice</span>
                        <strong>#{{ $inv->invoice_no }}</strong>
                    </div>

                    <div class="invoice-date-block">
                        <span>Invoice Date</span>
                        <strong>{{ $invoiceDate->format($dateFormat) }}</strong>
                    </div>

                    <div class="invoice-date-block">
                        <span>Due Date</span>
                        <strong>{{ $dueDate->format($dateFormat) }}</strong>
                    </div>

                    <button type="button" onclick="window.print();" class="btn btn-success">
                        <i class="fas fa-print" aria-hidden="true"></i>
                        <span>Print Invoice</span>
                    </button>
                </div>

                <div class="invoice-party-grid">
                    <div>
                        <span>Issue For</span>
                        <strong>{{ $inv->customer_name }}</strong>
                        @if($inv->account_number)
                            <p>{{ $inv->account_number }}</p>
                        @endif
                    </div>
                    <div>
                        <span>Issued By</span>
                        <strong>{{ $issuerName }}</strong>
                        @if($companyAddress)
                            <p>{{ $companyAddress }}</p>
                        @endif
                    </div>
                </div>

                <div class="invoice-items-frame">
                    <table class="invoice-item-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>{{ $lineDescription }}</strong>
                                    @if($inv->note)
                                        <span>{{ $inv->note }}</span>
                                    @endif
                                </td>
                                <td>1</td>
                                <td>{{ $formatMoney($subtotal) }}</td>
                                <td>{{ $formatMoney($subtotal) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="invoice-foot-grid">
                    <div class="invoice-stamp">
                        <span class="invoice-brand-mark small"><i class="fas fa-infinity" aria-hidden="true"></i></span>
                        <strong>{{ $settings['application_name'] ?? 'bKash TMS' }}</strong>
                    </div>

                    <div class="invoice-tax-box">
                        <span>Tax Information: (%)</span>
                        <strong>{{ $taxRate > 0 ? $taxRate.'% '.$taxLabel : 'No tax applied' }}</strong>
                    </div>

                    <div class="invoice-total-box">
                        <div><span>Sub Total:</span><strong>{{ $formatMoney($subtotal) }}</strong></div>
                        <div><span>{{ $taxLabel }}:</span><strong>{{ $taxRate > 0 ? $formatMoney($taxAmount) : 'N/A' }}</strong></div>
                        <div><span>Total:</span><strong>{{ $formatMoney($total) }}</strong></div>
                    </div>
                </div>
            </article>

            <aside class="invoice-client-panel">
                <h3>Client Overview</h3>
                <span class="invoice-status {{ $statusClass }}">{{ $statusLabel }}</span>

                <dl>
                    <dt>Client Name</dt>
                    <dd>{{ $inv->customer_name }}</dd>

                    <dt>Account Number</dt>
                    <dd>{{ $inv->account_number ?: 'Not added' }}</dd>

                    <dt>Paid Amount</dt>
                    <dd>{{ $formatMoney($paidAmount) }}</dd>

                    <dt>Remaining Amount</dt>
                    <dd>{{ $formatMoney($remainingAmount) }}</dd>
                </dl>
            </aside>
        </div>
    </section>

    <section class="invoice-tab-panel" data-invoice-panel="terms" hidden>
        <div class="invoice-detail-panel">
            <div>
                <h3>Invoice Note</h3>
                <p>{{ $inv->note ?: 'No additional invoice note has been added.' }}</p>
            </div>
            <div>
                <h3>Terms</h3>
                <p>{{ $settings['invoice_terms'] ?: 'Payment is due by the due date shown on this invoice.' }}</p>
            </div>
            <div>
                <h3>Payment Note</h3>
                <p>{{ $settings['invoice_payment_note'] ?: 'Please include the invoice number with your payment.' }}</p>
            </div>
        </div>
    </section>

    <section class="invoice-tab-panel" data-invoice-panel="history" hidden>
        <div class="invoice-detail-panel centered">
            <span class="invoice-empty-icon"><i class="fas fa-receipt" aria-hidden="true"></i></span>
            <h3>No payment history</h3>
            <p>Payments recorded against this invoice will appear here.</p>
        </div>
    </section>
</div>

<section class="print-invoice print-only">
    <header class="print-header">
        <div>
            @if($showLogo)
                <img src="{{ asset($logoPath) }}" alt="{{ $companyName }}" class="print-logo">
            @endif
            <h1>{{ $companyName }}</h1>
            @if($companyAddress)
                <p>{{ $companyAddress }}</p>
            @endif
            @if($companyPhone)
                <p>{{ $companyPhone }}</p>
            @endif
            @if($companyTaxValue)
                <p>{{ $companyTaxLabel }}: {{ $companyTaxValue }}</p>
            @endif
        </div>
        <div class="print-title">
            <span>Invoice</span>
            <strong>#{{ $inv->invoice_no }}</strong>
        </div>
    </header>

    <div class="print-meta-grid">
        <div>
            <span>Bill To</span>
            <strong>{{ $inv->customer_name }}</strong>
            @if($inv->account_number)
                <p>{{ $inv->account_number }}</p>
            @endif
        </div>
        <div>
            <span>Issued By</span>
            <strong>{{ $issuerName }}</strong>
            @if($issuerEmail)
                <p>{{ $issuerEmail }}</p>
            @endif
            @if($issuerPhone)
                <p>{{ $issuerPhone }}</p>
            @endif
        </div>
        <div>
            <span>Invoice Date</span>
            <strong>{{ $invoiceDate->format($dateFormat) }}</strong>
            <span>Due Date</span>
            <strong>{{ $dueDate->format($dateFormat) }}</strong>
        </div>
    </div>

    <table class="print-table">
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
                <td>{{ $lineDescription }}</td>
                <td>1</td>
                <td>{{ $formatMoney($subtotal) }}</td>
                <td>{{ $formatMoney($subtotal) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="print-summary-grid">
        <div class="print-notes">
            <h2>Notes &amp; Terms</h2>
            @if($inv->note)
                <p>{{ $inv->note }}</p>
            @endif
            <p>{{ $settings['invoice_terms'] ?: 'Payment is due by the due date shown on this invoice.' }}</p>
            <p>{{ $settings['invoice_payment_note'] ?: 'Please include the invoice number with your payment.' }}</p>
        </div>

        <div class="print-totals">
            <div><span>Subtotal</span><strong>{{ $formatMoney($subtotal) }}</strong></div>
            <div><span>{{ $taxLabel }}{{ $taxRate > 0 ? ' ('.$taxRate.'%)' : '' }}</span><strong>{{ $taxRate > 0 ? $formatMoney($taxAmount) : 'N/A' }}</strong></div>
            <div class="grand-total"><span>Total Due</span><strong>{{ $formatMoney($remainingAmount) }}</strong></div>
        </div>
    </div>

    <footer class="print-footer">
        <span>{{ $settings['invoice_footer'] ?: 'Thank you for your business.' }}</span>
        <span>{{ $statusLabel }}</span>
    </footer>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-invoice-tab]').forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = tab.getAttribute('data-invoice-tab');

            document.querySelectorAll('[data-invoice-tab]').forEach(function (item) {
                item.classList.toggle('active', item === tab);
            });

            document.querySelectorAll('[data-invoice-panel]').forEach(function (panel) {
                panel.hidden = panel.getAttribute('data-invoice-panel') !== target;
            });
        });
    });
</script>
@endpush
