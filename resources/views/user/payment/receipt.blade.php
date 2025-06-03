<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Kerapu Fine Dining</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .receipt-container {
            width: 100%;
            max-width: 380px;
        }

        .back-button {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #0095ff;
            font-weight: bold;
            margin-bottom: 15px;
            font-family: 'Arial', sans-serif;
        }

        .back-arrow {
            margin-right: 5px;
            font-size: 20px;
        }

        .receipt {
            width: 100%;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            font-family: 'Arial', sans-serif;
        }

        .store-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .store-info {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .receipt-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
        }

        .receipt-details {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .dotted-line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .item-name {
            width: 60%;
        }

        .item-qty {
            width: 10%;
            text-align: center;
        }

        .item-price {
            width: 30%;
            text-align: right;
        }

        .subtotal-section {
            margin-top: 15px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .total-row {
            font-weight: bold;
            font-size: 16px;
            margin-top: 5px;
        }

        .payment-info {
            margin-top: 15px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .thank-you {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            margin-top: 10px;
        }

        .barcode {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            letter-spacing: 5px;
        }

        .notice {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border: 1px dashed #000;
            font-weight: bold;
            font-size: 14px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            flex: 1;
            background-color: #0095ff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            font-family: 'Arial', sans-serif;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                padding: 0;
            }

            .button-container, .back-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <a href="{{ route('payment.status.final') }}" class="back-button">
            <span class="back-arrow">←</span> Back
        </a>


        <div class="receipt">
            <div class="receipt-header">
                <div class="logo">🐟</div>
                <div class="store-name">KERAPU FINE DINING</div>
                <div class="store-info">Jl. Pantai Indah No. 123</div>
                <div class="store-info">Jakarta Selatan, Indonesia</div>
                <div class="store-info">Telp: (021) 555-7890</div>
            </div>

            <div class="receipt-title">RECEIPT</div>

            <div class="receipt-details">
                <div class="receipt-row">
                    <div>Transaction ID:</div>
                    <div>{{ $transaction->transaction_code }}</div>
                </div>
                <div class="receipt-row">
                    <div>Date:</div>
                    <div>{{ $transaction->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="receipt-row">
                    <div>Time:</div>
                    <div>{{ $transaction->created_at->format('H:i:s') }}</div>
                </div>
                <div class="receipt-row">
                    <div>Reservation:</div>
                    <div>{{ $transaction->reservation->table_name ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="dotted-line"></div>

            <div class="items-section">
                <div class="item-row" style="font-weight: bold;">
                    <div class="item-name">Item</div>
                    <div class="item-qty">Qty</div>
                    <div class="item-price">Price</div>
                </div>

                @foreach ($transaction->items as $item)
                <div class="item-row">
                    <div class="item-name">{{ $item->name }}</div>
                    <div class="item-qty">{{ $item->quantity }}</div>
                    <div class="item-price">${{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>

            <div class="dotted-line"></div>

            <div class="subtotal-section">
                <div class="receipt-row">
                    <div>Subtotal:</div>
                    <div>${{ number_format($transaction->subtotal, 0, ',', '.') }}</div>
                </div>
                <div class="receipt-row">
                    <div>Tax (10%):</div>
                    <div>${{ number_format($transaction->tax, 0, ',', '.') }}</div>
                </div>
                <div class="receipt-row total-row">
                    <div>TOTAL:</div>
                    <div>${{ number_format($transaction->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="payment-info">
                <div class="receipt-row">
                    <div>Payment Method:</div>
                    <div>{{ $transaction->payment_method }}</div>
                </div>
                <div class="receipt-row">
                    <div>Status:</div>
                    <div>{{ strtoupper($transaction->status) }}</div>
                </div>
            </div>

            <div class="notice">
                Tunjukkan ke resepsionis ketika sampai di restaurant
            </div>

            <div class="thank-you">
                THANK YOU FOR YOUR RESERVATION
            </div>

            <div class="footer-text">
                We look forward to serving you
            </div>

            <div class="barcode">
                *{{ strtoupper($transaction->transaction_code) }}*
            </div>

            <div class="button-container">
                <button onclick="window.location.href='{{ route('payment.status.final') }}'" class="button">BACK</button>
                <button onclick="window.print()" class="button">EXPORT TO PDF</button>
            </div>

        </div>
    </div>
</body>
</html>
