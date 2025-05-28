<!-- resources/views/admin/dashboard.blade.php -->
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
        :root {
            --primary: #3490dc;
            --secondary: #6c757d;
            --success: #38c172;
            --danger: #e3342f;
            --warning: #f6993f;
            --info: #6cb2eb;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary);
        }
        .card-stats {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .alert-notification {
            border-left: 4px solid #f6993f;
        }
        .shortcut-card {
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: #fff;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .shortcut-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            background-color: var(--primary);
            color: white;
        }
        .shortcut-card:hover .shortcut-icon {
            color: white !important;
        }
        .feature-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
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
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-chair shortcut-icon me-2"></i>
                            Table Management
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-utensils me-2"></i>
                            Menu Management
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-calendar-check me-2"></i>
                            Reservations
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-line me-2"></i>
                            Reports
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-users me-2"></i>
                            User Management
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog me-2"></i>
                            Settings
                        </a>
                    </li>
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
                        <li><a class="dropdown-item" href="#">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-auto">
            <div class="container py-4">
                <!-- Header / Welcome Message -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="fs-3 fw-bold">Welcome, Admin!</h1>
                                <p class="text-muted mb-0" id="current-datetime">Loading date and time...</p>
                            </div>
                            <div>
                                <span class="text-muted small" id="last-updated">Last updated: 08:30</span>
                                <button class="btn btn-sm btn-light ms-2" onclick="location.reload()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Cards -->
                <div class="row mb-4">
                    <!-- Today's Reservations -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Today's Reservations</h6>
                                        <h2 class="fw-bold mb-0">3</h2>
                                    </div>
                                    <div class="card-icon bg-primary-subtle text-primary">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Occupied vs Available -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Tables Reserved vs Available</h6>
                                        <h2 class="fw-bold mb-0">4/10</h2>
                                    </div>
                                    <div class="card-icon bg-success-subtle text-success">
                                        <i class="fas fa-chair"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Number of Visitors Today -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Visitors Today</h6>
                                        <h2 class="fw-bold mb-0">24</h2>
                                    </div>
                                    <div class="card-icon bg-info-subtle text-info">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue Today -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Revenue Today</h6>
                                        <h2 class="fw-bold mb-0">Rp 3,250,000</h2>
                                    </div>
                                    <div class="card-icon bg-warning-subtle text-warning">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Orders -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-stats h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-muted">Active Orders</h6>
                                        <h2 class="fw-bold mb-0">4</h2>
                                    </div>
                                    <div class="card-icon bg-danger-subtle text-danger">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-bell text-warning me-2"></i> Notifications
                        </h5>
                        
                        <div class="alert alert-warning alert-notification">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span>Table T4 has not been cleaned yet</span>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning alert-notification">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span>"Special Fried Rice" menu item is out of stock</span>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning alert-notification">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span>3 reservations awaiting confirmation</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation / Shortcuts -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-th-large text-primary me-2"></i> Quick Navigation
                        </h5>
                        
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
                                <a href="#" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-utensils shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Menu Management</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-chart-bar shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Sales Report</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-calendar-alt shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Reservation List</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="shortcut-card p-3 text-center">
                                        <i class="fas fa-clock shortcut-icon text-primary mb-2 fs-2"></i>
                                        <p class="mb-0 fw-medium">Shift Report</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Features -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-cogs text-secondary me-2"></i> Admin Features
                        </h5>
                        
                        <div class="row g-3">
                            <!-- User Management -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary-subtle text-primary me-3">
                                            <i class="fas fa-users-cog"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">User Management</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Add/Edit Employees</a></li>
                                        <li><a href="#" class="text-decoration-none">Reset Password</a></li>
                                        <li><a href="#" class="text-decoration-none">Set Access Rights</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Reservation Management -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-success-subtle text-success me-3">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Reservation Management</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">View Reservation List</a></li>
                                        <li><a href="#" class="text-decoration-none">Approve/Cancel</a></li>
                                        <li><a href="#" class="text-decoration-none">Change Table</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Reports & Statistics -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-info-subtle text-info me-3">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Reports & Statistics</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Daily Reports</a></li>
                                        <li><a href="#" class="text-decoration-none">Monthly Reports</a></li>
                                        <li><a href="#" class="text-decoration-none">Print Reports</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Payments & Transactions -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-warning-subtle text-warning me-3">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Payments & Transactions</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Transaction History</a></li>
                                        <li><a href="#" class="text-decoration-none">Monitor Payments</a></li>
                                        <li><a href="#" class="text-decoration-none">Revenue Reports</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Inventory Management -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-danger-subtle text-danger me-3">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Inventory Management</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Check Ingredient Stock</a></li>
                                        <li><a href="#" class="text-decoration-none">Add Stock</a></li>
                                        <li><a href="#" class="text-decoration-none">Mark Out of Stock</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Announcements/Broadcast -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary-subtle text-primary me-3">
                                            <i class="fas fa-bullhorn"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Announcements</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Send Announcement</a></li>
                                        <li><a href="#" class="text-decoration-none">Broadcast Message</a></li>
                                        <li><a href="#" class="text-decoration-none">Announcement History</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Application Settings -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-secondary-subtle text-secondary me-3">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Application Settings</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Restaurant Info</a></li>
                                        <li><a href="#" class="text-decoration-none">Operating Hours</a></li>
                                        <li><a href="#" class="text-decoration-none">Tax Settings</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Backup & Restore -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="feature-card border h-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-info-subtle text-info me-3">
                                            <i class="fas fa-database"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold">Backup & Restore</h6>
                                    </div>
                                    <ul class="ps-3 mb-0">
                                        <li><a href="#" class="text-decoration-none">Export Data</a></li>
                                        <li><a href="#" class="text-decoration-none">Import Data</a></li>
                                        <li><a href="#" class="text-decoration-none">Automatic Backup</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to update the current date and time
    function updateDateTime() {
        const now = new Date();
        
        // Format the date: Weekday, Month Day, Year
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        const weekday = days[now.getDay()];
        const month = months[now.getMonth()];
        const day = now.getDate();
        const year = now.getFullYear();
        
        // Determine shift based on current hour
        let shift = "Morning Shift";
        const hour = now.getHours();
        if (hour >= 15 && hour < 22) {
            shift = "Evening Shift";
        } else if (hour >= 22 || hour < 7) {
            shift = "Night Shift";
        }
        
        // Format time in 12-hour format with AM/PM
        let hours = now.getHours();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        const minutes = now.getMinutes().toString().padStart(2, '0');
        
        // Combine all elements into the display format
        const dateTimeString = `${weekday}, ${month} ${day}, ${year} | ${shift} | ${hours}:${minutes} ${ampm}`;
        
        // Update the HTML
        document.getElementById('current-datetime').textContent = dateTimeString;
        document.getElementById('last-updated').textContent = `Last updated: ${hours}:${minutes} ${ampm}`;
    }
    
    // Call the function when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateDateTime();
        
        // Update the time every minute
        setInterval(updateDateTime, 60000);
    });
    
    // Auto refresh every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
</script>
</body>
</html>