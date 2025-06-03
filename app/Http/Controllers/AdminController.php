<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Contoh data dinamis, sesuaikan dengan struktur tabel di project kamu
        $today = now()->toDateString();

        $todayReservations = \DB::table('reservations')->whereDate('created_at', $today)->count();
        $tablesReserved = \DB::table('tables')->where('status', 'reserved')->count();
        $tablesAvailable = \DB::table('tables')->where('status', 'available')->count();
        $visitorsToday = \DB::table('orders')->whereDate('created_at', $today)->distinct('customer_name')->count('customer_name');
        $revenueToday = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereDate('order_items.created_at', $today)
            ->select(\DB::raw('SUM(order_items.quantity * products.price) as total'))
            ->value('total') ?? 0;

        return view('admin.index', compact(
            'todayReservations',
            'tablesReserved',
            'tablesAvailable',
            'visitorsToday',
            'revenueToday'
        ));
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

    public function logout()
    {
        Auth::logout();
        return redirect('/'); // redirect ke home
    }
    
}