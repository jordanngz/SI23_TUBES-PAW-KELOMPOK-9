<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ConfirmationController extends Controller
{
    public function storeContact(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string',
            'phone' => 'required|string',
            'special_request' => 'nullable|string',
        ]);

        $transaction = Transaction::where('transaction_code', $request->transaction_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->phone = $request->phone;
        $transaction->special_request = $request->special_request;
        $transaction->save();

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

    public function confirmStatus(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string',
        ]);

        $transaction = Transaction::where('transaction_code', $request->transaction_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->status = 'confirmed';
        $transaction->save();

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

    public function finalizeConfirmation(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string',
            'phone' => 'required|string',
            'special_request' => 'nullable|string',
        ]);

        $transaction = Transaction::where('transaction_code', $request->transaction_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->phone = $request->phone;
        $transaction->special_request = $request->special_request;
        $transaction->status = 'confirmed';
        $transaction->save();

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }
}
