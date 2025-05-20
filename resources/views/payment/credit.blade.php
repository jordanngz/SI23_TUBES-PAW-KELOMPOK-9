<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining - Credit Card Payment</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bayar.css') }}">
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
                    <li><a href="#">All Menu</a></li>
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
                <h1>Credit Card Payment</h1>
                <div class="cart-icon">
                    <a href="#">
                        <span class="cart-count">2</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="payment-summary">
                <h2>Order Summary</h2>
                <div class="order-items">
                    @foreach ($cart->items as $item)
                        <div class="order-item">
                            <span>{{ $item->product->name }}</span>
                            <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                @php
                    $subtotal = $cart->items->sum(function($item) {
                        return $item->product->price * $item->quantity;
                    });
                    $serviceCharge = $subtotal * 0.10;
                    $tax = $subtotal * 0.07;
                    $total = $subtotal + $serviceCharge + $tax;
                @endphp

                <div class="order-totals">
                    <div class="order-subtotal">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="order-service">
                        <span>Service Charge (10%)</span>
                        <span>${{ number_format($serviceCharge, 2) }}</span>
                    </div>
                    <div class="order-tax">
                        <span>Tax (7%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="order-total">
                        <span>Total</span>
                        <span><strong>${{ number_format($total, 2) }}</strong></span>
                    </div>
                </div>

                </div>
                <button class="pay-button" id="credit-card-pay">Pay with Credit Card</button>
            </div>

            <!-- PIN Modal -->
            <div class="modal" id="pin-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Enter PIN</h2>
                        <span class="close-modal">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div class="pin-input-container">
                            <input type="password" maxlength="1" class="pin-input">
                            <input type="password" maxlength="1" class="pin-input">
                            <input type="password" maxlength="1" class="pin-input">
                            <input type="password" maxlength="1" class="pin-input">
                            <input type="password" maxlength="1" class="pin-input">
                            <input type="password" maxlength="1" class="pin-input">
                        </div>
                        <button class="submit-pin">Submit</button>
                    </div>
                </div>
            </div>

            <!-- Success Modal -->
            <div class="success-modal" id="success-modal">
                <div class="success-content">
                    <div class="success-header">
                        <h2>Payment Status</h2>
                    </div>
                    <div class="success-body">
                        <div class="success-icon">
                            <div class="coin"></div>
                        </div>
                        <h2>Payment Success!</h2>
                        <p>Transaction paid successfully with</p>
                        <p class="payment-method">Credit Card</p>
                        
                        <div class="amount-container">
                            <div class="amount">$117.00</div>
                            <div class="view-detail">View Detail <span>&#9662;</span></div>
                        </div>
                        
                        <p class="transaction-info">You can access this information in Transaction History.</p>
                        
                        <button class="view-transaction">VIEW TRANSACTION</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show PIN modal when pay button is clicked
        document.getElementById('credit-card-pay').addEventListener('click', function() {
            document.getElementById('pin-modal').style.display = 'flex';
        });

        // Close modal when X is clicked
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('pin-modal').style.display = 'none';
        });

        // Show success modal when PIN is submitted
        document.querySelector('.submit-pin').addEventListener('click', function() {
            document.getElementById('pin-modal').style.display = 'none';
            document.getElementById('success-modal').style.display = 'flex';
        });

        // Auto-focus next PIN input
        const pinInputs = document.querySelectorAll('.pin-input');
        pinInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value && index < pinInputs.length - 1) {
                    pinInputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    pinInputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>