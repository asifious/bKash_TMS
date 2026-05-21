<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    public static function defaults()
    {
        return [
            'application_name' => 'bKash TMS',
            'company_name' => 'bKash Transaction Management System',
            'country_code' => '+880',
            'company_phone' => '01570-000000',
            'date_format' => 'd-m-Y',
            'time_zone' => 'Asia/Dhaka',
            'automatic_payment_confirmation' => '0',
            'time_format' => '12',
            'mail_notifications' => '1',
            'country' => 'Bangladesh',
            'declare_country' => 'Bangladesh',
            'city' => '',
            'postcode' => '',
            'tax_number' => '',
            'gstin' => '',
            'company_address' => '',
            'application_logo' => '',
            'favicon' => '',
            'vat_number_label' => 'GSTIN',
            'default_language' => 'English',
            'show_additional_address_on_invoice' => '1',
            'currency_code' => 'BDT',
            'currency_symbol' => 'BDT',
            'currency_position' => 'before',
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'decimal_places' => '2',
            'payment_provider' => 'bKash',
            'provider_mode' => 'sandbox',
            'provider_enabled' => '0',
            'bkash_merchant_number' => '',
            'bkash_app_key' => '',
            'bkash_app_secret' => '',
            'bkash_username' => '',
            'bkash_password' => '',
            'invoice_prefix' => 'INV',
            'invoice_due_days' => '7',
            'invoice_tax_rate' => '0',
            'invoice_tax_label' => 'Tax',
            'invoice_footer' => 'Thank you for your business.',
            'invoice_terms' => 'Payment is due by the due date shown on this invoice.',
            'invoice_payment_note' => 'Please include the invoice number with your payment.',
            'show_invoice_logo' => '1',
        ];
    }

    public static function allAsArray()
    {
        try {
            $stored = static::query()->pluck('setting_value', 'setting_key')->toArray();
        } catch (\Throwable $exception) {
            $stored = [];
        }

        return array_merge(static::defaults(), $stored);
    }

    public static function getValue($key, $default = null)
    {
        $settings = static::allAsArray();

        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }

    public static function setMany(array $settings)
    {
        foreach ($settings as $key => $value) {
            static::query()->updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => is_null($value) ? '' : (string) $value]
            );
        }
    }
}
