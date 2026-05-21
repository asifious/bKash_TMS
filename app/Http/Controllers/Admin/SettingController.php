<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    private $tabs = [
        'general' => 'General',
        'currency' => 'Currency',
        'payment_provider' => 'Payment Provider',
        'invoice_settings' => 'Invoice Settings',
    ];

    public function index(Request $request)
    {
        $activeTab = $this->activeTab($request->query('tab'));
        $tabs = $this->tabs;
        $settings = ApplicationSetting::allAsArray();

        return view('admin.settings.index', compact('activeTab', 'tabs', 'settings'));
    }

    public function update(Request $request)
    {
        $activeTab = $this->activeTab($request->input('active_tab'));
        $settings = $this->validatedSettings($request, $activeTab);

        if ($activeTab === 'general') {
            if ($request->hasFile('application_logo')) {
                $settings['application_logo'] = $this->storeUpload($request->file('application_logo'), 'application-logo');
            }

            if ($request->hasFile('favicon')) {
                $settings['favicon'] = $this->storeUpload($request->file('favicon'), 'favicon');
            }
        }

        ApplicationSetting::setMany($settings);

        return redirect()
            ->route('admin.settings.index', ['tab' => $activeTab])
            ->with('success', 'Settings updated successfully');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Application cache cleared successfully');
    }

    private function activeTab($tab)
    {
        return array_key_exists($tab, $this->tabs) ? $tab : 'general';
    }

    private function validatedSettings(Request $request, $activeTab)
    {
        if ($activeTab === 'currency') {
            return $request->validate([
                'currency_code' => 'required|string|max:10',
                'currency_symbol' => 'required|string|max:10',
                'currency_position' => 'required|in:before,after',
                'decimal_separator' => 'required|string|max:2',
                'thousand_separator' => 'nullable|string|max:2',
                'decimal_places' => 'required|integer|min:0|max:4',
            ]);
        }

        if ($activeTab === 'payment_provider') {
            $data = $request->validate([
                'payment_provider' => 'required|string|max:80',
                'provider_mode' => 'required|in:sandbox,live',
                'bkash_merchant_number' => 'nullable|string|max:80',
                'bkash_app_key' => 'nullable|string|max:255',
                'bkash_app_secret' => 'nullable|string|max:255',
                'bkash_username' => 'nullable|string|max:150',
                'bkash_password' => 'nullable|string|max:150',
            ]);

            $data['provider_enabled'] = $request->boolean('provider_enabled') ? '1' : '0';

            return $data;
        }

        if ($activeTab === 'invoice_settings') {
            $data = $request->validate([
                'invoice_prefix' => 'required|string|max:20',
                'invoice_due_days' => 'required|integer|min:0|max:365',
                'invoice_tax_rate' => 'required|numeric|min:0|max:100',
                'invoice_tax_label' => 'required|string|max:80',
                'invoice_footer' => 'nullable|string|max:500',
                'invoice_terms' => 'nullable|string|max:1000',
                'invoice_payment_note' => 'nullable|string|max:500',
            ]);

            $data['show_invoice_logo'] = $request->boolean('show_invoice_logo') ? '1' : '0';

            return $data;
        }

        $data = $request->validate([
            'application_name' => 'required|string|max:150',
            'company_name' => 'nullable|string|max:191',
            'country_code' => 'required|string|max:20',
            'company_phone' => 'nullable|string|max:50',
            'date_format' => 'required|string|max:30',
            'time_zone' => 'required|string|max:80',
            'time_format' => 'required|in:12,24',
            'country' => 'nullable|string|max:100',
            'declare_country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:30',
            'tax_number' => 'nullable|string|max:100',
            'gstin' => 'nullable|string|max:100',
            'company_address' => 'nullable|string|max:500',
            'application_logo' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'favicon' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,ico|max:1024',
            'vat_number_label' => 'nullable|string|max:80',
            'default_language' => 'nullable|string|max:80',
        ]);

        unset($data['application_logo'], $data['favicon']);

        $data['automatic_payment_confirmation'] = $request->boolean('automatic_payment_confirmation') ? '1' : '0';
        $data['mail_notifications'] = $request->boolean('mail_notifications') ? '1' : '0';
        $data['show_additional_address_on_invoice'] = $request->boolean('show_additional_address_on_invoice') ? '1' : '0';

        return $data;
    }

    private function storeUpload($file, $prefix)
    {
        $directory = public_path('uploads/settings');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $prefix.'-'.time().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/settings/'.$filename;
    }
}
