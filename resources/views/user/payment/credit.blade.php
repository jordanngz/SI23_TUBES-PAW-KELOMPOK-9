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