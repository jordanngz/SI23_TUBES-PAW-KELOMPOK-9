<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Offline Orders - Kerapu Fine Dining</title>
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
        .sidebar .nav-link:hover { color: #fff; background-color: rgba(255,255,255,0.1);}
        .sidebar .nav-link.active { color: #fff; background-color: var(--primary);}
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
                    <li><a href="{{ route('admin.transactions.index') }}" class="nav-link"><i class="fas fa-calendar-check me-2"></i>Reservations</a></li>
                    <li><a href="{{ route('admin.order') }}" class="nav-link active"><i class="fas fa-shopping-cart me-2"></i>Orders</a></li>
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
                <h2 class="mb-4">Offline Orders</h2>

                <!-- Form Order Baru -->
                <div class="card mb-4">
                    <div class="card-header">Create New Order</div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.store') }}" method="POST">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-4 mb-2">
                                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name (optional)">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="text" name="table_number" class="form-control" placeholder="Table Number (optional)">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="note" class="form-control" placeholder="Special Note (optional)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label><strong>Menu Items:</strong></label>
                                <div class="row">
                                    @foreach($products as $product)
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" id="product_{{ $product->id }}" onchange="toggleQty({{ $product->id }})">
                                            </div>
                                            <span class="input-group-text" style="min-width:120px">{{ $product->name }}</span>
                                            <input type="number" name="quantities[{{ $product->id }}]" min="1" value="1" class="form-control" style="max-width:80px" id="qty_{{ $product->id }}" disabled>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Save Order</button>
                        </form>
                        <script>
                        function toggleQty(id) {
                            const cb = document.getElementById('product_' + id);
                            const qty = document.getElementById('qty_' + id);
                            qty.disabled = !cb.checked;
                        }
                        </script>
                    </div>
                </div>

                <!-- Daftar Order Hari Ini -->
                <div class="card">
                    <div class="card-header">Order List (Today)</div>
                    <div class="card-body">
                        @if($orders->count())
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Table</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->table_number ?? '-' }}</td>
                                    <td>{{ $order->customer_name ?? '-' }}</td>
                                    <td>
                                        <ul class="mb-0">
                                            @foreach($order->items as $item)
                                                <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $order->note ?? '-' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status=='pending') bg-warning
                                            @elseif($order->status=='in_process') bg-info
                                            @elseif($order->status=='done') bg-success
                                            @endif">
                                            {{ ucfirst(str_replace('_',' ',$order->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if($order->status != 'done')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                                <option value="in_process" {{ $order->status=='in_process'?'selected':'' }}>In Process</option>
                                                <option value="done" {{ $order->status=='done'?'selected':'' }}>Done</option>
                                            </select>
                                        </form>
                                        @else
                                            <span class="text-success">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <p class="text-muted">No orders yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>