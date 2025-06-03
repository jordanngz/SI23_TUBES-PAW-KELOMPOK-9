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
<style>
    /* Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    color: #333;
    background-color: #f9f9f9;
    line-height: 1.6;
}

h1, h2, h3, h4 {
    font-family: 'Playfair Display', serif;
    font-weight: 600;
}

.container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar Styles */
.sidebar {
    width: 300px;
    background-color: #1a1a1a;
    color: #fff;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
}

.logo {
    margin-bottom: 2rem;
    text-align: center;
}

.logo h3 {
    font-size: 1.5rem;
    color: #e0c080;
    letter-spacing: 1px;
}

.menu-categories h4 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #e0c080;
}

.menu-categories ul {
    list-style: none;
}

.menu-categories li {
    margin-bottom: 0.8rem;
}

.menu-categories a {
    color: #fff;
    text-decoration: none;
    font-size: 0.95rem;
    display: block;
    padding: 0.5rem 0;
    transition: color 0.3s;
}

.menu-categories a:hover {
    color: #e0c080;
}

.menu-categories li.active a {
    color: #e0c080;
    font-weight: 500;
}

.cart-summary {
    margin-top: 2rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.cart-summary h4 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #e0c080;
}

.cart-items {
    flex-grow: 1;
    margin-bottom: 1rem;
    min-height: 100px;
}

.empty-cart {
    color: #999;
    font-style: italic;
    font-size: 0.9rem;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #333;
}

.cart-item-details {
    flex-grow: 1;
}

.cart-item-name {
    font-size: 0.9rem;
    margin-bottom: 0.2rem;
}

.cart-item-price {
    font-size: 0.85rem;
    color: #e0c080;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
}

.quantity-btn {
    background: none;
    border: none;
    color: #fff;
    font-size: 1rem;
    cursor: pointer;
    padding: 0 0.5rem;
}

.quantity-value {
    margin: 0 0.5rem;
}

.cart-total {
    margin-top: auto;
    border-top: 1px solid #333;
    padding-top: 1rem;
}

.cart-total p {
    display: flex;
    justify-content: space-between;
    font-weight: 500;
    margin-bottom: 1rem;
}

.checkout-btn {
    width: 100%;
    padding: 0.8rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.checkout-btn:hover {
    background-color: #d4b06e;
}

/* Main Content Styles */
.main-content {
    flex-grow: 1;
    margin-left: 300px;
    padding: 2rem;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    cursor: pointer;
}

.menu-toggle span {
    height: 3px;
    width: 100%;
    background-color: #333;
    border-radius: 3px;
}

.header h1 {
    font-size: 2.2rem;
    color: #333;
}

.cart-icon {
    position: relative;
    cursor: pointer;
}

.cart-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: #e0c080;
    color: #1a1a1a;
    font-size: 0.75rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.category-title {
    margin-bottom: 2rem;
}

.category-title h2 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.category-title p {
    color: #666;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.menu-item {
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.menu-image {
    height: 200px;
    overflow: hidden;
}

.menu-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.menu-item:hover .menu-image img {
    transform: scale(1.05);
}

.menu-details {
    padding: 1.5rem;
}

.menu-details h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.menu-details p {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    min-height: 2.8rem;
}

.menu-price-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-weight: 500;
    color: #333;
    font-size: 1.1rem;
}

.add-to-cart {
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s;
}

.add-to-cart:hover {
    background-color: #d4b06e;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
    }

    .main-content {
        margin-left: 0;
    }

    .menu-toggle {
        display: flex;
    }

    /* This class would be toggled with JavaScript */
    .sidebar.active {
        transform: translateX(0);
    }
}

@media (max-width: 768px) {
    .menu-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .header h1 {
        font-size: 1.8rem;
    }
}

@media (max-width: 576px) {
    .menu-grid {
        grid-template-columns: 1fr;
    }

    .main-content {
        padding: 1rem;
    }

    .header h1 {
        font-size: 1.5rem;
    }
}

.menu-categories li.backlink a {
    color: #e0c080;
    font-weight: 500;
}

.menu-categories li.backlink a:hover {
    text-decoration: underline;
}

</style>
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
                    <a href="{{ route('cart') }}" class="checkout-btn">Proceed to checkout</a>
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
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/300" alt="{{ $product->name }}">
                            @endif
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
