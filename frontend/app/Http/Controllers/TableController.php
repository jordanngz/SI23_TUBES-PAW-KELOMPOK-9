<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Services\BackendClient;

class TableController extends Controller
{
    public function showTableManagement()
    {
        return redirect()->route('admin.table.management');
    }

    public function index() {
        $response = BackendClient::request()->get(BackendClient::reservationUrl('/api/tables'));
        $tables = [];
        if ($response->successful()) {
            $tables = Table::hydrate($response->json());
        }
        return view('admin.edit-meja', compact('tables'));
    }

    public function store(Request $request) {
        $request->validate([
            'table_number' => 'required',
            'seats' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved',
        ]);

        $response = BackendClient::request()->post(BackendClient::reservationUrl('/api/tables'), $request->all());
        
        if ($response->successful() && $response->json('success')) {
            return back()->with('success', 'Table added successfully.');
        }

        return back()->with('error', 'Failed to add table.');
    }

    public function update(Request $request, $id)
    {
        $response = BackendClient::request()->put(BackendClient::reservationUrl("/api/tables/{$id}"), $request->all());

        if ($response->successful()) {
            return redirect()->route('admin.table.management')->with('success', 'Table updated!');
        }

        return back()->with('error', 'Failed to update table.');
    }

    public function destroy($id)
    {
        $response = BackendClient::request()->delete(BackendClient::reservationUrl("/api/tables/{$id}"));

        if ($response->successful()) {
            return redirect()->route('admin.table.management')->with('success', 'Meja berhasil dihapus.');
        }

        return back()->with('error', 'Failed to delete table.');
    }
}
