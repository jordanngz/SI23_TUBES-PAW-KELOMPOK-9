<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\{Cart, Transaction, Reservation};
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // 🔁 Normal Credit Payment Page (by session)
    public function credit(Request $request)
    {
        $code = $request->query('transaction');

        $transaction = Transaction::with('items.product')
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('payment.credit', compact('transaction'));
    }

    // 🔁 Normal Dana Payment Page (by session)
    public function dana(Request $request)
    {
        $code = $request->query('transaction');

        $transaction = Transaction::with('items.product')
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('payment.dana', compact('transaction'));
    }

    // 🔁 Receipt
    public function receipt(Request $request)
    {
        $code = $request->query('transaction');

        $transaction = Transaction::with(['items.product', 'reservation.table'])
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('payment.receipt', compact('transaction'));
    }

    // 📋 Status Riwayat Pembayaran
    public function statusFinal()
    {
        $transactions = Transaction::with(['reservation.table'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['paid', 'pending'])
            ->latest()
            ->get();

        return view('payment.statusFinal', compact('transactions'));
    }

    // 🧾 Simpan Transaksi Baru dari Cart
    public function submitTransaction(Request $request)
    {
        $request->validate([
            'payment_method' => 'nullable|string'
        ]);

        $cart = auth()->user()->cart()->with('items.product')->first();
        $reservation = Reservation::where('user_id', auth()->id())->latest()->first();

        if (!$cart || !$reservation) {
            return redirect()->route('cart')->with('error', 'Cart atau reservasi tidak valid.');
        }

        $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
        $service = $subtotal * 0.10;
        $tax = $subtotal * 0.07;
        $total = $subtotal + $service + $tax;

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'reservation_id' => $reservation->id,
            'transaction_code' => 'KFD-' . strtoupper(Str::random(8)),
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'service_charge' => $service,
            'tax' => $tax,
            'total' => $total,
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

    // ✅ Konfirmasi Transaksi Jadi "Paid" (berbasis session atau kode)
    public function confirmTransaction(Request $request)
    {
        $transactionId = session('transaction_id');
        $transactionCode = $request->query('transaction');

        if ($transactionCode) {
            $transaction = Transaction::where('transaction_code', $transactionCode)
                ->where('user_id', auth()->id())
                ->first();
        } elseif ($transactionId) {
            $transaction = Transaction::find($transactionId);
        } else {
            return response()->json(['success' => false, 'message' => 'Transaction not found']);
        }

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found']);
        }

        $transaction->status = 'paid';
        $transaction->save();

        $cart = auth()->user()->cart;
        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        return response()->json(['success' => true]);
    }

    // 🔎 Checkout View via Transaction Code
    public function checkoutByCode($code)
    {
        $transaction = Transaction::with(['items.product', 'reservation.table'])
            ->where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('auth.checkout', compact('transaction'));
    }

    // 📥 Update dari Checkout dengan metode dipilih (CREDIT)
    public function updateCredit(Request $request)
    {
        return $this->updatePaymentMethod($request, 'credit');
    }

    // 📥 Update dari Checkout dengan metode dipilih (DANA)
    public function updateDana(Request $request)
    {
        return $this->updatePaymentMethod($request, 'dana');
    }

    // 🔄 Core function untuk update metode dan redirect ke halaman yang sesuai
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

        if ($method === 'credit') {
            return redirect()->route('payment.credit', ['transaction' => $transaction->transaction_code]);
        } else {
            return redirect()->route('payment.dana', ['transaction' => $transaction->transaction_code]);
        }
    }
}
