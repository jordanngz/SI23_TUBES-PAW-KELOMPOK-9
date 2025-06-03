<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class SeatController extends Controller
{
    // Tampilkan halaman pemilihan meja
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $time = $request->input('time', '19:00');
        $partySize = $request->input('party_size', 2);

        // Jika party size "7+", set ke angka besar (misal 7)
        $size = $partySize === '7+' ? 7 : (int)$partySize;

        // Ambil meja yang seats >= size dan belum ada reservasi di waktu itu
        $tables = Table::where('seats', '>=', $size)
            ->whereDoesntHave('reservations', function($query) use ($date, $time) {
                $query->whereDate('reserved_at', $date)
                      ->whereTime('reserved_at', $time);
            })
            ->get();

        // Ambil reservasi user yang aktif (jika ada)
        $userReservation = Reservation::where('user_id', Auth::id())
            ->with('table')
            ->first();

        
        return view('user.seat', [
            'tables' => $tables,
            'userReservation' => $userReservation,
            'tempReservation' => session('temp_reservation')
        ]);
    }

    // Simpan pilihan meja ke session sementara
    public function tempReserve(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'reserved_at' => 'required|date',
        ]);

        $table = Table::find($request->table_id);

        // Cek apakah sudah ada reservasi di waktu yang sama
        $exists = Reservation::where('table_id', $table->id)
            ->where('reserved_at', $request->reserved_at)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This table is already reserved for the selected time.'], 409);
        }

        // Simpan ke session
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

        // Cek ulang di database sebelum simpan
        $exists = Reservation::where('table_id', $temp['table_id'])
            ->where('reserved_at', $temp['reserved_at'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This table is already reserved for the selected time.'], 409);
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'table_id' => $temp['table_id'],
            'reserved_at' => $temp['reserved_at'],
        ]);

        session()->forget('temp_reservation');

        return response()->json(['message' => 'Reservation confirmed.']);
    }
}