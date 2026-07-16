<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class receipt_controller extends Controller
{

    public function showReceipt($id)
    {
        $transaction = Transaction::with(['items', 'user', 'reservation'])->findOrFail($id);
        return view('receipt', compact('transaction'));
    }

}
