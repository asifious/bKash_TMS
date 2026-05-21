<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Transaction;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalCashIn = $user->transactions()->where('transaction_type','cash_in')->sum('amount');
        $totalSend = $user->transactions()->where('transaction_type','send_money')->sum('amount');
        $totalReceived = $user->transactions()->where('transaction_type','received_money')->sum('amount');
        $totalTransactions = $user->transactions()->count();
        $uniqueAccounts = $user->transactions()->distinct()->count('from_account_number');
        $recentTransactions = $user->transactions()->orderBy('created_at','desc')->limit(10)->get();

        $trendRows = $user->transactions()
            ->selectRaw('transaction_date, transaction_type, sum(amount) as total')
            ->groupBy('transaction_date','transaction_type')
            ->orderBy('transaction_date')
            ->get();

        $chartLabels = $trendRows->pluck('transaction_date')->unique()->values()->toArray();
        $chartTotals = [];
        foreach ($trendRows as $row) {
            $chartTotals[$row->transaction_date][$row->transaction_type] = (float) $row->total;
        }
        $chartSeries = [
            'cash_in' => [],
            'send_money' => [],
            'received_money' => [],
        ];
        foreach ($chartLabels as $date) {
            foreach (array_keys($chartSeries) as $type) {
                $chartSeries[$type][] = $chartTotals[$date][$type] ?? 0;
            }
        }

        $announcements = Announcement::where('status',1)
            ->where(function($q){
                $q->whereNull('expire_at')->orWhere('expire_at','>',now());
            })
            ->where('created_at','>=', now()->subDay())
            ->get();

        return view('user.dashboard', compact(
            'totalCashIn',
            'totalSend',
            'totalReceived',
            'totalTransactions',
            'uniqueAccounts',
            'recentTransactions',
            'announcements',
            'chartLabels',
            'chartSeries'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'username' => ['required', 'string', 'max:100', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if ($request->filled('password') && ! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function transactionsReport(Request $request)
    {
        $user = Auth::user();
        $query = $user->transactions();
        if ($request->from_date) {
            $query->whereDate('transaction_date','>=',$request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('transaction_date','<=',$request->to_date);
        }
        $transactions = $query->orderBy('transaction_date','desc')->paginate(20);
        return view('user.reports.transactions', compact('transactions'));
    }

    public function invoicesReport(Request $request)
    {
        $user = Auth::user();
        $query = $user->invoices();
        if ($request->from_date) {
            $query->whereDate('invoice_date','>=',$request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('invoice_date','<=',$request->to_date);
        }
        $invoices = $query->orderBy('invoice_date','desc')->paginate(20);
        return view('user.reports.invoices', compact('invoices'));
    }
}
