<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports - Kerapu Fine Dining</title>
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
        .card-stats { border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .feature-card { border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
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
                    <li><a href="{{ route('admin.order') }}" class="nav-link"><i class="fas fa-shopping-cart me-2"></i>Orders</a></li>
                    <li><a href="{{ route('admin.reports') }}" class="nav-link active"><i class="fas fa-chart-line me-2"></i>Reports</a></li>
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
                <h2 class="mb-4">Reports & Analytics</h2>

                <!-- Stat Cards -->
                <div class="row mb-4">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Total Orders</h6>
                                        <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                                    </div>
                                    <div class="card-icon bg-primary-subtle text-primary">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Revenue</h6>
                                        <h2 class="fw-bold mb-0">$ {{ number_format($totalRevenue,0,',','.') }}</h2>
                                    </div>
                                    <div class="card-icon bg-success-subtle text-success">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Visitors</h6>
                                        <h2 class="fw-bold mb-0">{{ $totalVisitors }}</h2>
                                    </div>
                                    <div class="card-icon bg-info-subtle text-info">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Best Seller</h6>
                                        <h5 class="fw-bold mb-0">{{ $bestSeller->name ?? '-' }}</h5>
                                    </div>
                                    <div class="card-icon bg-warning-subtle text-warning">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Chart (dummy, ganti dengan chartjs jika mau) -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-chart-bar text-primary me-2"></i> Revenue Trend</h5>
                        <div>
                            <canvas id="revenueChart" height="80"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Table: Top Menu -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-fire text-danger me-2"></i> Top 5 Menu</h5>
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topMenus as $menu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->sold }}</td>
                                    <td>$ {{ number_format($menu->revenue,0,',','.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table: Order History -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-list text-secondary me-2"></i> Order History</h5>
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Table</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $order->customer_name ?? '-' }}</td>
                                    <td>{{ $order->table_number ?? '-' }}</td>
                                    <td>$ {{ number_format($order->total,0,',','.') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status=='pending') bg-warning
                                            @elseif($order->status=='in_process') bg-info
                                            @elseif($order->status=='done') bg-success
                                            @endif">
                                            {{ ucfirst(str_replace('_',' ',$order->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example revenue chart (dummy data, ganti dengan data dinamis jika mau)
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($chartData) !!},
                borderColor: '#3490dc',
                backgroundColor: 'rgba(52,144,220,0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
</body>
</html>