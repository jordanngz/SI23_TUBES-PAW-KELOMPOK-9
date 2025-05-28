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

    public function update(Request $request, Table $table) {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number,' . $table->id,
            'seats' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved',
        ]);

        $table->update($request->all());
        return back()->with('success', 'Table updated successfully.');
    }

    public function destroy(Table $table) {
        $table->delete();
        return back()->with('success', 'Table deleted successfully.');
    }
}
