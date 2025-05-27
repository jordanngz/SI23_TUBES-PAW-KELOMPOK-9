<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🍽️ Menampilkan halaman menu dengan cart user
    public function viewMenu()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        $products = Product::all();
        return view('auth.menu', compact('cart', 'products'));
    }

    // 🛒 Menampilkan halaman cart
    public function viewCart()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('menu')->with('status', 'Cart is empty.');
        }

        return view('auth.cart', compact('cart'));
    }

    // 💳 Menampilkan halaman checkout
    public function checkout()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('menu')->with('status', 'Cart is empty. Add items first.');
        }

        return view('auth.checkout', compact('cart'));
    }

    // ➕ Menambahkan produk ke cart
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

        return back()->with('success', 'Product added to cart!');
    }

    // ❌ Menghapus item dari cart
    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item removed.');
    }

    // 📦 Kosongkan seluruh isi cart
    public function clearCart()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with('success', 'Cart cleared.');
    }

    // ✅ Update kuantitas produk dalam cart
    public function updateQuantity(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $item->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Quantity updated.');
    }
}
