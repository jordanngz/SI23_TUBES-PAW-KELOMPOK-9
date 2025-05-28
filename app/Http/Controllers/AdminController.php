<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Table;

class AdminController extends Controller
{
    public function tableManagement()
    {
        $tables = Table::all();
        return view('admin.table-management', compact('tables'));
    }


    public function index()
    {
        return view('admin.index');
    }
    public function updateRole(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,'
        ]);
        
        auth()->user()->update([
            'role' => $validated['role']
        ]);
        
        return back()->with('success', 'Role berhasil diubah');
    }
    
}