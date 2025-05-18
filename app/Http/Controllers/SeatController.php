<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // <- ini yang benar

class SeatController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        $userReservation = Reservation::where('user_id', auth()->id())->latest()->first();

        return view('auth.seat', compact('tables', 'userReservation'));
    }

    public function reserve(Request $request)
    {
        $request->validate(['table_id' => 'required|exists:tables,id']);

        Table::find($request->table_id)->update(['status' => 'reserved']);

        Reservation::create([
            'user_id' => auth()->id(),
            'table_id' => $request->table_id,
            'reserved_at' => now(),
        ]);

        return redirect()->route('menu')->with('success', 'Table reserved!');
    }
}
