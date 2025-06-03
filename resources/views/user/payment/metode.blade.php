<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining - Payment</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylecart.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

.cart-items-sidebar {
    flex-grow: 1;
    margin-bottom: 1rem;
}

.cart-item-sidebar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #333;
}

.cart-item-name {
    font-size: 0.9rem;
    margin-bottom: 0.2rem;
}

.cart-item-price {
    font-size: 0.85rem;
    color: #e0c080;
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

/* Cart Page Styles */
.cart-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.cart-header {
    display: grid;
    grid-template-columns: 3fr 1fr 1fr 1fr 0.5fr;
    padding: 1.5rem;
    background-color: #f5f5f5;
    font-weight: 500;
    border-bottom: 1px solid #eee;
}

.cart-item {
    display: grid;
    grid-template-columns: 3fr 1fr 1fr 1fr 0.5fr;
    padding: 1.5rem;
    align-items: center;
    border-bottom: 1px solid #eee;
}

.cart-item-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.cart-item-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-details h3 {
    font-size: 1.1rem;
    margin-bottom: 0.3rem;
}

.cart-item-details p {
    font-size: 0.9rem;
    color: #666;
}

.cart-item-quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #ddd;
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.2rem;
    transition: all 0.3s;
}

.quantity-btn:hover {
    background-color: #f5f5f5;
}

.quantity-value {
    font-size: 1rem;
    width: 30px;
    text-align: center;
}

.cart-item-price, .cart-item-total {
    font-weight: 500;
}

.remove-item {
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    transition: color 0.3s;
}

.remove-item:hover {
    color: #e74c3c;
}

.cart-summary-container {
    padding: 1.5rem;
    background-color: #f9f9f9;
}

.cart-summary-details {
    max-width: 400px;
    margin-left: auto;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #eee;
}

.summary-row.total {
    font-weight: 600;
    font-size: 1.2rem;
    color: #333;
    border-bottom: none;
    margin-top: 1rem;
}

.cart-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
}

.continue-shopping {
    padding: 0.8rem 1.5rem;
    background-color: #fff;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.continue-shopping:hover {
    background-color: #f5f5f5;
}

.checkout-btn {
    padding: 0.8rem 1.5rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s;
}

.checkout-btn:hover {
    background-color: #d4b06e;
}

/* Payment Page Styles */
.payment-container {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 2rem;
}

.payment-left, .payment-right {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.payment-methods h2, .order-summary h2 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #333;
}

.payment-method-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.payment-option {
    display: flex;
    cursor: pointer;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-option-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 100%;
    transition: all 0.3s;
}

.payment-option input[type="radio"]:checked + .payment-option-content {
    border-color: #e0c080;
    background-color: rgba(224, 192, 128, 0.05);
}

.payment-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    border-radius: 8px;
}

.payment-label {
    display: flex;
    flex-direction: column;
}

.payment-label span {
    font-weight: 500;
}

.payment-label small {
    color: #666;
    font-size: 0.8rem;
}

.credit-card-form {
    margin-top: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: #666;
}

.form-group input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
}

.order-items {
    margin-bottom: 2rem;
}

.order-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #eee;
}

.order-totals {
    border-top: 1px solid #ddd;
    padding-top: 1rem;
}

.order-subtotal, .order-service, .order-tax {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    color: #666;
}

.order-total {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #ddd;
    font-weight: 600;
    font-size: 1.2rem;
}

.payment-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
}

.back-to-cart {
    padding: 0.8rem 1.5rem;
    background-color: #fff;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.back-to-cart:hover {
    background-color: #f5f5f5;
}

.complete-order {
    padding: 0.8rem 1.5rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.complete-order:hover {
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
    
    .payment-container {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .cart-header, .cart-item {
        grid-template-columns: 2fr 1fr 1fr 0.5fr;
    }
    
    .cart-header-price, .cart-item-price {
        display: none;
    }
    
    .header h1 {
        font-size: 1.8rem;
    }
}

@media (max-width: 576px) {
    .cart-header, .cart-item {
        grid-template-columns: 2fr 1fr 0.5fr;
    }
    
    .cart-header-total, .cart-item-total {
        display: none;
    }
    
    .main-content {
        padding: 1rem;
    }
    
    .header h1 {
        font-size: 1.5rem;
    }
    
    .cart-actions, .payment-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .continue-shopping, .back-to-cart, .checkout-btn, .complete-order {
        width: 100%;
        text-align: center;
    }
}   
</style>
<body>
<div class="sidebar">
    <div class="logo"><h3>Kerapu Fine Dining</h3></div>
    <div class="menu-categories">
        <h4>Menu Categories</h4>
        <ul>
            <li class="backlink"><a href="{{ route('reserve') }}">Back to Seat Selection</a></li>
            <li><a href="{{ route('menu') }}">All Menu</a></li>
        </ul>
    </div>
    <div class="cart-summary">
        <h4>Your Selection</h4>
        <div class="cart-items-sidebar">
            @foreach($transaction->items as $item)
                <div class="cart-item-sidebar">
                    <div class="cart-item-name">{{ $item->product->name }}</div>
                    <div class="cart-item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
            @endforeach
        </div>
        <div class="cart-total">
            <p>Total: <span>${{ number_format($transaction->total, 2) }}</span></p>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="header">
        <h1>Payment Method</h1>
    </div>

    <div class="payment-container">
        <div class="payment-left">
            <h2>Select Payment Method</h2>
            <div class="payment-method-options">
                <label class="payment-option">
                    <input type="radio" name="payment-method" value="credit">
                    <div class="payment-option-content">
                        <div class="payment-icon">💳</div>
                        <div class="payment-label">
                            <span>Credit Card</span>
                            <small>Visa, Mastercard</small>
                        </div>
                    </div>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment-method" value="dana">
                    <div class="payment-option-content">
                        <div class="payment-icon">🅿️</div>
                        <div class="payment-label">
                            <span>Dana</span>
                            <small>Via Dana App</small>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <div class="payment-right">
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="order-items">
                    @foreach ($transaction->items as $item)
                        <div class="order-item">
                            <span>{{ $item->product->name }}</span>
                            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="order-totals">
                    <div><span>Subtotal</span><span>${{ number_format($transaction->subtotal, 2) }}</span></div>
                    <div><span>Service (10%)</span><span>${{ number_format($transaction->service_charge, 2) }}</span></div>
                    <div><span>Tax (7%)</span><span>${{ number_format($transaction->tax, 2) }}</span></div>
                    <div><strong>Total</strong><strong>${{ number_format($transaction->total, 2) }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="payment-actions">
        <a href="{{ route('cart') }}" class="back-to-cart">Back to Cart</a>
        <button class="complete-order">Continue</button>
    </div>

    <form id="payment-method-form" method="POST" action="">
        @csrf
        <input type="hidden" name="payment_method" id="payment-method">
        <input type="hidden" name="transaction_code" id="transaction-code" value="{{ $transaction->transaction_code }}">
    </form>
</div>

<script>
    document.querySelector('.complete-order').addEventListener('click', function () {
        const selected = document.querySelector('input[name="payment-method"]:checked');
        if (!selected) {
            alert("Please select a payment method first.");
            return;
        }

        const method = selected.value;
        const form = document.getElementById('payment-method-form');
        const code = document.getElementById('transaction-code').value;

        document.getElementById('payment-method').value = method;

        if (method === 'credit') {
            form.action = "{{ route('payment.update.credit') }}";
        } else if (method === 'dana') {
            form.action = "{{ route('payment.update.dana') }}";
        }

        form.submit();
    });
</script>
</body>
</html>
