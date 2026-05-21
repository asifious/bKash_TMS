<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\AccountNumber;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = today()->toDateString();
        $yesterday = today()->subDay()->toDateString();

        $totalCashIn = Transaction::where('transaction_type','cash_in')->sum('amount');
        $totalSendMoney = Transaction::where('transaction_type','send_money')->sum('amount');
        $totalReceived = Transaction::where('transaction_type','received_money')->sum('amount');
        $totalTransactions = Transaction::count();
        $uniqueAccounts = Transaction::distinct()->count('from_account_number');

        $todayCashIn = Transaction::where('transaction_type','cash_in')->whereDate('transaction_date',$today)->sum('amount');
        $todaySendMoney = Transaction::where('transaction_type','send_money')->whereDate('transaction_date',$today)->sum('amount');
        $todayReceived = Transaction::where('transaction_type','received_money')->whereDate('transaction_date',$today)->sum('amount');
        $yesterdayTotal = Transaction::whereDate('transaction_date',$yesterday)->sum('amount');
        $todayTotal = Transaction::whereDate('transaction_date',$today)->sum('amount');

        $accountReceived = Transaction::where('transaction_type','received_money')
            ->selectRaw('to_account_number, sum(amount) as total')
            ->groupBy('to_account_number')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $accountSent = Transaction::where('transaction_type','send_money')
            ->selectRaw('from_account_number, sum(amount) as total')
            ->groupBy('from_account_number')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $userReceived = Transaction::where('transaction_type','received_money')
            ->selectRaw('user_id, sum(amount) as total')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $userSent = Transaction::where('transaction_type','send_money')
            ->selectRaw('user_id, sum(amount) as total')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $recentTransactions = Transaction::with('user')->orderBy('created_at','desc')->limit(10)->get();

        $totalTrendLabels = Transaction::selectRaw('transaction_date, sum(amount) as total')
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->pluck('transaction_date')
            ->toArray();

        $totalTrendData = Transaction::selectRaw('transaction_date, sum(amount) as total')
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->pluck('total')
            ->toArray();

        $dailyTrendRows = Transaction::selectRaw('transaction_date, transaction_type, sum(amount) as total')
            ->groupBy('transaction_date','transaction_type')
            ->orderBy('transaction_date')
            ->get();

        $dailyTrendLabels = $dailyTrendRows->pluck('transaction_date')->unique()->values()->toArray();
        $dailyTrendTotals = [];
        foreach ($dailyTrendRows as $row) {
            $dailyTrendTotals[$row->transaction_date][$row->transaction_type] = (float) $row->total;
        }
        $dailyTrendSeries = [
            'cash_in' => [],
            'send_money' => [],
            'received_money' => [],
        ];
        foreach ($dailyTrendLabels as $date) {
            foreach (array_keys($dailyTrendSeries) as $type) {
                $dailyTrendSeries[$type][] = $dailyTrendTotals[$date][$type] ?? 0;
            }
        }

        return view('admin.dashboard', compact(
            'totalCashIn','totalSendMoney','totalReceived','totalTransactions','uniqueAccounts',
            'todayCashIn','todaySendMoney','todayReceived','yesterdayTotal','todayTotal',
            'accountReceived','accountSent','userReceived','userSent','recentTransactions',
            'totalTrendLabels','totalTrendData','dailyTrendLabels','dailyTrendSeries'
        ));
    }
}
