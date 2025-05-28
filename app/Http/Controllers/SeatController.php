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
        $userReservation = session('temp_reservation');

        if ($userReservation) {
            // Ubah ke object agar bisa diakses dengan ->
            $userReservation = json_decode(json_encode($userReservation)); // aman untuk casting nested
        }

        return view('auth.seat', compact('tables', 'userReservation'));
    }

    // Simpan pilihan meja ke session sementara
    public function tempReserve(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'reserved_at' => 'required|date',
        ]);

        $table = Table::find($request->table_id);

        if ($table->status === 'reserved') {
            return response()->json(['message' => 'This table is already reserved.'], 409);
        }

        // Simpan ke session sebagai array, agar serializable
        session([
            'temp_reservation' => [
                'table_id' => $table->id,
                'table' => [
                    'id' => $table->id,
                    'table_number' => $table->table_number ?? 'unknown',
                    'seats' => $table->seats ?? 0,
                ],
                'reserved_at' => $request->reserved_at,
            ]
        ]);

        return response()->json(['message' => 'Table temporarily selected.']);
    }

    // Simpan reservasi permanen saat payment sukses
    public function confirmReservation()
    {
        $temp = session('temp_reservation');

        if (!$temp) {
            return response()->json(['message' => 'No reservation data found.'], 404);
        }

        $table = Table::find($temp['table_id']);

        if ($table->status === 'reserved') {
            return response()->json(['message' => 'This table is already reserved.'], 409);
        }

        $table->status = 'reserved';
        $table->save();

        Reservation::create([
            'user_id' => Auth::id(),
            'table_id' => $table->id,
            'reserved_at' => $temp['reserved_at'],
        ]);

        session()->forget('temp_reservation');

        return response()->json(['message' => 'Reservation confirmed.']);
    }
}
