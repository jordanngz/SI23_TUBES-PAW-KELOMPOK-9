<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackendClient;

class ConfirmationController extends Controller
{
    public function storeContact(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string',
            'phone' => 'required|string',
            'special_request' => 'nullable|string',
        ]);

        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/confirmation/update'), [
            'transaction_code' => $request->transaction_code,
            'phone' => $request->phone,
            'special_request' => $request->special_request,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Contact info saved successfully.');
        }

        return redirect()->back()->with('error', 'Failed to save contact info.');
    }

    public function confirmStatus(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string',
        ]);

        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/confirmation/confirm-status'), [
            'transaction_code' => $request->transaction_code,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Transaction status updated to confirmed.');
        }

        return redirect()->back()->with('error', 'Failed to confirm transaction.');
    }

    public function finalizeConfirmation(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string',
            'phone' => 'required|string',
            'special_request' => 'nullable|string',
        ]);

        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/confirmation/finalize'), [
            'transaction_code' => $request->transaction_code,
            'phone' => $request->phone,
            'special_request' => $request->special_request,
        ]);

        if ($response->successful()) {
            return redirect()->route('payment.history')->with('success', 'Reservation confirmed and contact info saved.');
        }

        return redirect()->back()->with('error', 'Failed to finalize confirmation.');
    }
}
