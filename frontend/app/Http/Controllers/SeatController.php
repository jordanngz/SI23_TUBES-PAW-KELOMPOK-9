<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackendClient;
use App\Models\Table;
use App\Models\Reservation;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $time = $request->input('time', '19:00');
        $partySize = $request->input('party_size', 2);

        $response = BackendClient::request()->get(BackendClient::reservationUrl('/api/seat/available'), [
            'date' => $date,
            'time' => $time,
            'party_size' => $partySize,
        ]);

        $tables = [];
        $userReservation = null;

        if ($response->successful()) {
            $data = $response->json();
            $tables = Table::hydrate($data['tables'] ?? []);
            
            if (!empty($data['userReservation'])) {
                $userReservation = (new Reservation())->forceFill($data['userReservation']);
                if (!empty($data['userReservation']['table'])) {
                    $userReservation->setRelation('table', (new Table())->forceFill($data['userReservation']['table']));
                }
            }
        }

        return view('user.seat', [
            'tables' => $tables,
            'userReservation' => $userReservation,
            'tempReservation' => session('temp_reservation')
        ]);
    }

    public function tempReserve(Request $request)
    {
        $request->validate([
            'table_id' => 'required|integer',
            'reserved_at' => 'required|date',
        ]);

        $response = BackendClient::request()->post(BackendClient::reservationUrl('/api/reserve/temp'), [
            'table_id' => $request->table_id,
            'reserved_at' => $request->reserved_at,
        ]);

        if ($response->status() === 409) {
            return response()->json(['message' => 'This table is already reserved for the selected time.'], 409);
        }

        if ($response->successful() && $response->json('success')) {
            session(['temp_reservation' => $response->json('session_data')]);
            return response()->json(['message' => 'Table temporarily selected.']);
        }

        return response()->json(['message' => 'Failed to temporarily reserve table.'], 500);
    }
}