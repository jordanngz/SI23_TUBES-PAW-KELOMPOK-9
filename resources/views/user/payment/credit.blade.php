<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kerapu Fine Dining - Credit Card Payment</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bayar.css') }}">
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
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
}

h1, h2, h3, h4 {
    font-family: 'Playfair Display', serif;
    color: #222;
}

a {
    text-decoration: none;
    color: #333;
}

ul {
    list-style: none;
}

.container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar Styles */
.sidebar {
    width: 280px;
    background-color: #fff;
    border-right: 1px solid #eaeaea;
    padding: 20px;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.logo {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eaeaea;
}

.logo h3 {
    font-size: 1.5rem;
    font-weight: 600;
}

.menu-categories {
    margin-bottom: 30px;
}

.menu-categories h4 {
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.menu-categories ul li {
    margin-bottom: 10px;
}

.menu-categories ul li a {
    display: block;
    padding: 8px 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.menu-categories ul li a:hover {
    background-color: #f5f5f5;
}

.cart-summary {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid #eaeaea;
}

.cart-summary h4 {
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.cart-items-sidebar {
    margin-bottom: 15px;
}

.cart-item-sidebar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #eaeaea;
}

.cart-total {
    font-weight: 500;
    font-size: 1.1rem;
}

/* Main Content Styles */
.main-content {
    flex: 1;
    margin-left: 280px;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eaeaea;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.menu-toggle span {
    width: 25px;
    height: 3px;
    background-color: #333;
    margin-bottom: 5px;
    border-radius: 3px;
}

.cart-icon {
    position: relative;
}

.cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #e74c3c;
    color: white;
    font-size: 0.7rem;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Payment Summary Styles */
.payment-summary {
    background-color: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
}

.payment-summary h2 {
    margin-bottom: 20px;
    font-size: 1.5rem;
}

.order-items {
    margin-bottom: 20px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed #eaeaea;
}

.order-totals {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eaeaea;
}

.order-subtotal,
.order-service,
.order-tax {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 0.95rem;
}

.order-total {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eaeaea;
    font-weight: 600;
    font-size: 1.1rem;
}

.pay-button {
    display: block;
    width: 100%;
    padding: 15px;
    margin-top: 25px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pay-button:hover {
    background-color: #1a2530;
}

.dana-button {
    background-color: #0095ff;
}

.dana-button:hover {
    background-color: #0077cc;
}

/* PIN Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    width: 90%;
    max-width: 400px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.modal-header {
    padding: 15px 20px;
    background-color: #f5f5f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    font-size: 1.2rem;
}

.close-modal {
    font-size: 1.5rem;
    cursor: pointer;
}

.modal-body {
    padding: 25px;
}

.pin-input-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
}

.pin-input {
    width: 40px;
    height: 50px;
    text-align: center;
    font-size: 1.2rem;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.submit-pin {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-pin:hover {
    background-color: #1a2530;
}

/* Success Modal Styles */
.success-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.success-content {
    background-color: white;
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    position: relative;
}

.success-header {
    padding: 15px 20px;
    background-color: #f5f5f5;
    text-align: center;
}

.success-header h2 {
    font-size: 1.2rem;
}

.success-body {
    padding: 30px 20px;
    text-align: center;
}

.success-icon {
    margin: 0 auto 20px;
    width: 80px;
    height: 80px;
    background-color: #f5f5f5;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.coin {
    width: 60px;
    height: 60px;
    background-color: #ffc107;
    border-radius: 50%;
    position: relative;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.coin::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 4px;
    background-color: #e0a800;
    border-radius: 2px;
}

.success-body h2 {
    margin-bottom: 10px;
    font-size: 1.5rem;
}

.success-body p {
    margin-bottom: 5px;
    color: #666;
}

.payment-method {
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 20px !important;
}

.amount-container {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 10px;
    margin: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.amount {
    font-size: 1.5rem;
    font-weight: 600;
    color: #ff8c00;
}

.view-detail {
    color: #0095ff;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.view-detail span {
    margin-left: 5px;
}

.transaction-info {
    margin: 20px 0;
    font-size: 0.9rem;
    color: #777;
}

.view-transaction {
    display: block;
    width: 100%;
    padding: 15px;
    background-color: #0095ff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.view-transaction:hover {
    background-color: #0077cc;
}

/* DANA Success Specific Styles */
.dana-success .success-header {
    background-color: #0095ff;
    color: white;
    padding: 20px;
}

.dana-success .success-header h2 {
    color: white;
}

.dana-success .success-content {
    background-color: #0095ff;
    color: white;
    max-width: 100%;
    height: 100%;
    border-radius: 0;
}

.dana-success .success-body {
    background-color: #0095ff;
    color: white;
    padding-top: 50px;
    height: calc(100% - 60px);
    position: relative;
}

.dana-success .success-body::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60%;
    background-color: white;
    border-radius: 30px 30px 0 0;
    z-index: 0;
}

.dana-success .success-body > * {
    position: relative;
    z-index: 1;
}

.dana-success .success-icon {
    background-color: transparent;
    margin-bottom: 30px;
}

.dana-success .coin {
    width: 80px;
    height: 80px;
}

.dana-success .success-body h2,
.dana-success .success-body p:not(.transaction-info):not(.payment-method) {
    color: white;
}

.dana-success .payment-method {
    color: white;
    font-size: 1.2rem;
}

.dana-success .amount-container {
    background-color: white;
    margin-top: 40px;
}

.dana-success .transaction-info {
    color: #555;
}

.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    color: white;
    cursor: pointer;
    z-index: 10;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 100;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .menu-toggle {
        display: flex;
    }
    
    .pin-input {
        width: 35px;
        height: 45px;
    }
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
                <h4>Reservation</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('checkout') }}">Back to payment method</a></li>
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

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Credit Card Payment</h1>
            </div>

            <div class="payment-summary">
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
                <button class="pay-button" id="credit-card-pay">Pay with Credit Card</button>
            </div>

            <!-- PIN Modal -->
            <div class="modal" id="pin-modal" style="display:none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Enter PIN</h2>
                        <span class="close-modal" style="cursor:pointer;">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div class="pin-input-container">
                            @for($i = 0; $i < 6; $i++)
                                <input type="password" maxlength="1" class="pin-input" data-index="{{ $i }}">
                            @endfor
                        </div>
                        <button class="submit-pin">Submit</button>
                    </div>
                </div>
            </div>

            <!-- Success Modal -->
            <div class="success-modal" id="success-modal" style="display:none;">
                <div class="success-content">
                    <div class="back-button" style="cursor:pointer;">&larr; Back</div>
                    <div class="success-header"><h2>Payment Status</h2></div>
                    <div class="success-body">
                        <h2>Payment Success!</h2>
                        <p>Transaction paid with Credit Card</p>
                        <div class="amount-container"
                             data-subtotal="{{ $transaction->subtotal }}"
                             data-service="{{ $transaction->service_charge }}"
                             data-tax="{{ $transaction->tax }}"
                             data-total="{{ $transaction->total }}">
                            <div class="amount">${{ number_format($transaction->total, 2) }}</div>
                            <div class="view-detail" id="toggle-detail" style="cursor:pointer;">View Detail &#9662;</div>
                        </div>
                        <div class="transaction-details" id="transaction-details" style="display:none;"></div>
                        <button class="view-transaction" id="view-transaction-button">VIEW TRANSACTION</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // PIN input navigation
        document.querySelectorAll('.pin-input').forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < 5) {
                    document.querySelectorAll('.pin-input')[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    document.querySelectorAll('.pin-input')[index - 1].focus();
                }
                if (e.key === 'Enter') {
                    if (index < 5) {
                        document.querySelectorAll('.pin-input')[index + 1].focus();
                    } else {
                        document.querySelector('.submit-pin').click();
                    }
                }
            });
        });

        document.getElementById('credit-card-pay').onclick = () => {
            document.getElementById('pin-modal').style.display = 'flex';
            setTimeout(() => {
                document.querySelector('.pin-input').focus();
            }, 100);
        };

        document.querySelector('.close-modal').onclick = () => {
            document.getElementById('pin-modal').style.display = 'none';
            document.querySelectorAll('.pin-input').forEach(input => input.value = '');
        };

        document.querySelector('.submit-pin').onclick = () => {
            fetch("{{ route('payment.confirm', ['transaction' => $transaction->transaction_code]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('pin-modal').style.display = 'none';
                    document.getElementById('success-modal').style.display = 'flex';
                    document.querySelectorAll('.pin-input').forEach(input => input.value = '');
                } else {
                    alert("Payment failed");
                }
            }).catch(() => alert('Payment request failed'));
        };

        document.getElementById('toggle-detail').onclick = function () {
            const d = document.getElementById('transaction-details');
            const data = document.querySelector('.amount-container').dataset;
            d.innerHTML = `
                <p><strong>Subtotal:</strong> $${parseFloat(data.subtotal).toFixed(2)}</p>
                <p><strong>Service:</strong> $${parseFloat(data.service).toFixed(2)}</p>
                <p><strong>Tax:</strong> $${parseFloat(data.tax).toFixed(2)}</p>
                <p><strong>Total:</strong> $${parseFloat(data.total).toFixed(2)}</p>
            `;
            d.style.display = d.style.display === 'none' ? 'block' : 'none';
        };

        document.querySelector('.back-button').onclick = () => {
            location.href = "{{ route('payment.status.final') }}";
        };

        document.getElementById('view-transaction-button').onclick = () => {
            location.href = "{{ route('payment.receipt', ['transaction' => $transaction->transaction_code]) }}";
        };
    </script>
</body>
</html>