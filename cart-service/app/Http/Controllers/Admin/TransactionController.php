<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'table'])->latest()->get();
        return response()->json($transactions);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,paid,confirmed,completed,cancelled',
        ]);
        $transaction->update($request->only('status'));
        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json([
            'success' => true
        ]);
    }
}