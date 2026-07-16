<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackendClient;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Table;
use App\Models\Reservation;

class CheckoutController extends Controller
{
    private function hydrateTransaction($txData)
    {
        if (!$txData) return null;

        $itemsData = $txData['items'] ?? [];
        unset($txData['items']);

        $resData = $txData['reservation'] ?? null;
        unset($txData['reservation']);

        $transaction = (new Transaction())->forceFill($txData);
        
        $items = collect($itemsData)->map(function ($itemData) {
            $item = (new \App\Models\TransactionItem())->forceFill($itemData);
            if (!empty($itemData['product'])) {
                $item->setRelation('product', (new Product())->forceFill($itemData['product']));
            }
            return $item;
        });
        $transaction->setRelation('items', $items);

        if ($resData) {
            $reservation = (new Reservation())->forceFill($resData);
            if (!empty($resData['table'])) {
                $reservation->setRelation('table', (new Table())->forceFill($resData['table']));
            }
            $transaction->setRelation('reservation', $reservation);
        }

        return $transaction;
    }

    public function credit(Request $request)
    {
        $code = $request->query('transaction');
        $response = BackendClient::request()->get(BackendClient::cartUrl("/api/checkout/{$code}"));
        $transaction = $this->hydrateTransaction($response->json());
        return view('user.payment.credit', compact('transaction'));
    }

    public function dana(Request $request)
    {
        $code = $request->query('transaction');
        $response = BackendClient::request()->get(BackendClient::cartUrl("/api/checkout/{$code}"));
        $transaction = $this->hydrateTransaction($response->json());
        return view('user.payment.dana', compact('transaction'));
    }

    public function receipt(Request $request)
    {
        $code = $request->query('transaction');
        $response = BackendClient::request()->get(BackendClient::cartUrl("/api/checkout/{$code}"));
        $transaction = $this->hydrateTransaction($response->json());
        return view('user.payment.receipt', compact('transaction'));
    }

    public function statusFinal()
    {
        $response = BackendClient::request()->get(BackendClient::cartUrl('/api/payment/active'));
        $transactions = [];
        if ($response->successful()) {
            $transactions = collect($response->json())->map(fn($tx) => $this->hydrateTransaction($tx));
        }
        return view('user.payment.statusFinal', compact('transactions'));
    }

    public function submitTransaction(Request $request)
    {
        $temp = session('temp_reservation');
        if (!$temp) {
            return redirect()->route('cart')->with('error', 'Reservasi tidak valid.');
        }

        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/payment/submit'), [
            'payment_method' => $request->payment_method ?? 'none',
            'temp_reservation' => $temp
        ]);

        if ($response->successful() && $response->json('success')) {
            $txCode = $response->json('transaction.transaction_code');
            session(['transaction_id' => $response->json('transaction.id')]);
            return redirect()->route('checkoutByCode', $txCode);
        }

        return redirect()->route('cart')->with('error', $response->json('error', 'Gagal memproses transaksi.'));
    }

    public function confirmTransaction(Request $request)
    {
        $code = $request->query('transaction');
        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/payment/confirm'), [
            'transaction' => $code
        ]);

        if ($response->successful()) {
            session()->forget('temp_reservation');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => $response->json('message', 'Confirmation failed')]);
    }

    public function checkoutByCode($code)
    {
        $response = BackendClient::request()->get(BackendClient::cartUrl("/api/checkout/{$code}"));
        $transaction = $this->hydrateTransaction($response->json());
        return view('user.payment.metode', compact('transaction'));
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
        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/payment/update-method'), [
            'payment_method' => $method,
            'transaction_code' => $request->transaction_code
        ]);

        if ($response->successful()) {
            $txCode = $response->json('transaction.transaction_code');
            return redirect()->route(
                $method === 'credit' ? 'payment.credit' : 'payment.dana',
                ['transaction' => $txCode]
            );
        }

        return back()->with('error', 'Gagal update metode pembayaran.');
    }

    public function confirmView($transactionCode)
    {
        $response = BackendClient::request()->get(BackendClient::cartUrl("/api/checkout/{$transactionCode}"));
        $transaction = $this->hydrateTransaction($response->json());
        return view('user.checkout.confirm', compact('transaction'));
    }

    public function showHistory()
    {
        $response = BackendClient::request()->get(BackendClient::cartUrl('/api/payment/history'));
        $transactions = [];
        if ($response->successful()) {
            $transactions = collect($response->json())->map(fn($tx) => $this->hydrateTransaction($tx));
        }
        return view('user.payment.history', compact('transactions'));
    }
}
