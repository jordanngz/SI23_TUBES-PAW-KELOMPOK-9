<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{

    public function showTableManagement()
    {
        return view('admin.table-management');
    }

    public function index() {
        $tables = Table::all();
        return view('admin.edit-meja', compact('tables'));
    }

    public function store(Request $request) {
        $request->validate([
            'table_number' => 'required|unique:tables',
            'seats' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved',
        ]);

        Table::create($request->all());
        return back()->with('success', 'Table added successfully.');
    }

    public function update(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        // Update data dasar
        $table->table_number = $request->table_number;
        $table->seats = $request->seats;

        // Jika status diubah dan ada tanggal & jam, buat/ubah reservasi
        if (($request->status == 'reserved' || $request->status == 'occupied') && $request->schedule_date && $request->schedule_time) {
            $reservedAt = $request->schedule_date . ' ' . $request->schedule_time;
            \App\Models\Reservation::updateOrCreate(
                [
                    'table_id' => $table->id,
                    'reserved_at' => $reservedAt,
                ],
                [
                    'status' => $request->status,
                    'user_id' => auth()->id() // atau null/admin
                ]
            );
        } else {
            // Jika status global diubah tanpa jadwal, update status global
            $table->status = $request->status;
        }

        $table->save();

        return redirect()->route('admin.table.management')->with('success', 'Table updated!');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('admin.table.management')->with('success', 'Meja berhasil dihapus.');
    }

}
