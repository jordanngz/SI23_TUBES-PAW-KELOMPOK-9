<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining - Order Confirmation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleconfirm.css') }}">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo"><h3>Kerapu Fine Dining</h3></div>
        <div class="order-summary-sidebar">
            <h4>Order Summary</h4>
            <div class="order-items-sidebar" id="order-items-sidebar">
                @foreach ($transaction->items as $item)
                    <div class="order-item-sidebar">
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
            <div class="order-total-sidebar">
                <div class="total-breakdown">
                    <div class="total-line"><span>Subtotal</span><span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span></div>
                    <div class="total-line"><span>Service (10%)</span><span>Rp {{ number_format($transaction->service_charge, 0, ',', '.') }}</span></div>
                    <div class="total-line"><span>Tax (7%)</span><span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span></div>
                    <div class="total-line final-total"><span>Total</span><span id="final-total">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Order Confirmation</h1>
            <div class="status-badge"><span class="status-text">Final Step</span></div>
        </div>

        <div class="confirmation-container">
            <!-- Table Info -->
            <div class="confirmation-section">
                <div class="section-header"><h2>Table Information</h2><span class="section-icon">🍽️</span></div>
                <div class="table-info-grid">
                    <div class="info-item"><div class="info-label">Table Number</div><div class="info-value">Table {{ $transaction->reservation->table->table_number }}</div></div>
                    <div class="info-item"><div class="info-label">Reservation Date</div><div class="info-value">{{ $transaction->reservation->reserved_at->format('F d, Y') }}</div></div>
                    <div class="info-item"><div class="info-label">Reservation Time</div><div class="info-value">{{ $transaction->reservation->reserved_at->format('h:i A') }}</div></div>
                    <div class="info-item"><div class="info-label">Number of Guests</div><div class="info-value">{{ $transaction->reservation->table->seats ?? 'N/A' }} People</div></div>
                </div>
            </div>

            <!-- Your Order -->
            <div class="confirmation-section">
                <div class="section-header"><h2>Your Order</h2><span class="section-icon">🍴</span></div>
                <div class="order-details">
                    @foreach ($transaction->items as $item)
                    <div class="order-item">
                        <div class="item-image"><img src="{{ $item->product->image ?? '/placeholder.svg?height=80&width=80' }}" alt="{{ $item->product->name }}"></div>
                        <div class="item-details">
                            <h3>{{ $item->product->name }}</h3>
                            <p>{{ $item->product->description ?? '-' }}</p>
                            <div class="item-meta">
                                <span class="quantity">Qty: {{ $item->quantity }}</span>
                                <span class="price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Confirmation Form (merged) -->
            <form action="{{ route('confirmation.finalize') }}" method="POST">
                @csrf
                <input type="hidden" name="transaction_code" value="{{ $transaction->transaction_code }}">

                <!-- Contact Info -->
                <div class="confirmation-section">
                    <div class="section-header"><h2>Contact Information</h2><span class="section-icon">📱</span></div>
                    <div class="form-group">
                        <label for="phone-number">Phone Number *</label>
                        <input type="tel" id="phone-number" name="phone" value="{{ $transaction->phone ?? $transaction->user->phone ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="special-requests">Special Requests (Optional)</label>
                        <textarea id="special-requests" name="special_request">{{ $transaction->special_request ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Total & Submit -->
                <div class="confirmation-section total-section">
                    <div class="section-header"><h2>Order Total</h2><span class="section-icon">💰</span></div>
                    <div class="total-breakdown-main">
                        <div class="total-line"><span>Subtotal</span><span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span></div>
                        <div class="total-line"><span>Service Charge</span><span>Rp {{ number_format($transaction->service_charge, 0, ',', '.') }}</span></div>
                        <div class="total-line"><span>Tax</span><span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span></div>
                        <div class="total-line grand-total"><span>Grand Total</span><span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span></div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('payment.status.final') }}" class="btn-secondary"><span class="btn-icon">←</span> Back to Menu</a>
                    <button type="submit" class="btn-primary"><span class="btn-icon">✓</span> Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
