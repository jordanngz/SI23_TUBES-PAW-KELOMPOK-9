<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpecialTableService;

class SpecialTableController extends Controller
{
    public function __construct(private SpecialTableService $service) {}

    /**
     * GET /special-table
     * Tampilkan halaman form reservasi meja special.
     */
    public function index()
    {
        return view('user.special-table');
    }

    /**
     * GET /api/special/tables (proxy dari main app ke microservice)
     * Dipanggil via AJAX dari halaman special-table untuk menampilkan meja yang available.
     */
    public function availableTables(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'time'       => 'required',
            'party_size' => 'required|integer|min:6',
        ]);

        $tables = $this->service->getAvailableTables(
            $request->date,
            $request->time,
            (int) $request->party_size
        );

        return response()->json(['tables' => $tables]);
    }

    /**
     * POST /special-table
     * Submit form → kirim ke microservice → simpan ke session → redirect ke /menu
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id'            => 'required|integer|exists:tables,id',
            'date'                => 'required|date|after_or_equal:today',
            'time'                => 'required',
            'event_type'          => 'required|string|max:100',
            'party_size'          => 'required|integer|min:6',
            'decoration_request'  => 'nullable|array',
            'special_request'     => 'nullable|string|max:1000',
            'phone'               => 'required|string|max:20',
            'menu_preference'     => 'required|in:set_menu,a_la_carte',
        ]);

        $reserved_at = $validated['date'] . ' ' . $validated['time'] . ':00';

        $payload = [
            'table_id'           => $validated['table_id'],
            'reserved_at'        => $reserved_at,
            'event_type'         => $validated['event_type'],
            'party_size'         => $validated['party_size'],
            'decoration_request' => implode(', ', $validated['decoration_request'] ?? []),
            'special_request'    => $validated['special_request'] ?? '',
            'phone'              => $validated['phone'],
            'menu_preference'    => $validated['menu_preference'],
        ];

        $result = $this->service->storeTempReservation($payload);

        if (!$result['success']) {
            return back()
                ->withInput()
                ->with('error', $result['message'] ?? 'Gagal memproses reservasi. Coba lagi.');
        }

        // Simpan session_data dari microservice ke session (sama seperti temp_reservation biasa)
        session(['temp_reservation' => $result['session_data']]);

        return redirect()->route('menu')
            ->with('success', 'Special table reserved! Now choose your menu. 🍽️');
    }
}
