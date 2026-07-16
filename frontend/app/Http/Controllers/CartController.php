<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackendClient;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Transaction;

class CartController extends Controller
{
    private function hydrateCart($cartData)
    {
        if (!$cartData) return null;
        
        $itemsData = $cartData['items'] ?? [];
        unset($cartData['items']);
        
        $cart = (new Cart())->forceFill($cartData);
        
        $items = collect($itemsData)->map(function ($itemData) {
            $item = (new CartItem())->forceFill($itemData);
            if (!empty($itemData['product'])) {
                $product = (new Product())->forceFill($itemData['product']);
                $item->setRelation('product', $product);
            }
            return $item;
        });
        
        $cart->setRelation('items', $items);
        return $cart;
    }

    public function viewMenu()
    {
        // Get cart
        $cartResponse = BackendClient::request()->get(BackendClient::cartUrl('/api/cart'));
        $cart = $this->hydrateCart($cartResponse->json());

        // Get products
        $prodResponse = BackendClient::request()->get(BackendClient::menuUrl('/api/products'));
        $products = [];
        if ($prodResponse->successful()) {
            $products = Product::hydrate($prodResponse->json());
        }

        return view('user.checkout.menu', compact('cart', 'products'));
    }

    public function viewCart()
    {
        $cartResponse = BackendClient::request()->get(BackendClient::cartUrl('/api/cart'));
        $cart = $this->hydrateCart($cartResponse->json());

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('menu')->with('status', 'Cart is empty.');
        }

        return view('user.checkout.cart', compact('cart'));
    }

    public function checkout()
    {
        $cartResponse = BackendClient::request()->get(BackendClient::cartUrl('/api/cart'));
        $cart = $this->hydrateCart($cartResponse->json());

        $transactionId = session('transaction_id');
        $transaction = null;
        if ($transactionId) {
            // Note: checkout can load transaction via cart-service API
            $txResponse = BackendClient::request()->get(BackendClient::cartUrl("/api/admin/transactions/{$transactionId}"));
            if ($txResponse->successful()) {
                $txData = $txResponse->json();
                $itemsData = $txData['items'] ?? [];
                unset($txData['items']);
                
                $transaction = (new Transaction())->forceFill($txData);
                $items = collect($itemsData)->map(function ($itemData) {
                    $item = (new \App\Models\TransactionItem())->forceFill($itemData);
                    if (!empty($itemData['product'])) {
                        $item->setRelation('product', (new Product())->forceFill($itemData['product']));
                    }
                    return $item;
                });
                $transaction->setRelation('items', $items);
            }
        }

        return view('user.payment.metode', compact('cart', 'transaction'));
    }

    public function add(Product $product)
    {
        $response = BackendClient::request()->post(BackendClient::cartUrl("/api/cart/add/{$product->id}"));
        return back()->with('success', $response->json('message', 'Product added to cart!'));
    }

    public function remove(CartItem $item)
    {
        $response = BackendClient::request()->post(BackendClient::cartUrl("/api/cart/remove/{$item->id}"));
        return back()->with('success', $response->json('message', 'Item removed.'));
    }

    public function clearCart()
    {
        $response = BackendClient::request()->post(BackendClient::cartUrl('/api/cart/clear'));
        return back()->with('success', $response->json('message', 'Cart cleared.'));
    }

    public function updateQuantity(Request $request, CartItem $item)
    {
        $response = BackendClient::request()->post(BackendClient::cartUrl("/api/cart/update-quantity/{$item->id}"), [
            'quantity' => $request->quantity
        ]);
        return back()->with('success', $response->json('message', 'Quantity updated.'));
    }
}
