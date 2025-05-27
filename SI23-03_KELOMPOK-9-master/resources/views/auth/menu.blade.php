<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining - Menu</title>

    <!-- Fonts & CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylemenu.css') }}">
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
                    <li class="active"><a href="#">All Menu</a></li>
                    <li><a href="#">Appetizers</a></li>
                    <li><a href="#">Main Course</a></li>
                    <li><a href="#">Desserts</a></li>
                    <li><a href="#">Beverages</a></li>
                </ul>
            </div>
            <div class="cart-summary">
                <h4>Your Selection</h4>
                <div class="cart-items">
                    @if($cart && $cart->items->count())
                        @foreach($cart->items as $item)
                            <div class="cart-item">
                                <div class="cart-item-details">
                                    <div class="cart-item-name">{{ $item->product->name }}</div>
                                    <div class="cart-item-price">${{ $item->product->price }}</div>
                                </div>
                                <div class="cart-item-quantity">Qty: {{ $item->quantity }}</div>
                            </div>
                        @endforeach
                    @else
                        <p class="empty-cart">Your cart is empty</p>
                    @endif
                </div>

                <div class="cart-total">
                    <p>Total: 
                        <span id="cart-total-amount">
                            ${{ $cart ? number_format($cart->items->sum(fn($i) => $i->quantity * $i->product->price), 2) : '0.00' }}
                        </span>
                    </p>
                    <a href="{{ route('checkout') }}" class="checkout-btn">Proceed to Checkout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->

        <div class="main-content">
            <div class="header">
                <div class="menu-toggle">
                    <span></span><span></span><span></span>
                </div>
                <h1>Our Exquisite Menu</h1>
                <a href="{{ route('cart') }}" class="cart-icon">
                    <span class="cart-count">{{ $cart ? $cart->items->sum('quantity') : 0 }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </a>
            </div>

            <div class="category-title">
                <h2>All Menu</h2>
                <p>Discover our carefully curated selection of culinary masterpieces</p>
            </div>

            <div class="menu-grid">
                @foreach($products as $product)
                    <div class="menu-item">
                        <div class="menu-image">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}">
                        </div>
                        <div class="menu-details">
                            <h3>{{ $product->name }}</h3>
                            <p>{{ $product->description }}</p>
                            <div class="menu-price-action">
                                <span class="price">${{ $product->price }}</span>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="add-to-cart">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
