<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendClient;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
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
        return $order;
    }

    public function index()
    {
        // Get all orders from cart-service
        $ordResponse = BackendClient::request()->get(BackendClient::cartUrl('/api/admin/orders'));
        $orders = [];
        if ($ordResponse->successful()) {
            $orders = collect($ordResponse->json())->map(fn($o) => $this->hydrateOrder($o));
        }

        // Get all products from menu-service for the create order form
        $prodResponse = BackendClient::request()->get(BackendClient::menuUrl('/api/products'));
        $products = [];
        if ($prodResponse->successful()) {
            $products = Product::hydrate($prodResponse->json());
        }

        return view('admin.order', compact('orders', 'products'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_process,done'
        ]);
        
        $response = BackendClient::request()->patch(BackendClient::cartUrl("/api/admin/orders/{$id}/status"), [
            'status' => $request->status
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.order')->with('success', 'Order status updated!');
        }

        return back()->with('error', 'Failed to update order status.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string',
            'table_number' => 'nullable|string',
            'selected_products' => 'required|array',
            'quantities' => 'required|array',
            'note' => 'nullable|string',
        ]);

        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/admin/orders'), $request->all());

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('admin.order')->with('success', 'Order berhasil dicatat!');
        }

        return back()->with('error', 'Failed to save order.');
    }
}