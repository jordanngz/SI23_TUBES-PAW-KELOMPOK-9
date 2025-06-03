<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kerapu Fine Dining - Payment Status</title>
  <link rel="stylesheet" href="{{ asset('css/styleseat.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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
    color: #333;
    background-color: #f9f9f9;
    line-height: 1.6;
}

h1, h2, h3, h4 {
    font-family: 'Playfair Display', serif;
    font-weight: 600;
}

.container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar Styles */
.sidebar {
    width: 300px;
    background-color: #1a1a1a;
    color: #fff;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
}

.logo {
    margin-bottom: 2rem;
    text-align: center;
}

.logo h3 {
    font-size: 1.5rem;
    color: #e0c080;
    letter-spacing: 1px;
}

.sidebar-section {
    margin-bottom: 2rem;
}

.sidebar-section h4 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #e0c080;
}

.sidebar-menu {
    list-style: none;
}

.sidebar-menu li {
    margin-bottom: 0.8rem;
}

.sidebar-menu a {
    color: #fff;
    text-decoration: none;
    font-size: 0.95rem;
    display: block;
    padding: 0.5rem 0;
    transition: color 0.3s;
}

.sidebar-menu a:hover {
    color: #e0c080;
}

.sidebar-menu li.active a {
    color: #e0c080;
    font-weight: 500;
}

.reservation-status {
    color: #999;
    font-style: italic;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.reservation-details {
    margin-bottom: 1.5rem;
}

.reservation-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.continue-btn {
    width: 100%;
    padding: 0.8rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.continue-btn:hover {
    background-color: #d4b06e;
}

/* Main Content Styles */
.main-content {
    flex-grow: 1;
    margin-left: 300px;
    padding: 2rem;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header h1 {
    font-size: 2.2rem;
    color: #333;
}

.date-picker input {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
}

.reservation-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.section-title {
    margin-bottom: 1.5rem;
}

.section-title h2 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.section-title p {
    color: #666;
}

.time-selection {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    align-items: center;
}

.time-selection label {
    font-size: 0.9rem;
    color: #666;
}

.time-selection select {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
}

.tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.table-card {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s;
    cursor: pointer;
}

.table-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.table-image {
    height: 200px;
    overflow: hidden;
}

.table-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.table-card:hover .table-image img {
    transform: scale(1.05);
}

.table-info {
    padding: 1.5rem;
}

.table-info h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.table-info p {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.table-status {
    display: inline-block;
    padding: 0.3rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.table-status.available {
    background-color: #e8f5e9;
    color: #4CAF50;
}

.table-status.reserved {
    background-color: #ffebee;
    color: #F44336;
}

.restaurant-layout {
    position: relative;
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 3rem;
}

.floor-plan {
    width: 100%;
    height: auto;
    display: block;
}

.layout-legend {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
}

.legend-color {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: inline-block;
}

.legend-color.available {
    background-color: #4CAF50;
}

.legend-color.reserved {
    background-color: #F44336;
}

.special-requests-form {
    margin-bottom: 2rem;
}

.special-requests-form textarea {
    width: 100%;
    height: 120px;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    resize: vertical;
}

.reservation-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
}

.back-btn {
    padding: 0.8rem 1.5rem;
    background-color: #fff;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.back-btn:hover {
    background-color: #f5f5f5;
}

.next-btn {
    padding: 0.8rem 1.5rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.next-btn:hover {
    background-color: #d4b06e;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .menu-toggle {
        display: block;
    }
}

@media (max-width: 768px) {
    .tables-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
    
    .header h1 {
        font-size: 1.8rem;
    }
    
    .time-selection {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .time-selection select {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .tables-grid {
        grid-template-columns: 1fr;
    }
    
    .main-content {
        padding: 1rem;
    }
    
    .header h1 {
        font-size: 1.5rem;
    }
    
    .reservation-container {
        padding: 1.5rem;
    }
    
    .reservation-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .back-btn, .next-btn {
        width: 100%;
    }
    
    .layout-legend {
        position: relative;
        bottom: auto;
        right: auto;
        margin-top: 1rem;
    }
}

.payment-card {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 24px;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: box-shadow 0.3s ease;
}

.payment-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.payment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.payment-id {
    font-weight: 600;
    font-size: 16px;
    color: #333;
}

.payment-status {
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 13px;
    font-weight: 500;
    text-transform: uppercase;
}

.payment-status.pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.payment-status.paid {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.payment-status.confirmed {
    background-color: #d4edda;
    color: #1cca45;
    border: 1px solid #c3e6cb;
}

.payment-info {
    margin-top: 20px;
}

.payment-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 15px;
    color: #444;
}

.payment-value {
    font-weight: 500;
    color: #000;
}

.payment-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.cancel-btn, .pay-btn {
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.cancel-btn {
    background-color: #f8d7da;
    color: #721c24;
}

.cancel-btn:hover {
    background-color: #f5c6cb;
}

.pay-btn {
    background-color: #cce5ff;
    color: #004085;
}

.pay-btn:hover {
    background-color: #b8daff;
}
</style>

<body>
<div class="container">
  <div class="sidebar">
    <div class="logo"><h3>Kerapu Fine Dining</h3></div>
    <div class="sidebar-section">
      <h4>Reservation</h4>
      <ul class="sidebar-menu">
        <li><a href="{{ route('reserve') }}">Back to Seat Selection</a></li>
        <li><a href="{{ route('payment.history')}}">Payment History</a></li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <h1>Payment Status</h1>
    </div>

    <div class="payment-container">
      <div class="section-title">
        <h2>Payment Information</h2>
        <p>Check the status of your reservation payment</p>
      </div>

      @forelse ($transactions as $transaction)
        <div class="payment-card">
          <div class="payment-header">
            <div class="payment-id">#{{ $transaction->transaction_code }}</div>
            <div class="payment-status {{ $transaction->status }}">{{ ucfirst($transaction->status) }}</div>
          </div>

        <div class="payment-info">
          <div class="payment-row">
            <div>Date</div>
            <div class="payment-value">{{ \Carbon\Carbon::parse($transaction->reservation->reserved_at)->format('F d, Y') }}</div>
          </div>

          <div class="payment-row">
            <div>Table</div>
            <div class="payment-value">
              Table {{ $transaction->reservation->table->number }} ({{ $transaction->reservation->table->seats }} People)
            </div>
          </div>

          <div class="payment-row">
            <div>Subtotal</div>
            <div class="payment-value">$ {{ number_format($transaction->subtotal, 0, ',', '.') }}</div>
          </div>

          <div class="payment-row">
            <div>Service Charge</div>
            <div class="payment-value">$ {{ number_format($transaction->service_charge, 0, ',', '.') }}</div>
          </div>

          <div class="payment-row">
            <div>Tax</div>
            <div class="payment-value">$ {{ number_format($transaction->tax, 0, ',', '.') }}</div>
          </div>

          <div class="payment-row">
            <div>Payment Method</div>
            <div class="payment-value">
              @if($transaction->payment_method === 'credit')
                Credit Card
              @elseif($transaction->payment_method === 'dana')
                DANA
              @elseif($transaction->payment_method === 'none' || !$transaction->payment_method)
                Not Selected
              @else
                {{ ucfirst($transaction->payment_method) }}
              @endif
            </div>
          </div>

          <div class="payment-row">
            <div><strong>Total</strong></div>
            <div class="payment-value"><strong>$ {{ number_format($transaction->total, 0, ',', '.') }}</strong></div>
          </div>

          {{-- Tambahan informasi reservasi --}}
          <div class="payment-row" style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
            <div><strong>Reserved By</strong></div>
            <div class="payment-value">{{ $transaction->reservation->user->name ?? 'Unknown' }}</div>
          </div>

          <div class="payment-row">
            <div><strong>Reservation ID</strong></div>
            <div class="payment-value">#{{ $transaction->reservation->id }}</div>
          </div>
        </div>

          <div class="payment-actions">
            <button class="cancel-btn">Cancel Reservation</button>

            @if ($transaction->status === 'pending')
              <a href="{{ route('checkoutByCode', ['code' => $transaction->transaction_code]) }}" class="pay-btn">Pay Bills</a>
            @elseif ($transaction->status === 'paid')
              <a href="{{ route('confirm.view', ['transactionCode' => $transaction->transaction_code]) }}" class="pay-btn"> Seat Confirmation </a>
            @elseif ($transaction->status === 'confirmed')
              <a href="#" class="pay-btn disabled" style="pointer-events: none; opacity: 0.6;">Reservation Confirmed</a>
            @endif
          </div>
        </div>
      @empty
        <p>No transactions found.</p>
      @endforelse
    </div>
  </div>
</div>
</body>
</html>