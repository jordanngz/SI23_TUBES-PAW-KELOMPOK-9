<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BackendClient;

class AdminController extends Controller
{
    public function tableManagement()
    {
        // Call reservation-service to get all tables
        $response = BackendClient::request()->get(BackendClient::reservationUrl('/api/tables'));
        $tables = [];
        if ($response->successful()) {
            $tables = \App\Models\Table::hydrate($response->json());
        }
        return view('admin.table-management', compact('tables'));
    }

    public function index()
    {
        // Fetch reservation/table stats from reservation-service
        $resResponse = BackendClient::request()->get(BackendClient::reservationUrl('/api/admin/stats'));
        $resStats = $resResponse->json() ?? [];

        // Fetch order/revenue stats from cart-service
        $cartResponse = BackendClient::request()->get(BackendClient::cartUrl('/api/admin/stats'));
        $cartStats = $cartResponse->json() ?? [];

        $todayReservations = $resStats['todayReservations'] ?? 0;
        $tablesReserved = $resStats['tablesReserved'] ?? 0;
        $tablesAvailable = $resStats['tablesAvailable'] ?? 0;
        
        $visitorsToday = $cartStats['visitorsToday'] ?? 0;
        $revenueToday = $cartStats['revenueToday'] ?? 0;

        return view('admin.index', compact(
            'todayReservations',
            'tablesReserved',
            'tablesAvailable',
            'visitorsToday',
            'revenueToday'
        ));
    }

    public function logout()
    {
        BackendClient::request()->post(BackendClient::authUrl('/api/logout'));
        session()->forget('user');
        return redirect('/');
    }
}