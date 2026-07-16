<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BackendClient;

class UserController extends Controller
{
    public function index()
    {
        $response = BackendClient::request()->get(BackendClient::authUrl('/api/users'));
        $users = [];
        if ($response->successful()) {
            $users = User::hydrate($response->json());
        }
        return view('admin.user-management', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:admin,waiter,cashier,user',
            'password' => 'required|string|min:6',
        ]);
        
        $response = BackendClient::request()->post(BackendClient::authUrl('/api/users'), $request->all());
        
        if ($response->successful() && $response->json('success')) {
            return redirect()->route('admin.users')->with('success', 'User added!');
        }
        
        return back()->with('error', $response->json('message') ?? 'Failed to add user.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:admin,waiter,cashier,user',
        ]);
        
        $response = BackendClient::request()->put(BackendClient::authUrl("/api/users/{$id}"), $request->all());
        
        if ($response->successful() && $response->json('success')) {
            return redirect()->route('admin.users')->with('success', 'User updated!');
        }
        
        return back()->with('error', $response->json('message') ?? 'Failed to update user.');
    }

    public function destroy($id)
    {
        $response = BackendClient::request()->delete(BackendClient::authUrl("/api/users/{$id}"));
        
        if ($response->successful()) {
            return redirect()->route('admin.users')->with('success', 'User deleted!');
        }
        
        return back()->with('error', 'Failed to delete user.');
    }
}