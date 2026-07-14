<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class SpecialReservationController extends Controller
{
    /**
     * GET /api/special/tables
     * Kembalikan daftar meja special yang tersedia pada tanggal, waktu, dan party size tertentu.
     */
    public function availableTables(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'time'       => 'required',
            'party_size' => 'required|integer|min:1',
        ]);

        $tables = Table::availableAt(
            $request->date,
            $request->time,
            (int) $request->party_size
        )->get();

        return response()->json([
            'tables' => $tables->map(fn($t) => [
                'id'           => $t->id,
                'table_number' => $t->table_number,
                'seats'        => $t->seats,
                'type'         => $t->type,
                'status'       => $t->status,
                'image'        => $t->image ?? null,
            ]),
        ]);
    }

    /**
     * POST /api/special/temp
     * Validasi data form, cek ketersediaan meja, dan kembalikan session_data
     * yang akan disimpan oleh main app ke session('temp_reservation').
     */
    public function tempStore(Request $request)
    {
        $request->validate([
            'table_id'           => 'required|integer|exists:tables,id',
            'reserved_at'        => 'required|date',
            'event_type'         => 'required|string|max:100',
            'party_size'         => 'required|integer|min:6',
            'decoration_request' => 'nullable|string|max:500',
            'special_request'    => 'nullable|string|max:1000',
            'phone'              => 'required|string|max:20',
            'menu_preference'    => 'required|in:set_menu,a_la_carte',
        ]);

        $table = Table::special()->find($request->table_id);

        if (!$table) {
            return response()->json([
                'message' => 'Table not found or is not a special table.',
            ], 404);
        }

        // Cek apakah meja sudah ada reservasi di waktu yang sama
        $alreadyBooked = Reservation::where('table_id', $table->id)
            ->where('reserved_at', $request->reserved_at)
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'message' => 'This special table is already reserved for the selected time. Please choose a different time.',
            ], 409);
        }

        // Bangun session_data yang akan disimpan di main app
        $sessionData = [
            'table_id'    => $table->id,
            'table'       => [
                'id'           => $table->id,
                'table_number' => $table->table_number,
                'seats'        => $table->seats,
            ],
            'reserved_at'        => $request->reserved_at,
            'is_special'         => true,
            'event_type'         => $request->event_type,
            'party_size'         => $request->party_size,
            'decoration_request' => $request->decoration_request ?? '',
            'special_request'    => $request->special_request ?? '',
            'phone'              => $request->phone,
            'menu_preference'    => $request->menu_preference,
        ];

        Log::info('[SpecialReservationService] Temp reservation created', [
            'table_id' => $table->id,
            'event'    => $request->event_type,
        ]);

        return response()->json([
            'message'      => 'Special reservation data validated and ready.',
            'session_data' => $sessionData,
        ]);
    }

    /**
     * POST /api/special/confirm
     * Dipanggil oleh main app setelah payment sukses.
     * Update kolom-kolom special pada reservasi yang sudah ada di DB.
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'reservation_id'     => 'required|integer|exists:reservations,id',
            'user_id'            => 'required|integer',
            'event_type'         => 'nullable|string|max:100',
            'decoration_request' => 'nullable|string|max:500',
            'special_request'    => 'nullable|string|max:1000',
            'phone'              => 'nullable|string|max:20',
            'menu_preference'    => 'nullable|string|max:50',
        ]);

        $reservation = Reservation::find($request->reservation_id);

        // Pastikan reservasi milik user yang benar
        if ($reservation->user_id != $request->user_id) {
            return response()->json(['message' => 'Reservation does not belong to this user.'], 403);
        }

        $reservation->update([
            'event_type'         => $request->event_type,
            'decoration_request' => $request->decoration_request,
            'special_request'    => $request->special_request,
            'phone'              => $request->phone,
            'menu_preference'    => $request->menu_preference,
            'is_special'         => true,
        ]);

        Log::info('[SpecialReservationService] Reservation confirmed as special', [
            'reservation_id' => $reservation->id,
        ]);

        return response()->json([
            'message'        => 'Special reservation confirmed and details saved.',
            'reservation_id' => $reservation->id,
        ]);
    }

    /**
     * GET /api/special/{id}
     * Ambil detail satu special reservation.
     */
    public function show(int $id)
    {
        $reservation = Reservation::with('table')
            ->where('is_special', true)
            ->find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Special reservation not found.'], 404);
        }

        return response()->json(['reservation' => $reservation]);
    }

    /**
     * DELETE /api/special/{id}
     * Batalkan special reservation.
     */
    public function destroy(int $id)
    {
        $reservation = Reservation::where('is_special', true)->find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Special reservation not found.'], 404);
        }

        $reservation->delete();

        Log::info('[SpecialReservationService] Reservation cancelled', ['reservation_id' => $id]);

        return response()->json(['message' => 'Special reservation cancelled successfully.']);
    }
}
