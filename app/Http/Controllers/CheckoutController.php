<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Cart, Transaction, Reservation, Table};

class CheckoutController extends Controller
{
    public function credit(Request $request)
    {
        $code = $request->query('transaction');
        $transaction = Transaction::with('items.product')
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('payment.credit', compact('transaction'));
    }

    public function dana(Request $request)
    {
        $code = $request->query('transaction');
        $transaction = Transaction::with('items.product')
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('payment.dana', compact('transaction'));
    }

    public function receipt(Request $request)
    {
        $code = $request->query('transaction');
        $transaction = Transaction::with(['items.product', 'reservation.table'])
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('payment.receipt', compact('transaction'));
    }

    public function statusFinal()
    {
        $transactions = Transaction::with(['reservation.table'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['paid', 'pending'])
            ->latest()->get();
        return view('payment.statusFinal', compact('transactions'));


        $transactions = Transaction::with('reservation.table')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        return view('status', compact('transactions'));
    }

    public function submitTransaction(Request $request)
    {
        $request->validate([
            'payment_method' => 'nullable|string'
        ]);

        $cart = auth()->user()->cart()->with('items.product')->first();
        $temp = session('temp_reservation');

        if (!$cart || !$temp || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Cart atau reservasi tidak valid.');
        }

        $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
        $service = $subtotal * 0.10;
        $tax = $subtotal * 0.07;
        $total = $subtotal + $service + $tax;

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
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

        session(['transaction_id' => $transaction->id]);

        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('checkoutByCode', $transaction->transaction_code);
    }

    public function confirmTransaction(Request $request)
    {
        $transactionId = session('transaction_id');
        $transactionCode = $request->query('transaction');

        $transaction = null;
        if ($transactionCode) {
            $transaction = Transaction::where('transaction_code', $transactionCode)
                ->where('user_id', auth()->id())
                ->first();
        } elseif ($transactionId) {
            $transaction = Transaction::where('id', $transactionId)
                ->where('user_id', auth()->id())
                ->first();
        }

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found']);
        }

        // Fallback: dari session atau dari database (temp_reservation)
        $temp = session('temp_reservation') ?? json_decode($transaction->temp_reservation, true);

        if (!$temp) {
            return response()->json(['success' => false, 'message' => 'Reservation failed: no reservation data found.']);
        }

        $table = Table::find($temp['table_id']);

        if ($table && $table->status !== 'reserved') {
            $table->status = 'reserved';
            $table->save();

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'table_id' => $table->id,
                'reserved_at' => $temp['reserved_at'],
            ]);

            $transaction->reservation_id = $reservation->id;
            $transaction->temp_reservation = null; // Clear temp
            $transaction->save();

            session()->forget('temp_reservation');
        }

        $transaction->status = 'paid';
        $transaction->save();

        return response()->json(['success' => true]);
    }

    public function checkoutByCode($code)
    {
        $transaction = Transaction::with(['items.product', 'reservation.table'])
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('auth.checkout', compact('transaction'));
    }

    public function updateCredit(Request $request)
    {
        return $this->updatePaymentMethod($request, 'credit');
    }

    public function updateDana(Request $request)
    {
        return $this->updatePaymentMethod($request, 'dana');
    }

    protected function updatePaymentMethod(Request $request, $method)
    {
        $request->validate([
            'payment_method' => 'required|in:credit,dana',
            'transaction_code' => 'required|string',
        ]);

        $transaction = Transaction::where('transaction_code', $request->transaction_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $transaction->payment_method = $method;
        $transaction->save();

        return redirect()->route(
            $method === 'credit' ? 'payment.credit' : 'payment.dana',
            ['transaction' => $transaction->transaction_code]
        );
    }

    public function confirmView($transactionCode)
    {
        $transaction = Transaction::with(['reservation.table', 'items'])->where('transaction_code', $transactionCode)->firstOrFail();

        return view('checkout.confirm', compact('transaction'));

    }

    public function showHistory()
    {
        $transactions = Transaction::where('user_id', auth()->id())->latest()->get(); // atau disesuaikan
        return view('payment.history', compact('transactions'));
    }


}
