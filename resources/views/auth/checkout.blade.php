<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining - Payment</title>
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
                    <li><a href="{{ route('menu') }}">All Menu</a></li>
                    <li><a href="#">Appetizers</a></li>
                    <li><a href="#">Main Course</a></li>
                    <li><a href="#">Desserts</a></li>
                    <li><a href="#">Beverages</a></li>
                    <li><a href="#">Chef's Special</a></li>
                </ul>
            </div>
            <div class="cart-summary">
                <h4>Your Selection</h4>
                <div class="cart-items-sidebar">
                    <div class="cart-item-sidebar">
                        <div class="cart-item-name">Grilled Salmon</div>
                        <div class="cart-item-price">$42.00</div>
                    </div>
                    <div class="cart-item-sidebar">
                        <div class="cart-item-name">Filet Mignon</div>
                        <div class="cart-item-price">$58.00</div>
                    </div>
                </div>
                <div class="cart-total">
                    <p>Total: <span id="cart-total-amount">$117.00</span></p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <h1>Payment Method</h1>
                <div class="cart-icon">
                    <a href="{{ route('cart') }}">
                        <span class="cart-count">2</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="payment-container">
                <div class="payment-left">
                    <div class="payment-methods">
                        <h2>Select Payment Method</h2>

                        <div class="payment-method-options">
                            <!-- Credit Card -->
                            <label class="payment-option">
                                <input type="radio" name="payment-method" value="credit-card" checked>
                                <div class="payment-option-content">
                                    <div class="payment-icon credit-card-icon">💳</div>
                                    <div class="payment-label">
                                        <span>Credit Card</span>
                                        <small>Visa, Mastercard, American Express</small>
                                    </div>
                                </div>
                            </label>

                            <!-- PayPal -->
                            <label class="payment-option">
                                <input type="radio" name="payment-method" value="paypal">
                                <div class="payment-option-content">
                                    <div class="payment-icon paypal-icon">🅿️</div>
                                    <div class="payment-label">
                                        <span>PayPal</span>
                                        <small>Pay securely with PayPal</small>
                                    </div>
                                </div>
                            </label>

                            <!-- Bank Transfer -->
                            <label class="payment-option">
                                <input type="radio" name="payment-method" value="bank-transfer">
                                <div class="payment-option-content">
                                    <div class="payment-icon bank-icon">🏦</div>
                                    <div class="payment-label">
                                        <span>Bank Transfer</span>
                                        <small>Pay from your bank account</small>
                                    </div>
                                </div>
                            </label>

                            <!-- Cash -->
                            <label class="payment-option">
                                <input type="radio" name="payment-method" value="cash">
                                <div class="payment-option-content">
                                    <div class="payment-icon cash-icon">💵</div>
                                    <div class="payment-label">
                                        <span>Cash on Delivery</span>
                                        <small>Pay when your order arrives</small>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Credit Card Form -->
                        <div class="credit-card-form">
                            <div class="form-group">
                                <label for="card-number">Card Number</label>
                                <input type="text" id="card-number" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="expiry-date">Expiry Date</label>
                                    <input type="text" id="expiry-date" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" placeholder="123">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card-name">Name on Card</label>
                                <input type="text" id="card-name" placeholder="John Doe">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="payment-right">
                    <div class="order-summary">
                        <h2>Order Summary</h2>
                        <div class="order-items">
                            <div class="order-item">
                                <span>Grilled Salmon</span>
                                <span>$42.00</span>
                            </div>
                            <div class="order-item">
                                <span>Filet Mignon</span>
                                <span>$58.00</span>
                            </div>
                        </div>
                        <div class="order-totals">
                            <div class="order-subtotal">
                                <span>Subtotal</span>
                                <span>$100.00</span>
                            </div>
                            <div class="order-service">
                                <span>Service Charge (10%)</span>
                                <span>$10.00</span>
                            </div>
                            <div class="order-tax">
                                <span>Tax (7%)</span>
                                <span>$7.00</span>
                            </div>
                            <div class="order-total">
                                <span>Total</span>
                                <span>$117.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="payment-actions">
                        <a href="{{ route('cart') }}" class="back-to-cart">Back to Cart</a>
                        <button class="complete-order">Complete Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
