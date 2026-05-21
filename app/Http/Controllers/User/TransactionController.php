<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\AccountNumber;
use App\Models\ActivityLog;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [
            'total' => $user->transactions()->count(),
            'cash_in' => $user->transactions()->where('transaction_type','cash_in')->sum('amount'),
            'send_money' => $user->transactions()->where('transaction_type','send_money')->sum('amount'),
            'received_money' => $user->transactions()->where('transaction_type','received_money')->sum('amount'),
        ];
        $transactions = $user->transactions()->orderBy('transaction_date','desc')->paginate(20);
        return view('user.transactions.index', compact('transactions','stats'));
    }

    public function create()
    {
        $accounts = AccountNumber::where('status',1)->pluck('account_number','account_number');
        return view('user.transactions.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:cash_in,send_money,received_money',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|unique:transactions,transaction_id',
        ]);

        $user = Auth::user();
        $data = $request->only(['transaction_type','transaction_date','from_account_number','to_account_number','amount','transaction_id','note']);
        $data['user_id'] = $user->id;

        $t = Transaction::create($data);

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'action' => 'create_transaction',
            'description' => 'Created transaction ID: '.($t->transaction_id ?? $t->id),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('user.transactions.show', $t->id)->with('success','Transaction saved');
    }

    public function show($id)
    {
        $user = Auth::user();
        $t = Transaction::findOrFail($id);
        if ($t->user_id != $user->id && $user->role !== 'admin') abort(403);
        return view('user.transactions.show', compact('t'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $t = Transaction::findOrFail($id);
        if ($t->user_id != $user->id) abort(403);
        $accounts = AccountNumber::where('status',1)->pluck('account_number','account_number');
        return view('user.transactions.edit', compact('t','accounts'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $t = Transaction::findOrFail($id);
        if ($t->user_id != $user->id) abort(403);
        $request->validate([
            'transaction_type' => 'required|in:cash_in,send_money,received_money',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|unique:transactions,transaction_id,'.$t->id,
        ]);

        $t->update($request->only(['transaction_type','transaction_date','from_account_number','to_account_number','amount','transaction_id','note']));

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'action' => 'update_transaction',
            'description' => 'Updated transaction ID: '.($t->transaction_id ?? $t->id),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('user.transactions.show', $t->id)->with('success','Transaction updated');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $t = Transaction::findOrFail($id);
        if ($t->user_id != $user->id) abort(403);
        $transactionLabel = $t->transaction_id ?? $t->id;
        $t->delete();

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'action' => 'delete_transaction',
            'description' => 'Deleted transaction ID: '.$transactionLabel,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('user.transactions.index')->with('success','Transaction deleted');
    }
}
