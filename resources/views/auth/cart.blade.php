<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining - Your Cart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylecart.css') }}">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h3>Kerapu Fine Dining</h3>
        </div>
        <div class="menu-categories">
            <h4>Menu Categories</h4>
            <ul>
                <li class="backlink"><a href="{{ route('reserve') }}">Back to Seat Selection</a></li>
                <li><a href="{{ route('menu') }}">All Menu</a></li>
                <li><a href="#">Appetizers</a></li>
                <li><a href="#">Main Course</a></li>
                <li><a href="#">Desserts</a></li>
                <li><a href="#">Beverages</a></li>
            </ul>
        </div>
        <div class="cart-summary">
            <h4>Your Selection</h4>
            <div class="cart-items-sidebar">
                @forelse($cart->items as $item)
                    <div class="cart-item-sidebar">
                        <div class="cart-item-name">{{ $item->product->name }}</div>
                        <div class="cart-item-price">${{ $item->product->price }}</div>
                    </div>
                @empty
                    <p class="empty-cart">Your cart is empty</p>
                @endforelse
            </div>
            <div class="cart-total">
                <p>Total:
                    <span id="cart-total-amount">
                        ${{ number_format($cart->items->sum(fn($i) => $i->quantity * $i->product->price), 2) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="menu-toggle">
                <span></span><span></span><span></span>
            </div>
            <h1>Your Cart</h1>
            <a href="{{ route('cart') }}" class="cart-icon">
                <span class="cart-count">{{ $cart->items->sum('quantity') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
            </a>
        </div>

        <div class="cart-container">
            <div class="cart-header">
                <div class="cart-header-item">Item</div>
                <div class="cart-header-price">Price</div>
                <div class="cart-header-quantity">Quantity</div>
                <div class="cart-header-total">Total</div>
            </div>

            @forelse($cart->items as $item)
                <div class="cart-item">
                    <div class="cart-item-info">
                        <div class="cart-item-image">
                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $item->product->name }}">
                        </div>
                        <div class="cart-item-details">
                            <h3>{{ $item->product->name }}</h3>
                            <p>{{ $item->product->description }}</p>
                        </div>
                    </div>
                    <div class="cart-item-price">${{ $item->product->price }}</div>
                    <div class="cart-item-quantity-control">
                        <span class="quantity-value">{{ $item->quantity }}</span>
                    </div>
                    <div class="cart-item-total">${{ number_format($item->quantity * $item->product->price, 2) }}</div>
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="remove-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" stroke="currentColor">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <p style="margin: 2rem 0;">Your cart is empty.</p>
            @endforelse

            <div class="cart-summary-container">
                <div class="cart-summary-details">
                    @php
                        $subtotal = $cart->items->sum(fn($i) => $i->quantity * $i->product->price);
                        $service = $subtotal * 0.10;
                        $tax = $subtotal * 0.07;
                        $total = $subtotal + $service + $tax;
                    @endphp

                    <div class="summary-row"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span></div>
                    <div class="summary-row"><span>Service Charge (10%)</span><span>${{ number_format($service, 2) }}</span></div>
                    <div class="summary-row"><span>Tax (7%)</span><span>${{ number_format($tax, 2) }}</span></div>
                    <div class="summary-row total"><span>Total</span><span>${{ number_format($total, 2) }}</span></div>
                </div>
                <div class="cart-actions">
                    <a href="{{ route('menu') }}" class="continue-shopping">Continue Shopping</a>

                <form method="POST" action="{{ route('payment.submit') }}">
                    @csrf
                    <input type="hidden" name="payment_method" value="none">
                    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
