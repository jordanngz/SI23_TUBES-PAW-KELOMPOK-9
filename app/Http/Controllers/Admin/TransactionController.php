<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::with(['user', 'table'])->latest()->get();
        return view('admin.reservation', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled',
        ]);
        $transaction->update($request->only('status'));
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted!');
    }
}