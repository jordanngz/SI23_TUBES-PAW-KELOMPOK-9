<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kerapu Fine Dining - Payment History</title>
  <link rel="stylesheet" href="{{ asset('css/styleseat.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="sidebar">
    <div class="logo"><h3>Kerapu Fine Dining</h3></div>
    <div class="sidebar-section">
      <h4>Reservation</h4>
      <ul class="sidebar-menu">
        <li><a href="{{ route('reserve') }}">Back to Seat Selection</a></li>
        <li><a href="{{ route('payment.status.final') }}">Payment Status</a></li>
        <li class="active"><a href="#">Payment History</a></li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <h1>Payment History</h1>
    </div>

    <div class="payment-container">
      <div class="section-title">
        <h2>Transaction History</h2>
      </div>

@foreach ($transactions as $txn)
  <div class="history-card {{ $txn->status }}">
    <div class="payment-header">
      <div class="payment-id">#{{ $txn->transaction_code }}</div>
      <div class="payment-status {{ $txn->status }}">{{ ucfirst($txn->status) }}</div>
    </div>

    <div class="payment-info">
      <div class="payment-row">
        <div>Date</div>
        <div class="payment-value">{{ \Carbon\Carbon::parse($txn->reservation->reserved_at)->format('F d, Y') }}</div>
      </div>

      <div class="payment-row">
        <div>Table</div>
        <div class="payment-value">Table {{ $txn->reservation->table->number }} ({{ $txn->reservation->table->seats }} People)</div>
      </div>

      <div class="payment-row">
        <div>Dining Time</div>
        <div class="payment-value">{{ $txn->reservation->reserved_at->format('h:i A') }}</div>
      </div>

      <div class="payment-row">
        <div>Subtotal</div>
        <div class="payment-value">$ {{ number_format($txn->subtotal, 0, ',', '.') }}</div>
      </div>

      <div class="payment-row">
        <div>Service Charge</div>
        <div class="payment-value">$ {{ number_format($txn->service_charge, 0, ',', '.') }}</div>
      </div>

      <div class="payment-row">
        <div>Tax</div>
        <div class="payment-value">$ {{ number_format($txn->tax, 0, ',', '.') }}</div>
      </div>

      <div class="payment-row">
        <div><strong>Total</strong></div>
        <div class="payment-value"><strong>$ {{ number_format($txn->total, 0, ',', '.') }}</strong></div>
      </div>

      <div class="payment-row" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
        <div><strong>Payment Method</strong></div>
        <div class="payment-value">{{ $txn->payment_method ?? '—' }}</div>
      </div>

      <div class="payment-row">
        <div><strong>Transaction ID</strong></div>
        <div class="payment-value">{{ $txn->transaction_id }}</div>
      </div>
    </div>

    <div class="payment-actions">
      @if ($txn->status === 'pending')
        <a href="{{ route('checkoutByCode', ['code' => $txn->transaction_code]) }}" class="pay-btn">Pay Bills</a>
      @elseif ($txn->status === 'paid')
        <a href="{{ route('confirm.view', ['transactionCode' => $txn->transaction_code]) }}" class="pay-btn">Seat Confirmation</a>
      @elseif ($txn->status === 'confirmed')
        <a href="{{ route('payment.receipt', ['transaction' => $txn->transaction_code]) }}" class="pay-btn">Lihat Receipt</a>
      @endif
    </div>
  </div>
@endforeach


    </div>
  </div>
</div>
</body>
</html>
