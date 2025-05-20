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
