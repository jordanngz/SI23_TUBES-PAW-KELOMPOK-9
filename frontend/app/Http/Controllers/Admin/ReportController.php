<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendClient;
use App\Models\Product;
use App\Models\Order;

class ReportController extends Controller
{
    private function hydrateOrder($orderData)
    {
        if (!$orderData) return null;
        
        $itemsData = $orderData['items'] ?? [];
        unset($orderData['items']);
        
        $order = (new Order())->forceFill($orderData);
        $items = collect($itemsData)->map(function ($itemData) {
            $item = (new \App\Models\OrderItem())->forceFill($itemData);
            if (!empty($itemData['product'])) {
                $item->setRelation('product', (new Product())->forceFill($itemData['product']));
            }
            return $item;
        });
        $order->setRelation('items', $items);
        $order->total = $orderData['total'] ?? 0;
        return $order;
    }

    public function index()
    {
        $response = BackendClient::request()->get(BackendClient::cartUrl('/api/admin/reports'));
        
        $totalOrders = 0;
        $totalRevenue = 0;
        $totalVisitors = 0;
        $bestSeller = null;
        $topMenus = collect();
        $orders = collect();
        $chartLabels = [];
        $chartData = [];

        if ($response->successful()) {
            $data = $response->json();
            $totalOrders = $data['totalOrders'] ?? 0;
            $totalRevenue = $data['totalRevenue'] ?? 0;
            $totalVisitors = $data['totalVisitors'] ?? 0;
            
            if (!empty($data['bestSeller'])) {
                $bestSeller = (new Product())->forceFill($data['bestSeller']);
                $bestSeller->sold = $data['bestSeller']['sold'] ?? 0;
            }
            
            if (!empty($data['topMenus'])) {
                $topMenus = collect($data['topMenus'])->map(function($m) {
                    $prod = (new Product())->forceFill($m);
                    $prod->sold = $m['sold'] ?? 0;
                    $prod->revenue = $m['revenue'] ?? 0;
                    return $prod;
                });
            }
            
            if (!empty($data['orders'])) {
                $orders = collect($data['orders'])->map(fn($o) => $this->hydrateOrder($o));
            }
            
            $chartLabels = $data['chartLabels'] ?? [];
            $chartData = $data['chartData'] ?? [];
        }

        return view('admin.report', compact(
            'totalOrders', 'totalRevenue', 'totalVisitors', 'bestSeller', 'topMenus', 'orders', 'chartLabels', 'chartData'
        ));
    }
}