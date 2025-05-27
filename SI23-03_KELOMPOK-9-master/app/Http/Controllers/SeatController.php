<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class SeatController extends Controller
{
    // Tampilkan halaman pemilihan meja
    public function index()
    {
        $tables = Table::all();
        $userReservation = Reservation::where('user_id', Auth::id())->latest()->first();

        return view('auth.seat', compact('tables', 'userReservation'));
    }

    // Simpan pilihan meja ke database
    public function reserve(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
        ]);

        $table = Table::find($request->table_id);

        // Cek apakah meja sudah direservasi
        if ($table->status === 'reserved') {
            return response()->json(['message' => 'This table is already reserved.'], 409);
        }

        // Update status meja
        $table->status = 'reserved';
        $table->save();

        // Simpan reservasi baru
        Reservation::create([
            'user_id' => Auth::id(),
            'table_id' => $table->id,
            'reserved_at' => now(),
        ]);

        return response()->json(['message' => 'Table reserved successfully.']);
    }
}
