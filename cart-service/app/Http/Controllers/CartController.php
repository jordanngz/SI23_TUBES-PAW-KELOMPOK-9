<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // API 🍽️ Get cart structure
    public function getCart()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cart = $user->cart()->with('items.product')->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        return response()->json($cart);
    }

    // API ➕ Add product to cart
    public function add(Product $product)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart' => $cart->load('items.product')
        ]);
    }

    // API ❌ Remove item from cart
    public function remove($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();
        return response()->json([
            'success' => true,
            'message' => 'Item removed.'
        ]);
    }

    // API 📦 Clear cart
    public function clearCart()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared.'
        ]);
    }

    // API ✅ Update quantity
    public function updateQuantity(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $item = CartItem::findOrFail($id);
        $item->update(['quantity' => $request->quantity]);
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated.'
        ]);
    }
}
