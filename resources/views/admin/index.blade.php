<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #3490dc; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: #fff; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 5px; }
        .sidebar .nav-link:hover { color: #fff; background-color: rgba(255,255,255,0.1);}
        .sidebar .nav-link.active { color: #fff; background-color: var(--primary);}
        .card-stats { border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .shortcut-card { border-radius: 10px; background: #fff; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s; }
        .shortcut-card:hover { background: var(--primary); color: #fff; }
        .shortcut-card:hover .shortcut-icon { color: #fff !important; }
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
                    <li class="nav-item"><a href="{{ route('admin.index') }}" class="nav-link active"><i class="fas fa-home me-2"></i>Dashboard</a></li>
                    <li><a href="{{ route('admin.table.management') }}" class="nav-link"><i class="fas fa-chair shortcut-icon me-2"></i>Table Management</a></li>
                    <li><a href="{{ route('admin.menu.management') }}" class="nav-link"><i class="fas fa-utensils me-2"></i>Menu Management</a></li>
                    <li><a href="{{ route('admin.transactions.index') }}" class="nav-link"><i class="fas fa-calendar-check me-2"></i>Reservations</a></li>
                    <li><a href="{{ route('admin.order') }}" class="nav-link"><i class="fas fa-shopping-cart me-2"></i>Orders</a></li>
                    <li><a href="{{ route('admin.reports') }}" class="nav-link"><i class="fas fa-chart-line me-2"></i>Reports</a></li>
                    <li><a href="{{ route('admin.users') }}" class="nav-link"><i class="fas fa-users me-2"></i>User Management</a></li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/32" alt="Admin" width="32" height="32" class="rounded-circle me-2">
                        <strong>Admin</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-auto">
            <div class="container py-4">
                <!-- Header -->
                <div class="card mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fs-3 fw-bold">Welcome, Admin!</h1>
                            <p class="text-muted mb-0" id="current-datetime">Loading date and time...</p>
                        </div>
                        <div>
                            <span class="text-muted small" id="last-updated">Last updated: --:--</span>
                            <button class="btn btn-sm btn-light ms-2" onclick="location.reload()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Cards -->
                <div class="row mb-4">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0 text-muted">Today's Reservations</h6>
                                    <h2 class="fw-bold mb-0">{{ $todayReservations ?? 0 }}</h2>
                                </div>
                                <div class="card-icon bg-primary-subtle text-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0 text-muted">Tables Reserved vs Available</h6>
                                    <h2 class="fw-bold mb-0">{{ $tablesReserved ?? 0 }}/{{ $tablesAvailable ?? 0 }}</h2>
                                </div>
                                <div class="card-icon bg-success-subtle text-success">
                                    <i class="fas fa-chair"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0 text-muted">Visitors Today</h6>
                                    <h2 class="fw-bold mb-0">{{ $visitorsToday ?? 0 }}</h2>
                                </div>
                                <div class="card-icon bg-info-subtle text-info">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0 text-muted">Revenue Today</h6>
                                    <h2 class="fw-bold mb-0">Rp {{ number_format($revenueToday ?? 0, 0, ',', '.') }}</h2>
                                </div>
                                <div class="card-icon bg-warning-subtle text-warning">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-th-large text-primary me-2"></i> Quick Navigation</h5>
                        <div class="row g-3">
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('admin.table.management') }}" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-chair shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Table Management</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('admin.menu.management') }}" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-utensils shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Menu Management</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('admin.reports') }}" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-chart-bar shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Sales Report</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-calendar-alt shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Reservation List</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('admin.orders') }}" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-shopping-cart shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Orders</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('admin.users') }}" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-users shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">User Management</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Features -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-cogs text-secondary me-2"></i> Admin Features</h5>
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary-subtle text-primary me-3">
                                            <i class="fas fa-users-cog"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">User Management</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="{{ route('admin.users') }}" class="text-decoration-none">Add/Edit Employees</a></li>
                                        <li><a href="{{ route('admin.users') }}" class="text-decoration-none">Reset Password</a></li>
                                        <li><a href="{{ route('admin.users') }}" class="text-decoration-none">Set Access Rights</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-success-subtle text-success me-3">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Reservation Management</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">View Reservation List</a></li>
                                        <li><a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">Approve/Cancel</a></li>
                                        <li><a href="{{ route('admin.table.management') }}" class="text-decoration-none">Change Table</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-info-subtle text-info me-3">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Reports & Statistics</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="{{ route('admin.reports') }}" class="text-decoration-none">Daily Reports</a></li>
                                        <li><a href="{{ route('admin.reports') }}" class="text-decoration-none">Monthly Reports</a></li>
                                        <li><a href="{{ route('admin.reports') }}" class="text-decoration-none">Print Reports</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-warning-subtle text-warning me-3">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Payments & Transactions</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="{{ route('admin.orders') }}" class="text-decoration-none">Transaction History</a></li>
                                        <li><a href="{{ route('admin.orders') }}" class="text-decoration-none">Monitor Payments</a></li>
                                        <li><a href="{{ route('admin.reports') }}" class="text-decoration-none">Revenue Reports</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Tambahkan fitur lain sesuai kebutuhan -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Dynamic date/time
    function updateDateTime() {
        const now = new Date();
        const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const weekday = days[now.getDay()];
        const month = months[now.getMonth()];
        const day = now.getDate();
        const year = now.getFullYear();
        let shift = "Morning Shift";
        const hour = now.getHours();
        if (hour >= 15 && hour < 22) shift = "Evening Shift";
        else if (hour >= 22 || hour < 7) shift = "Night Shift";
        let hours = now.getHours();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12; hours = hours ? hours : 12;
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const dateTimeString = `${weekday}, ${month} ${day}, ${year} | ${shift} | ${hours}:${minutes} ${ampm}`;
        document.getElementById('current-datetime').textContent = dateTimeString;
        document.getElementById('last-updated').textContent = `Last updated: ${hours}:${minutes} ${ampm}`;
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateDateTime();
        setInterval(updateDateTime, 60000);
    });
    setTimeout(function() { location.reload(); }, 300000);
</script>
</body>
</html>