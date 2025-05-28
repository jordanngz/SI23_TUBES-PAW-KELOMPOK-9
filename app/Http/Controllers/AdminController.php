<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', compact('role'));
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