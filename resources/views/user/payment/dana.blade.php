<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kerapu Fine Dining - DANA Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Hamburger Menu Button */
        .hamburger-btn {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
            transition: all 0.3s ease;
        }

        .hamburger-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .hamburger-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .hamburger-line {
            width: 20px;
            height: 2px;
            background: white;
            margin: 2px 0;
            transition: all 0.3s ease;
            border-radius: 1px;
        }

        .hamburger-btn.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger-btn.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger-btn.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(5px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 320px;
            min-width: 320px;
            background: linear-gradient(180deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            padding: 0;
            box-shadow: 4px 0 20px rgba(30, 64, 175, 0.15);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .sidebar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            transform: translate(-50px, 50px);
        }

        .logo {
            padding: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 2;
        }

        .logo h3 {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: -0.025em;
        }

        .menu-categories {
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .menu-categories h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .menu-categories ul {
            list-style: none;
        }

        .menu-categories li {
            margin-bottom: 0.5rem;
        }

        .menu-categories a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 400;
        }

        .menu-categories a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }

        .cart-summary {
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            margin: 1rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
        }

        .cart-summary h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .cart-item-sidebar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cart-item-sidebar:last-child {
            border-bottom: none;
        }

        .cart-item-name {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .cart-item-price {
            font-weight: 600;
            color: white;
        }

        .cart-total {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        .cart-total p {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            color: white;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 2rem;
            background: white;
            overflow-x: auto;
            min-width: 0;
            transition: margin-left 0.3s ease;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e40af;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .payment-summary {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .payment-summary h2 {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            padding: 1.5rem 2rem;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .order-items {
            padding: 2rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 1rem;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-totals {
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .order-totals > div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            color: #64748b;
        }

        .order-totals > div:last-child {
            margin-bottom: 0;
            padding-top: 0.75rem;
            border-top: 2px solid #e2e8f0;
            font-size: 1.1rem;
            color: #1e40af;
        }

        .pay-button {
            width: 100%;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .pay-button:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .close-modal {
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .close-modal:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 1rem;
            text-align: center;
        }

        .pin-input-container {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .pin-input {
            width: 3rem;
            height: 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pin-input:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .submit-pin {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-pin:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }

        /* Success Modal Styles */
        .success-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }

        .success-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            overflow: hidden;
        }

        .back-button {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            cursor: pointer;
            color: #64748b;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #e2e8f0;
            color: #1e40af;
        }

        .success-header {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
        }

        .success-header h2 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .success-body {
            padding: 2rem;
            text-align: center;
        }

        .success-body h2 {
            color: #059669;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .success-body p {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .amount {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .view-detail {
            color: #64748b;
            cursor: pointer;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .view-detail:hover {
            color: #1e40af;
        }

        .transaction-details {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            text-align: left;
        }

        .transaction-details p {
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
        }

        .view-transaction {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .view-transaction:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }

        /* Desktop - Sidebar always visible */
        @media (min-width: 769px) {
            .hamburger-btn {
                display: none;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
        }

        /* Mobile - Hamburger menu */
        @media (max-width: 768px) {
            .hamburger-btn {
                display: block;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                width: 100%;
                padding: 5rem 1rem 1rem 1rem;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .payment-summary h2 {
                font-size: 1.2rem;
                padding: 1rem 1.5rem;
            }

            .order-items {
                padding: 1.5rem;
            }

            .order-item {
                font-size: 0.9rem;
                padding: 0.75rem 0;
            }

            .order-totals {
                padding: 1rem 1.5rem;
            }

            .order-totals > div {
                font-size: 0.85rem;
            }

            .order-totals > div:last-child {
                font-size: 1rem;
            }

            .pay-button {
                font-size: 1rem;
                padding: 0.875rem 1.5rem;
            }

            .pin-input-container {
                gap: 0.5rem;
            }

            .pin-input {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1rem;
            }

            .modal-content {
                width: 95%;
                max-width: 350px;
            }

            .modal-header {
                padding: 1rem 1.5rem;
            }

            .modal-header h2 {
                font-size: 1.1rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .success-content {
                width: 95%;
                max-width: 450px;
            }

            .success-body {
                padding: 1.5rem;
            }

            .amount {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 5rem 0.75rem 0.75rem 0.75rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .payment-summary {
                margin: 0;
            }

            .pin-input {
                width: 2rem;
                height: 2rem;
                font-size: 0.9rem;
            }

            .pin-input-container {
                gap: 0.3rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Hamburger Menu Button -->
    <button class="hamburger-btn" id="hamburger-btn">
        <div class="hamburger-icon">
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
        </div>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="logo"><h3>Kerapu Fine Dining</h3></div>
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

        <!-- PIN Modal -->
        <div class="modal" id="pin-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Enter DANA PIN</h2>
                    <span class="close-modal">&times;</span>
                </div>
                <div class="modal-body" style="display: row; gap: 0.75rem; justify-content: center; margin-bottom: 2rem;">
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
    // Hamburger menu functionality
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        hamburgerBtn.classList.toggle('active');
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
    }

    hamburgerBtn.addEventListener('click', toggleSidebar);
    sidebarOverlay.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking on links (mobile)
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        });
    });

    // PIN input navigation with Enter key
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

    document.getElementById('dana-pay').onclick = () => {
        document.getElementById('pin-modal').style.display = 'flex';
        setTimeout(() => {
            document.querySelector('.pin-input').focus();
        }, 100);
    };

    document.querySelector('.close-modal').onclick = () => {
        document.getElementById('pin-modal').style.display = 'none';
        // Clear PIN inputs
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
                // Clear PIN inputs
                document.querySelectorAll('.pin-input').forEach(input => input.value = '');
            } else {
                alert("Payment failed");
            }
        }).catch(() => alert('Payment request failed'));
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
        location.href = "{{ route('payment.receipt', ['transaction' => $transaction->transaction_code]) }}";
    };

    // Close sidebar on window resize if mobile
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            hamburgerBtn.classList.remove('active');
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        }
    });
</script>
</body>
</html>