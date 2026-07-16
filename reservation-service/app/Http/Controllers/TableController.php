<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index() {
        $tables = Table::all();
        return response()->json($tables);
    }

    public function store(Request $request) {
        $request->validate([
            'table_number' => 'required|unique:tables',
            'seats' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved',
        ]);

        $table = Table::create($request->all());
        return response()->json([
            'success' => true,
            'table' => $table
        ]);
    }

    public function update(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $table->table_number = $request->table_number;
        $table->seats = $request->seats;

        if (($request->status == 'reserved' || $request->status == 'occupied') && $request->schedule_date && $request->schedule_time) {
            $reservedAt = $request->schedule_date . ' ' . $request->schedule_time;
            Reservation::updateOrCreate(
                [
                    'table_id' => $table->id,
                    'reserved_at' => $reservedAt,
                ],
                [
                    'status' => $request->status,
                    'user_id' => auth()->id() ?? 0
                ]
            );
        } else {
            $table->status = $request->status;
        }

        $table->save();

        return response()->json([
            'success' => true,
            'table' => $table
        ]);
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
