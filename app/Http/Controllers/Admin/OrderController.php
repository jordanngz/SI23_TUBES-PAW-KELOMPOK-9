<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->orderBy('created_at', 'desc')->get();
        $products = Product::all();
        return view('admin.order', compact('orders', 'products'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_process,done'
        ]);
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.order')->with('success', 'Order status updated!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'table_number' => 'nullable|string|max:10',
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'note' => 'nullable|string',
        ]);

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'note' => $request->note,
            'status' => 'pending',
        ]);

        foreach ($request->selected_products as $productId) {
            $qty = $request->quantities[$productId] ?? 1;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $qty,
            ]);
        }

        return redirect()->route('admin.order')->with('success', 'Order berhasil dicatat!');
    }

}