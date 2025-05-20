<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kerapu Fine Dining - DANA Payment</title>
    <link rel="stylesheet" href="{{ asset('css/bayar.css') }}">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo"><h3>Kerapu Fine Dining</h3></div>
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
        <div class="header"><h1>DANA Payment</h1></div>

        <div class="payment-summary">
            <h2>Order Summary</h2>
            <div class="order-items">
                @foreach($transaction->items as $item)
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
            <button class="pay-button dana-button" id="dana-pay">Pay with DANA</button>
        </div>

        <div class="modal" id="pin-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Enter DANA PIN</h2>
                    <span class="close-modal">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="pin-input-container">
                        @for($i = 0; $i < 6; $i++)
                            <input type="password" maxlength="1" class="pin-input">
                        @endfor
                    </div>
                    <button class="submit-pin">Submit</button>
                </div>
            </div>
        </div>

        <div class="success-modal dana-success" id="success-modal">
            <div class="success-content">
                <div class="back-button">&larr; Back</div>
                <div class="success-header"><h2>Payment Status</h2></div>
                <div class="success-body">
                    <h2>Payment Success!</h2>
                    <p>Transaction paid with DANA</p>
                    <div class="amount-container"
                         data-subtotal="{{ $transaction->subtotal }}"
                         data-service="{{ $transaction->service_charge }}"
                         data-tax="{{ $transaction->tax }}"
                         data-total="{{ $transaction->total }}">
                        <div class="amount">Rp{{ number_format($transaction->total * 16436) }}</div>
                        <div class="view-detail" id="toggle-detail">View Detail &#9662;</div>
                    </div>
                    <div class="transaction-details" id="transaction-details" style="display:none;"></div>
                    <button class="view-transaction" id="view-transaction-button">VIEW TRANSACTION</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('dana-pay').onclick = () => {
        document.getElementById('pin-modal').style.display = 'flex';
    };
    document.querySelector('.close-modal').onclick = () => {
        document.getElementById('pin-modal').style.display = 'none';
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
            if(data.success) {
                document.getElementById('pin-modal').style.display = 'none';
                document.getElementById('success-modal').style.display = 'flex';
            } else {
                alert("Payment failed");
            }
        });
    };
    document.getElementById('toggle-detail').onclick = function () {
        const d = document.getElementById('transaction-details');
        const data = document.querySelector('.amount-container').dataset;
        const toRupiah = val => 'Rp' + (val * 15500).toLocaleString('id-ID');
        d.innerHTML = `
            <p><strong>Subtotal:</strong> ${toRupiah(data.subtotal)}</p>
            <p><strong>Service:</strong> ${toRupiah(data.service)}</p>
            <p><strong>Tax:</strong> ${toRupiah(data.tax)}</p>
            <p><strong>Total:</strong> ${toRupiah(data.total)}</p>
        `;
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    };
    document.querySelector('.back-button').onclick = () => {
        location.href = "{{ route('payment.status.final') }}";
    };
    document.getElementById('view-transaction-button').onclick = () => {
        location.href = "{{ route('payment.receipt') }}";
    };
</script>
</body>
</html>
