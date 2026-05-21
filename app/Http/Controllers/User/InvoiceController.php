<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\ActivityLog;
use App\Models\ApplicationSetting;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = $user->invoices()->orderBy('invoice_date','desc')->paginate(20);
        return view('user.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('user.invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_date'=>'required|date',
            'customer_name'=>'required',
            'amount'=>'required|numeric'
        ]);

        $user = Auth::user();
        $settings = ApplicationSetting::allAsArray();
        $invoicePrefix = preg_replace('/[^A-Za-z0-9-]/', '', $settings['invoice_prefix'] ?? 'INV') ?: 'INV';
        $invoiceNo = $invoicePrefix.time().rand(100,999);
        $data = $request->only(['invoice_date','customer_name','account_number','description','amount','note']);
        $data['user_id'] = $user->id;
        $data['invoice_no'] = $invoiceNo;

        $inv = Invoice::create($data);

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'action' => 'create_invoice',
            'description' => 'Created invoice: '.$inv->invoice_no,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('user.invoices.show', $inv->id)->with('success','Invoice created');
    }

    public function show($id)
    {
        $user = Auth::user();
        $inv = Invoice::with('user')->findOrFail($id);
        if ($inv->user_id != $user->id && $user->role !== 'admin') abort(403);

        $settings = ApplicationSetting::allAsArray();
        $dueDays = (int) ($settings['invoice_due_days'] ?? 7);
        $dueDate = Carbon::parse($inv->invoice_date)->addDays($dueDays);

        return view('user.invoices.show', compact('inv', 'settings', 'dueDate'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $inv = Invoice::findOrFail($id);
        if ($inv->user_id != $user->id) abort(403);

        return view('user.invoices.edit', compact('inv'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_date'=>'required|date',
            'customer_name'=>'required',
            'amount'=>'required|numeric'
        ]);

        $user = Auth::user();
        $inv = Invoice::findOrFail($id);
        if ($inv->user_id != $user->id) abort(403);

        $inv->update($request->only(['invoice_date','customer_name','account_number','description','amount','note']));

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'action' => 'update_invoice',
            'description' => 'Updated invoice: '.$inv->invoice_no,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('user.invoices.show', $inv->id)->with('success','Invoice updated');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $inv = Invoice::findOrFail($id);
        if ($inv->user_id != $user->id) abort(403);
        $invoiceNo = $inv->invoice_no;
        $inv->delete();

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'action' => 'delete_invoice',
            'description' => 'Deleted invoice: '.$invoiceNo,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('user.invoices.index')->with('success','Invoice deleted');
    }
}
