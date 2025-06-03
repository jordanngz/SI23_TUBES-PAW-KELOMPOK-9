<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function index()
    {
        // Total Orders
        $totalOrders = Order::count();

        // Total Revenue
        $totalRevenue = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(order_items.quantity * products.price) as total'))
            ->value('total') ?? 0;

        // Total Visitors (misal: jumlah customer unik hari ini)
        $totalVisitors = Order::whereDate('created_at', Carbon::today())->distinct('customer_name')->count('customer_name');

        // Best Seller
        $bestSeller = Product::select(
                'products.id',
                'products.name',
                'products.price',
                'products.description',
                'products.image',
                DB::raw('SUM(order_items.quantity) as sold')
            )
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.description', 'products.image')
            ->orderByDesc('sold')
            ->first();

        // Top 5 Menu
        $topMenus = Product::select(
                'products.id',
                'products.name',
                'products.price',
                'products.description',
                'products.image',
                DB::raw('SUM(order_items.quantity) as sold'),
                DB::raw('SUM(order_items.quantity * products.price) as revenue')
            )
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.description', 'products.image')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();

        // Revenue Chart (7 hari terakhir)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $label = $date->format('d M');
            $chartLabels[] = $label;
            $revenue = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                ->whereDate('order_items.created_at', $date)
                ->select(DB::raw('SUM(order_items.quantity * products.price) as total'))
                ->value('total') ?? 0;
            $chartData[] = $revenue;
        }

        // Order History (10 terakhir)
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($order) {
                $order->total = $order->items->sum(function($item) {
                    return $item->quantity * ($item->product->price ?? 0);
                });
                return $order;
            });

        return view('admin.report', compact(
            'totalOrders', 'totalRevenue', 'totalVisitors', 'bestSeller', 'topMenus', 'orders', 'chartLabels', 'chartData'
        ));
    }
}