<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status - Kerapu Fine Dining</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 320px;
            background-color: #1a1a1a;
            color: #fff;
            padding: 30px 20px;
        }

        .restaurant-name {
            font-size: 28px;
            color: #d4af37;
            margin-bottom: 40px;
            font-weight: bold;
        }

        .sidebar-section {
            margin-bottom: 40px;
        }

        .sidebar-title {
            font-size: 22px;
            color: #d4af37;
            margin-bottom: 20px;
        }

        .sidebar-link {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .sidebar-link:hover {
            color: #d4af37;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #333;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 32px;
            color: #333;
        }

        .step-indicator {
            width: 40px;
            height: 40px;
            background-color: #d4af37;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
        }

        .content-container {
            display: flex;
            gap: 30px;
        }

        .payment-status-container {
            flex: 1;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
        }

        .order-summary-container {
            width: 350px;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 25px;
            color: #333;
        }

        .status-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .status-icon {
            width: 80px;
            height: 80px;
            background-color: #4CAF50;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
        }

        .status-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .status-message {
            color: #666;
            margin-bottom: 20px;
        }

        .transaction-id {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            margin-bottom: 20px;
        }

        .payment-details {
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .detail-label {
            color: #666;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-divider {
            height: 1px;
            background-color: #ddd;
            margin: 15px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #d4af37;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .button-secondary {
            background-color: #f0f0f0;
            color: #333;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .notice {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-top: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="restaurant-name">Kerapu Fine Dining</div>

        <div class="sidebar-section">
            <div class="sidebar-title">Menu Categories</div>
            <a href="#" class="sidebar-link">Back to Seat Selection</a>
            <a href="#" class="sidebar-link">All Menu</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-title">Your Selection</div>
            @foreach ($cart->items as $item)
                @if ($item->product)
                    <div class="order-item">
                        <div>{{ $item->product->name }}</div>
                        <div>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                @endif
            @endforeach
            <div class="total-row">
                <div>Total:</div>
                <div>Rp{{ number_format($cart->items->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0), 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Payment Status</h1>
            <div class="step-indicator">5</div>
        </div>

        <div class="content-container">
            <div class="payment-status-container">
                <h2 class="section-title">Payment Status</h2>
                <div class="status-box">
                    <div class="status-icon">✓</div>
                    <h3 class="status-title">Payment Successful!</h3>
                    <p class="status-message">Your payment has been processed successfully via Dana.</p>
                    <div class="transaction-id">
                        Transaction ID: {{ $cart->transaction_code ?? 'N/A' }}
                    </div>
                    <div class="payment-details">
                        <div class="detail-row">
                            <span class="detail-label">Date & Time:</span>
                            <span>{{ now()->format('d M Y, H:i:s') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Payment Method:</span>
                            <span>{{ $cart->payment_method ?? 'DANA' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount Paid:</span>
                            <span>Rp{{ number_format($cart->items->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="notice">
                    Tunjukkan ke resepsionis ketika sampai di restaurant
                </div>
                <div class="button-container">
                    <a href="{{ route('home') }}" class="button button-secondary">Back to Home</a>
                    <a href="{{ route('payment.receipt', ['id' => $cart->id]) }}" class="button">Export Receipt</a>
                </div>
            </div>

            <div class="order-summary-container">
                <h2 class="section-title">Order Summary</h2>
                @foreach ($cart->items as $item)
                    @if ($item->product)
                        <div class="summary-item">
                            <span>{{ $item->product->name }}</span>
                            <span>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endif
                @endforeach
                <div class="summary-divider"></div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp{{ number_format($cart->items->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0), 0, ',', '.') }}</span>
                </div>
                <form method="POST" action="{{ route('complete.order') }}">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                    <button type="submit" class="button" style="margin-top:20px; display:block; text-align:center;">Complete Order</button>
                </form>

            </div>
        </div>
    </div>
</div>
</body>
</html>
