@extends('layouts.app')

@section('pageTitle', 'Settings')

@section('content')
@php
    $field = function ($key) use ($settings) {
        return old($key, $settings[$key] ?? '');
    };

    $isChecked = function ($key) use ($settings) {
        return old($key, $settings[$key] ?? '0') == '1';
    };

    $logoUrl = !empty($settings['application_logo']) ? asset($settings['application_logo']) : null;
    $faviconUrl = !empty($settings['favicon']) ? asset($settings['favicon']) : null;
@endphp

<div class="settings-workspace">
    <div class="settings-tabs" role="tablist" aria-label="Settings sections">
        @foreach($tabs as $key => $label)
            <a href="{{ route('admin.settings.index', ['tab' => $key]) }}" class="settings-tab {{ $activeTab === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="settings-panel">
        @csrf
        @method('PUT')
        <input type="hidden" name="active_tab" value="{{ $activeTab }}">

        @if($activeTab === 'general')
            <div class="settings-grid">
                <div class="form-group">
                    <label for="application_name">Application Name:<span class="required">*</span></label>
                    <input id="application_name" name="application_name" type="text" class="form-control" value="{{ $field('application_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="company_name">Company name:<span class="required">*</span></label>
                    <input id="company_name" name="company_name" type="text" class="form-control" value="{{ $field('company_name') }}" placeholder="Company name">
                </div>

                <div class="form-group">
                    <label for="country_code">Country Code:<span class="required">*</span></label>
                    <select id="country_code" name="country_code" class="form-control" required>
                        <option value="+880" {{ $field('country_code') === '+880' ? 'selected' : '' }}>Bangladesh +880</option>
                        <option value="+91" {{ $field('country_code') === '+91' ? 'selected' : '' }}>India +91</option>
                        <option value="+1" {{ $field('country_code') === '+1' ? 'selected' : '' }}>United States +1</option>
                        <option value="+44" {{ $field('country_code') === '+44' ? 'selected' : '' }}>United Kingdom +44</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="company_phone">Company Phone:<span class="required">*</span></label>
                    <input id="company_phone" name="company_phone" type="text" class="form-control" value="{{ $field('company_phone') }}" placeholder="01570-000000">
                </div>

                <div class="form-group">
                    <label for="date_format">Date Format:<span class="required">*</span></label>
                    <select id="date_format" name="date_format" class="form-control" required>
                        <option value="d-m-Y" {{ $field('date_format') === 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                        <option value="m-d-Y" {{ $field('date_format') === 'm-d-Y' ? 'selected' : '' }}>MM-DD-YYYY</option>
                        <option value="Y-m-d" {{ $field('date_format') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                        <option value="d/m/Y" {{ $field('date_format') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="time_zone">Time Zone:<span class="required">*</span></label>
                    <select id="time_zone" name="time_zone" class="form-control" required>
                        <option value="Asia/Dhaka" {{ $field('time_zone') === 'Asia/Dhaka' ? 'selected' : '' }}>Asia/Dhaka</option>
                        <option value="UTC" {{ $field('time_zone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="Asia/Kolkata" {{ $field('time_zone') === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata</option>
                        <option value="America/New_York" {{ $field('time_zone') === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                    </select>
                </div>

                <div class="settings-control-block">
                    <label>Automatic payment confirmation:<span class="required">*</span></label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="automatic_payment_confirmation" value="1" {{ $isChecked('automatic_payment_confirmation') ? 'checked' : '' }}>
                        <span></span>
                    </label>
                    <p>Automatic Confirmation</p>
                </div>

                <div class="settings-control-block">
                    <label>Time Format:<span class="required">*</span></label>
                    <div class="segmented-control">
                        <label>
                            <input type="radio" name="time_format" value="12" {{ $field('time_format') === '12' ? 'checked' : '' }}>
                            <span>12 Hours</span>
                        </label>
                        <label>
                            <input type="radio" name="time_format" value="24" {{ $field('time_format') === '24' ? 'checked' : '' }}>
                            <span>24 Hours</span>
                        </label>
                    </div>
                </div>

                <div class="settings-control-block">
                    <label>Mail Notifications:<span class="required">*</span></label>
                    <div class="segmented-control">
                        <label>
                            <input type="radio" name="mail_notifications" value="1" {{ $isChecked('mail_notifications') ? 'checked' : '' }}>
                            <span>Yes</span>
                        </label>
                        <label>
                            <input type="radio" name="mail_notifications" value="0" {{ ! $isChecked('mail_notifications') ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <div class="settings-control-block">
                    <label>Clear cache:</label>
                    <button type="submit" form="clear-cache-form" class="btn btn-primary btn-sm">Clear cache</button>
                </div>

                <div class="form-group">
                    <label for="country">Country:<span class="required">*</span></label>
                    <input id="country" name="country" type="text" class="form-control" value="{{ $field('country') }}" placeholder="Bangladesh">
                </div>

                <div class="form-group">
                    <label for="declare_country">To indicate, to declare:<span class="required">*</span></label>
                    <input id="declare_country" name="declare_country" type="text" class="form-control" value="{{ $field('declare_country') }}" placeholder="Bangladesh">
                </div>

                <div class="form-group">
                    <label for="city">City:<span class="required">*</span></label>
                    <input id="city" name="city" type="text" class="form-control" value="{{ $field('city') }}" placeholder="City">
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode:<span class="required">*</span></label>
                    <input id="postcode" name="postcode" type="text" class="form-control" value="{{ $field('postcode') }}" placeholder="Post code">
                </div>

                <div class="form-group">
                    <label for="tax_number">fax number:<span class="required">*</span></label>
                    <input id="tax_number" name="tax_number" type="text" class="form-control" value="{{ $field('tax_number') }}" placeholder="fax number">
                </div>

                <div class="form-group">
                    <label for="gstin">GSTIN:<span class="required">*</span></label>
                    <input id="gstin" name="gstin" type="text" class="form-control" value="{{ $field('gstin') }}" placeholder="GSTIN">
                </div>

                <div class="form-group">
                    <label for="company_address">Company Address:<span class="required">*</span></label>
                    <textarea id="company_address" name="company_address" class="form-control" placeholder="Company address">{{ $field('company_address') }}</textarea>
                </div>

                <div class="form-group settings-upload">
                    <label>Application Logo:<span class="required">*</span></label>
                    <div class="settings-upload-preview">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Application logo">
                        @else
                            <span><i class="fas fa-infinity" aria-hidden="true"></i></span>
                        @endif
                    </div>
                    <input id="application_logo" name="application_logo" type="file" class="form-control">
                </div>

                <div class="form-group settings-upload">
                    <label>Favicon:<span class="required">*</span></label>
                    <div class="settings-upload-preview">
                        @if($faviconUrl)
                            <img src="{{ $faviconUrl }}" alt="Favicon">
                        @else
                            <span><i class="fas fa-infinity" aria-hidden="true"></i></span>
                        @endif
                    </div>
                    <input id="favicon" name="favicon" type="file" class="form-control">
                </div>

                <div class="form-group">
                    <label for="vat_number_label">VAT Number Label:</label>
                    <input id="vat_number_label" name="vat_number_label" type="text" class="form-control" value="{{ $field('vat_number_label') }}" placeholder="GSTIN">
                </div>

                <div class="form-group">
                    <label for="default_language">Default language:</label>
                    <select id="default_language" name="default_language" class="form-control">
                        <option value="">Choose an option</option>
                        <option value="English" {{ $field('default_language') === 'English' ? 'selected' : '' }}>English</option>
                        <option value="Bangla" {{ $field('default_language') === 'Bangla' ? 'selected' : '' }}>Bangla</option>
                    </select>
                </div>

                <div class="settings-control-block">
                    <label>Show Additional Address on Invoice:</label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="show_additional_address_on_invoice" value="1" {{ $isChecked('show_additional_address_on_invoice') ? 'checked' : '' }}>
                        <span></span>
                    </label>
                </div>
            </div>
        @endif

        @if($activeTab === 'currency')
            <div class="settings-grid compact">
                <div class="form-group">
                    <label for="currency_code">Currency Code:<span class="required">*</span></label>
                    <input id="currency_code" name="currency_code" type="text" class="form-control" value="{{ $field('currency_code') }}" required>
                </div>
                <div class="form-group">
                    <label for="currency_symbol">Currency Symbol:<span class="required">*</span></label>
                    <input id="currency_symbol" name="currency_symbol" type="text" class="form-control" value="{{ $field('currency_symbol') }}" required>
                </div>
                <div class="form-group">
                    <label for="currency_position">Currency Position:<span class="required">*</span></label>
                    <select id="currency_position" name="currency_position" class="form-control">
                        <option value="before" {{ $field('currency_position') === 'before' ? 'selected' : '' }}>Before amount</option>
                        <option value="after" {{ $field('currency_position') === 'after' ? 'selected' : '' }}>After amount</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="decimal_places">Decimal Places:<span class="required">*</span></label>
                    <input id="decimal_places" name="decimal_places" type="number" min="0" max="4" class="form-control" value="{{ $field('decimal_places') }}" required>
                </div>
                <div class="form-group">
                    <label for="decimal_separator">Decimal Separator:<span class="required">*</span></label>
                    <input id="decimal_separator" name="decimal_separator" type="text" class="form-control" value="{{ $field('decimal_separator') }}" required>
                </div>
                <div class="form-group">
                    <label for="thousand_separator">Thousand Separator:</label>
                    <input id="thousand_separator" name="thousand_separator" type="text" class="form-control" value="{{ $field('thousand_separator') }}">
                </div>
            </div>
        @endif

        @if($activeTab === 'payment_provider')
            <div class="settings-grid compact">
                <div class="form-group">
                    <label for="payment_provider">Payment Provider:<span class="required">*</span></label>
                    <select id="payment_provider" name="payment_provider" class="form-control">
                        <option value="bKash" {{ $field('payment_provider') === 'bKash' ? 'selected' : '' }}>bKash</option>
                        <option value="Manual" {{ $field('payment_provider') === 'Manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="provider_mode">Mode:<span class="required">*</span></label>
                    <select id="provider_mode" name="provider_mode" class="form-control">
                        <option value="sandbox" {{ $field('provider_mode') === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                        <option value="live" {{ $field('provider_mode') === 'live' ? 'selected' : '' }}>Live</option>
                    </select>
                </div>
                <div class="settings-control-block">
                    <label>Provider Enabled:</label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="provider_enabled" value="1" {{ $isChecked('provider_enabled') ? 'checked' : '' }}>
                        <span></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="bkash_merchant_number">bKash Merchant Number:</label>
                    <input id="bkash_merchant_number" name="bkash_merchant_number" type="text" class="form-control" value="{{ $field('bkash_merchant_number') }}">
                </div>
                <div class="form-group">
                    <label for="bkash_app_key">App Key:</label>
                    <input id="bkash_app_key" name="bkash_app_key" type="text" class="form-control" value="{{ $field('bkash_app_key') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="bkash_app_secret">App Secret:</label>
                    <input id="bkash_app_secret" name="bkash_app_secret" type="password" class="form-control" value="{{ $field('bkash_app_secret') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="bkash_username">Username:</label>
                    <input id="bkash_username" name="bkash_username" type="text" class="form-control" value="{{ $field('bkash_username') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="bkash_password">Password:</label>
                    <input id="bkash_password" name="bkash_password" type="password" class="form-control" value="{{ $field('bkash_password') }}" autocomplete="off">
                </div>
            </div>
        @endif

        @if($activeTab === 'invoice_settings')
            <div class="settings-grid compact">
                <div class="form-group">
                    <label for="invoice_prefix">Invoice Prefix:<span class="required">*</span></label>
                    <input id="invoice_prefix" name="invoice_prefix" type="text" class="form-control" value="{{ $field('invoice_prefix') }}" required>
                </div>
                <div class="form-group">
                    <label for="invoice_due_days">Default Due Days:<span class="required">*</span></label>
                    <input id="invoice_due_days" name="invoice_due_days" type="number" min="0" max="365" class="form-control" value="{{ $field('invoice_due_days') }}" required>
                </div>
                <div class="form-group">
                    <label for="invoice_tax_rate">Invoice Tax Rate (%):<span class="required">*</span></label>
                    <input id="invoice_tax_rate" name="invoice_tax_rate" type="number" min="0" max="100" step="0.01" class="form-control" value="{{ $field('invoice_tax_rate') }}" required>
                </div>
                <div class="form-group">
                    <label for="invoice_tax_label">Tax Label:<span class="required">*</span></label>
                    <input id="invoice_tax_label" name="invoice_tax_label" type="text" class="form-control" value="{{ $field('invoice_tax_label') }}" required>
                </div>
                <div class="settings-control-block">
                    <label>Show Invoice Logo:</label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="show_invoice_logo" value="1" {{ $isChecked('show_invoice_logo') ? 'checked' : '' }}>
                        <span></span>
                    </label>
                </div>
                <div class="form-group span-2">
                    <label for="invoice_terms">Invoice Terms:</label>
                    <textarea id="invoice_terms" name="invoice_terms" class="form-control">{{ $field('invoice_terms') }}</textarea>
                </div>
                <div class="form-group span-2">
                    <label for="invoice_payment_note">Payment Note:</label>
                    <textarea id="invoice_payment_note" name="invoice_payment_note" class="form-control">{{ $field('invoice_payment_note') }}</textarea>
                </div>
                <div class="form-group span-2">
                    <label for="invoice_footer">Invoice Footer:</label>
                    <textarea id="invoice_footer" name="invoice_footer" class="form-control">{{ $field('invoice_footer') }}</textarea>
                </div>
            </div>
        @endif

        <div class="settings-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save" aria-hidden="true"></i>
                <span>Save</span>
            </button>
        </div>
    </form>

    <form id="clear-cache-form" method="POST" action="{{ route('admin.settings.clear-cache') }}">
        @csrf
    </form>
</div>
@endsection
