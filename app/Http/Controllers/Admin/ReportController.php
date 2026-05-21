<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\User;
use App\Models\AccountNumber;
use App\Models\ApplicationSetting;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with('user');
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->from_date) {
            $query->whereDate('transaction_date','>=',$request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('transaction_date','<=',$request->to_date);
        }
        if ($request->type) {
            $query->where('transaction_type',$request->type);
        }
        $transactions = $query->orderBy('transaction_date','desc')->paginate(20);
        $users = User::orderBy('name')->get();
        return view('admin.reports.transactions', compact('transactions','users'));
    }

    public function transactionShow($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function invoices(Request $request)
    {
        $query = Invoice::with('user');
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->from_date) {
            $query->whereDate('invoice_date','>=',$request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('invoice_date','<=',$request->to_date);
        }
        if ($request->customer_name) {
            $query->where('customer_name', 'like', '%'.$request->customer_name.'%');
        }

        $invoices = $query->orderBy('invoice_date','desc')->paginate(20);
        $users = User::orderBy('name')->get();

        return view('admin.reports.invoices', compact('invoices','users'));
    }

    public function invoiceShow($id)
    {
        $invoice = Invoice::with('user')->findOrFail($id);
        $settings = ApplicationSetting::allAsArray();
        $dueDays = (int) ($settings['invoice_due_days'] ?? 7);
        $dueDate = Carbon::parse($invoice->invoice_date)->addDays($dueDays);

        return view('admin.invoices.show', compact('invoice','settings','dueDate'));
    }

    public function users(Request $request)
    {
        $query = User::query();
        $users = $query->orderBy('name')->paginate(20);
        return view('admin.reports.users', compact('users'));
    }

    public function accounts(Request $request)
    {
        $accounts = AccountNumber::orderBy('account_name')->paginate(20);
        return view('admin.reports.accounts', compact('accounts'));
    }
}
