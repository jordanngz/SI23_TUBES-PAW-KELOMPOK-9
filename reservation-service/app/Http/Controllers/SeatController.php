<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class SeatController extends Controller
{
    // API endpoint to search available tables
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $time = $request->input('time', '19:00');
        $partySize = $request->input('party_size', 2);

        $size = $partySize === '7+' ? 7 : (int)$partySize;

        $tables = Table::where('seats', '>=', $size)
            ->whereDoesntHave('reservations', function($query) use ($date, $time) {
                $query->whereDate('reserved_at', $date)
                      ->whereTime('reserved_at', $time);
            })
            ->get();

        $userReservation = null;
        if (Auth::check()) {
            $userReservation = Reservation::where('user_id', Auth::id())
                ->with('table')
                ->first();
        }

        return response()->json([
            'tables' => $tables,
            'userReservation' => $userReservation
        ]);
    }

    // API endpoint to temporarily hold a table
    public function tempReserve(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'reserved_at' => 'required|date',
        ]);

        $table = Table::find($request->table_id);

        $exists = Reservation::where('table_id', $table->id)
            ->where('reserved_at', $request->reserved_at)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This table is already reserved for the selected time.'], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Table is available.',
            'session_data' => [
                'table_id' => $table->id,
                'table' => [
                    'id' => $table->id,
                    'table_number' => $table->table_number ?? 'unknown',
                    'seats' => $table->seats ?? 0,
                ],
                'reserved_at' => $request->reserved_at,
            ]
        ]);
    }

    // API endpoint to confirm a reservation (called from cart-service or frontend)
    public function confirmReservation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'table_id' => 'required|exists:tables,id',
            'reserved_at' => 'required|date',
        ]);

        $exists = Reservation::where('table_id', $request->table_id)
            ->where('reserved_at', $request->reserved_at)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This table is already reserved for the selected time.'], 409);
        }

        $table = Table::find($request->table_id);
        if ($table) {
            $table->status = 'reserved';
            $table->save();
        }

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'table_id' => $request->table_id,
            'reserved_at' => $request->reserved_at,
        ]);

        return response()->json([
            'success' => true,
            'reservation' => $reservation
        ]);
    }
}