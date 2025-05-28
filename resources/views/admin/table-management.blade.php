<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Management - Kerapu Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }
        .table-management {
            margin: 20px;
        }
        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .table-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .table-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
        .table-number {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        .status-available {
            background-color: #d4edda;
            color: #155724;
        }
        .status-occupied {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-reserved {
            background-color: #fff3cd;
            color: #856404;
        }
        .table-info {
            padding: 20px;
        }
        .seats-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #6c757d;
        }
        .seats-info i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-action {
            flex: 1;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
        .btn-edit:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #000;
        }
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            border-radius: 0 0 20px 20px;
        }
        .add-table-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .add-table-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
                    <i class="fas fa-utensils me-2 fs-4"></i>
                    <span class="fs-4">Kerapu Fine Dining</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link active">
                            <i class="fas fa-chair me-2"></i>
                            Table Management
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Reservations
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
                            <i class="fas fa-receipt me-2"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-bar me-2"></i>
                            Analytics
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
            <div class="page-header">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fs-2 fw-bold mb-2">Table Management</h1>
                            <p class="mb-0 opacity-75">Manage your restaurant tables and their availability</p>
                        </div>
                        <button class="btn btn-light add-table-btn" data-bs-toggle="modal" data-bs-target="#addTableModal">
                            <i class="fas fa-plus me-2"></i> Add New Table
                        </button>
                    </div>
                </div>
            </div>

            <div class="container table-management">
                <!-- Table Cards Grid -->
                <div class="row">
                @foreach ($tables as $table)
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="table-number">{{ $table->table_number }}</h5>
                                    <span class="status-badge 
                                        {{ $table->status == 'available' ? 'status-available' : ($table->status == 'reserved' ? 'status-reserved' : 'status-occupied') }}">
                                        <i class="fas 
                                            {{ $table->status == 'available' ? 'fa-check-circle' : ($table->status == 'reserved' ? 'fa-clock' : 'fa-users') }} me-1"></i>
                                        {{ ucfirst($table->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $table->seats }} seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editTableModal"
                                        onclick="editTable({{ $table->id }}, '{{ $table->table_number }}', {{ $table->seats }}, '{{ $table->status }}')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.table.delete', $table->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-delete btn-action" onclick="return confirm('Are you sure you want to delete this table?')">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


                    <!-- Table 2 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="table-number">Table 2</h5>
                                    <span class="status-badge status-occupied">
                                        <i class="fas fa-users me-1"></i>Occupied
                                    </span>
                                </div>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>2 seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editTableModal" onclick="editTable(2, 'Table 2', 2, 'occupied')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-delete btn-action" onclick="deleteTable(2)">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table 3 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="table-number">Table 3</h5>
                                    <span class="status-badge status-available">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                </div>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>6 seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editTableModal" onclick="editTable(3, 'Table 3', 6, 'available')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-delete btn-action" onclick="deleteTable(3)">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table 4 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="table-number">Table 4</h5>
                                    <span class="status-badge status-reserved">
                                        <i class="fas fa-clock me-1"></i>Reserved
                                    </span>
                                </div>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>4 seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editTableModal" onclick="editTable(4, 'Table 4', 4, 'reserved')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-delete btn-action" onclick="deleteTable(4)">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table 5 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="table-number">Table 5</h5>
                                    <span class="status-badge status-available">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                </div>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>8 seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editTableModal" onclick="editTable(5, 'Table 5', 8, 'available')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-delete btn-action" onclick="deleteTable(5)">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table 6 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="table-number">Table 6</h5>
                                    <span class="status-badge status-occupied">
                                        <i class="fas fa-users me-1"></i>Occupied
                                    </span>
                                </div>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>2 seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editTableModal" onclick="editTable(6, 'Table 6', 2, 'occupied')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-delete btn-action" onclick="deleteTable(6)">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Table Modal -->
<div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTableModalLabel">
                    <i class="fas fa-plus me-2"></i>Add New Table
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTableForm" method="POST" action="{{ route('admin.table.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tableNumber" class="form-label">
                            <i class="fas fa-tag me-2"></i>Table Number
                        </label>
                        <input type="text" class="form-control" id="tableNumber" name="table_number" placeholder="Enter table number" required>
                    </div>
                    <div class="mb-3">
                        <label for="seats" class="form-label">
                            <i class="fas fa-users me-2"></i>Number of Seats
                        </label>
                        <input type="number" class="form-control" id="seats" name="seats" placeholder="Enter number of seats" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="fas fa-info-circle me-2"></i>Status
                        </label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="reserved">Reserved</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Table
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editTableModal" tabindex="-1" aria-labelledby="editTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTableModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Table
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTableForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editTableId" name="id">
                    <div class="mb-3">
                        <label for="editTableNumber" class="form-label">
                            <i class="fas fa-tag me-2"></i>Table Number
                        </label>
                        <input type="text" class="form-control" id="editTableNumber" name="table_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSeats" class="form-label">
                            <i class="fas fa-users me-2"></i>Number of Seats
                        </label>
                        <input type="number" class="form-control" id="editSeats" name="seats" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">
                            <i class="fas fa-info-circle me-2"></i>Status
                        </label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="reserved">Reserved</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hanya fungsi ini yang dipertahankan karena penting untuk set nilai ke form edit
    function editTable(id, tableNumber, seats, status) {
        document.getElementById('editTableId').value = id;
        document.getElementById('editTableNumber').value = tableNumber;
        document.getElementById('editSeats').value = seats;
        document.getElementById('editStatus').value = status;

        // Set form action ke endpoint update Laravel
        const form = document.getElementById('editTableForm');
        form.action = `/admin/table/${id}`;
    }

    // Fungsi delete menggunakan form agar sesuai dengan Laravel
    function deleteTable(id) {
        if (confirm(`Are you sure you want to delete Table ${id}?`)) {
            // Submit form delete
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/table/${id}`;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}'; // Laravel token

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Optional: Hover effect (boleh dipertahankan)
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.table-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>


</body>
</html>