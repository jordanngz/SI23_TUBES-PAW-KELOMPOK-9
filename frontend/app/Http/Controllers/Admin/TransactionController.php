<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BackendClient;

class TransactionController extends Controller
{
    private function hydrateTransaction($txData)
    {
        if (!$txData) return null;

        $itemsData = $txData['items'] ?? [];
        unset($txData['items']);

        $resData = $txData['reservation'] ?? null;
        unset($txData['reservation']);

        $userData = $txData['user'] ?? null;
        unset($txData['user']);

        $transaction = (new Transaction())->forceFill($txData);
        
        $items = collect($itemsData)->map(function ($itemData) {
            $item = (new \App\Models\TransactionItem())->forceFill($itemData);
            if (!empty($itemData['product'])) {
                $item->setRelation('product', (new \App\Models\Product())->forceFill($itemData['product']));
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

        if ($userData) {
            $transaction->setRelation('user', (new User())->forceFill($userData));
        }

        return $transaction;
    }

    public function index()
    {
        $response = BackendClient::request()->get(BackendClient::cartUrl('/api/admin/transactions'));
        $transactions = [];
        if ($response->successful()) {
            $transactions = collect($response->json())->map(fn($tx) => $this->hydrateTransaction($tx));
        }
        return view('admin.reservation', compact('transactions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,confirmed,completed,cancelled',
        ]);
        
        $response = BackendClient::request()->put(BackendClient::cartUrl("/api/admin/transactions/{$id}"), $request->only('status'));

        if ($response->successful()) {
            return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated!');
        }

        return back()->with('error', 'Failed to update transaction.');
    }

    public function destroy($id)
    {
        $response = BackendClient::request()->delete(BackendClient::cartUrl("/api/admin/transactions/{$id}"));

        if ($response->successful()) {
            return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted!');
        }

        return back()->with('error', 'Failed to delete transaction.');
    }
}