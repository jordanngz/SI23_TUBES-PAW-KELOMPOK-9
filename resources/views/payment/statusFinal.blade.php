<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kerapu Fine Dining - Payment Status</title>
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
        <li class="active"><a href="#">Payment Status</a></li>
        <li><a href="#">Payment History</a></li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <h1>Payment Status</h1>
      <input type="date" value="{{ now()->format('Y-m-d') }}" />
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
            <div class="payment-value">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</div>
          </div>

          <div class="payment-row">
            <div>Service Charge</div>
            <div class="payment-value">Rp {{ number_format($transaction->service_charge, 0, ',', '.') }}</div>
          </div>

          <div class="payment-row">
            <div>Tax</div>
            <div class="payment-value">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</div>
          </div>

          <div class="payment-row">
            <div><strong>Total</strong></div>
            <div class="payment-value"><strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong></div>
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
              <a href="{{ route('confirm.view', ['transactionCode' => $transaction->transaction_code]) }}" class="pay-btn">
                  Seat Confirmation
              </a>
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
