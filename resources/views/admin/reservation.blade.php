<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Management - Kerapu Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3490dc;
            --secondary: #6c757d;
            --success: #38c172;
            --danger: #e3342f;
            --warning: #f6993f;
            --info: #6cb2eb;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: #fff; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 5px; }
        .sidebar .nav-link:hover { color: #fff; background-color: rgba(255,255,255,0.1); }
        .sidebar .nav-link.active { background-color: var(--primary); color: #fff; }
        .table thead { background: var(--primary); color: #fff; }
        .badge-pending { background: #f6993f; }
        .badge-paid { background: #6cb2eb; }
        .badge-completed { background: #38c172; }
        .badge-cancelled { background: #e3342f; }
        .badge-confirmed { background: #38c172; }
        .modal-lg { max-width: 900px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="d-flex flex-column flex-shrink-0 p-3">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4">Kerapu Fine Dining</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item"><a href="{{ route('admin.index') }}" class="nav-link"><i class="fas fa-home me-2"></i>Dashboard</a></li>
                    <li><a href="{{ route('admin.table.management') }}" class="nav-link"><i class="fas fa-chair shortcut-icon me-2"></i>Table Management</a></li>
                    <li><a href="{{ route('admin.menu.management') }}" class="nav-link"><i class="fas fa-utensils me-2"></i>Menu Management</a></li>
                    <li><a href="{{ route('admin.transactions.index') }}" class="nav-link active"><i class="fas fa-calendar-check me-2"></i>Reservations</a></li>
                    <li><a href="{{ route('admin.orders') }}" class="nav-link"><i class="fas fa-shopping-cart me-2"></i>Orders</a></li>
                    <li><a href="{{ route('admin.reports') }}" class="nav-link"><i class="fas fa-chart-line me-2"></i>Reports</a></li>
                    <li><a href="{{ route('admin.users') }}" class="nav-link "><i class="fas fa-users me-2"></i>User Management</a></li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>Admin</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><hr class="dropdown-divider"></li>
                        <li> <form action="{{ route('admin.logout') }}" method="POST" class="d-inline"> @csrf <button type="submit" class="dropdown-item">Log Out</button> </form> </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-auto">
            <div class="container py-4">
                <h2 class="mb-4">Reservation Management</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction Code</th>
                                    <th>Customer</th>
                                    <th>Table</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Payment Method</th>
                                    <th>Subtotal</th>
                                    <th>Service Charge</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                    <th>Phone</th>
                                    <th>Special Request</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $trx->transaction_code }}</td>
                                        <td>{{ $trx->user->name ?? '-' }}</td>
                                        <td>
                                            @if($trx->reservation && $trx->reservation->table)
                                                Table {{ $trx->reservation->table->table_number }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $trx->reservation && $trx->reservation->reserved_at ? \Carbon\Carbon::parse($trx->reservation->reserved_at)->format('Y-m-d') : '-' }}
                                        </td>
                                        <td>
                                            {{ $trx->reservation && $trx->reservation->reserved_at ? \Carbon\Carbon::parse($trx->reservation->reserved_at)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $trx->payment_method ?? '-' }}</td>
                                        <td>{{ $trx->subtotal ?? '-' }}</td>
                                        <td>{{ $trx->service_charge ?? '-' }}</td>
                                        <td>{{ $trx->tax ?? '-' }}</td>
                                        <td>{{ $trx->total ?? '-' }}</td>
                                        <td>{{ $trx->phone ?? '-' }}</td>
                                        <td>{{ $trx->special_request ?? '-' }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($trx->status == 'pending') badge-pending
                                                @elseif($trx->status == 'paid') badge-paid
                                                @elseif($trx->status == 'completed') badge-completed
                                                @elseif($trx->status == 'cancelled') badge-cancelled
                                                @elseif($trx->status == 'confirmed') badge-confirmed
                                                @endif">
                                                {{ ucfirst($trx->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm btn-receipt-modal" data-code="{{ $trx->transaction_code }}"><i class="fas fa-eye"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="text-center">No reservations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Receipt -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">Transaction Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="receiptModalBody">
        <!-- Receipt content will be loaded here -->
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.btn-receipt-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        const trxCode = this.getAttribute('data-code');
        const modal = new bootstrap.Modal(document.getElementById('receiptModal'));
        document.getElementById('receiptModalBody').innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
        modal.show();
        fetch(`{{ route('payment.receipt') }}?transaction=${trxCode}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('receiptModalBody').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('receiptModalBody').innerHTML = '<div class="alert alert-danger">Failed to load receipt.</div>';
            });
    });
});
</script>
</body>
</html>