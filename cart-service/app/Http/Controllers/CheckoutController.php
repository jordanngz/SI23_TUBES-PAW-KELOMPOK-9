<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Cart, Transaction, Reservation, Table};
use App\Services\SpecialTableService;

class CheckoutController extends Controller
{
    // API: Get transaction details by code
    public function getTransaction($code)
    {
        $transaction = Transaction::with(['items.product', 'reservation.table'])
            ->where('transaction_code', $code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($transaction);
    }

    // API: Get transaction history for user
    public function getHistory()
    {
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return response()->json($transactions);
    }

    // API: Get user's active paid/pending transactions (for statusFinal)
    public function getActiveTransactions()
    {
        $transactions = Transaction::with(['reservation.table'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'pending'])
            ->latest()->get();
        return response()->json($transactions);
    }

    // API: Submit checkout / create transaction
    public function submitTransaction(Request $request)
    {
        $request->validate([
            'payment_method' => 'nullable|string',
            'temp_reservation' => 'required|array'
        ]);

        $cart = Auth::user()->cart()->with('items.product')->first();
        $temp = $request->temp_reservation;

        if (!$cart || !$temp || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart atau reservasi tidak valid.'], 400);
        }

        $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
        $service = $subtotal * 0.10;
        $tax = $subtotal * 0.07;
        $total = $subtotal + $service + $tax;

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'transaction_code' => 'KFD-' . strtoupper(Str::random(8)),
            'payment_method' => $request->payment_method ?? 'none',
            'status' => 'pending',
            'subtotal' => $subtotal,
            'service_charge' => $service,
            'tax' => $tax,
            'total' => $total,
            'temp_reservation' => json_encode($temp),
        ]);

        foreach ($cart->items as $item) {
            $transaction->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete();
        $cart->delete();

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

    // API: Confirm transaction and reserve table
    public function confirmTransaction(Request $request)
    {
        $transactionCode = $request->input('transaction');
        $transaction = Transaction::where('transaction_code', $transactionCode)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        }

        $temp = json_decode($transaction->temp_reservation, true);

        if (!$temp) {
            return response()->json(['success' => false, 'message' => 'Reservation failed: no reservation data found.'], 400);
        }

        $table = Table::find($temp['table_id']);

        if ($table && $table->status !== 'reserved') {
            $table->status = 'reserved';
            $table->save();

            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'table_id' => $table->id,
                'reserved_at' => $temp['reserved_at'],
            ]);

            $transaction->reservation_id = $reservation->id;
            $transaction->temp_reservation = null;
            $transaction->save();

            // Handle special table confirmation if needed
            if (!empty($temp['is_special'])) {
                app(SpecialTableService::class)->confirmReservation([
                    'reservation_id'     => $reservation->id,
                    'user_id'            => Auth::id(),
                    'event_type'         => $temp['event_type'] ?? null,
                    'decoration_request' => $temp['decoration_request'] ?? null,
                    'special_request'    => $temp['special_request'] ?? null,
                    'phone'              => $temp['phone'] ?? null,
                    'menu_preference'    => $temp['menu_preference'] ?? null,
                ]);
            }
        }

        $transaction->status = 'paid';
        $transaction->save();

        return response()->json(['success' => true, 'transaction' => $transaction]);
    }

    // API: Update payment method
    public function updatePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit,dana',
            'transaction_code' => 'required|string',
        ]);

        $transaction = Transaction::where('transaction_code', $request->transaction_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->payment_method = $request->payment_method;
        $transaction->save();

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }
}
