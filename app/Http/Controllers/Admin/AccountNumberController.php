<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountNumber;

class AccountNumberController extends Controller
{
    public function index()
    {
        $accounts = AccountNumber::orderBy('created_at','desc')->paginate(20);
        return view('admin.account_numbers.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.account_numbers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|unique:account_numbers,account_number',
            'account_name' => 'required',
            'type' => 'required',
        ]);

        AccountNumber::create([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'type' => $request->type,
            'status' => $request->status ? 1 : 0,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.account-numbers.index')->with('success', 'Account number created');
    }

    public function edit($id)
    {
        $account = AccountNumber::findOrFail($id);
        return view('admin.account_numbers.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = AccountNumber::findOrFail($id);
        $request->validate([
            'account_number' => 'required|unique:account_numbers,account_number,'.$account->id,
            'account_name' => 'required',
            'type' => 'required',
        ]);

        $account->update([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'type' => $request->type,
            'status' => $request->status ? 1 : 0,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.account-numbers.index')->with('success', 'Account number updated');
    }

    public function destroy($id)
    {
        AccountNumber::findOrFail($id)->delete();
        return redirect()->route('admin.account-numbers.index')->with('success', 'Account number deleted');
    }
}
