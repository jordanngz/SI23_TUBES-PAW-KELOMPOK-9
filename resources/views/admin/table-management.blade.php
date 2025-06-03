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
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
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
        .table-management { margin: 20px; }
        .table-card { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s; margin-bottom: 20px; }
        .table-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.2); }
        .table-card-header { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 20px; }
        .table-number { font-size: 1.5rem; font-weight: 600; margin: 0; }
        .status-badge { font-size: 0.8rem; padding: 5px 10px; border-radius: 20px; font-weight: 500; }
        .status-available { background-color: #d4edda; color: #155724; }
        .status-occupied { background-color: #f8d7da; color: #721c24; }
        .status-reserved { background-color: #fff3cd; color: #856404; }
        .table-info { padding: 20px; }
        .seats-info { display: flex; align-items: center; margin-bottom: 15px; color: #6c757d; }
        .seats-info i { margin-right: 8px; font-size: 1.1rem; }
        .action-buttons { display: flex; gap: 10px; }
        .btn-action { flex: 1; border-radius: 8px; font-weight: 500; transition: all 0.3s ease; }
        .btn-edit { background-color: #ffc107; color: #000; }
        .btn-edit:hover { background-color: #e0a800; color: #000; }
        .btn-delete { background-color: #dc3545; color: #fff; }
        .btn-delete:hover { background-color: #c82333; }
        .page-header { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white; padding: 30px 0; margin-bottom: 30px; border-radius: 0 0 20px 20px; }
        .add-table-btn { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); border: none; border-radius: 10px; padding: 12px 25px; font-weight: 600; transition: 0.3s; }
        .add-table-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }
        .modal-header { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white; border-radius: 10px 10px 0 0; }
        .modal-content { border-radius: 15px; border: none; }
        .form-control, .form-select { border-radius: 8px; border: 2px solid #e9ecef; transition: border-color 0.3s ease; }
        .form-control:focus, .form-select:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25); }
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
                    <li><a href="{{ route('admin.table.management') }}" class="nav-link active"><i class="fas fa-chair shortcut-icon me-2"></i>Table Management</a></li>
                    <li><a href="{{ route('admin.menu.management') }}" class="nav-link"><i class="fas fa-utensils me-2"></i>Menu Management</a></li>
                    <li><a href="{{ route('admin.transactions.index') }}" class="nav-link"><i class="fas fa-calendar-check me-2"></i>Reservations</a></li>
                    <li><a href="{{ route('admin.order') }}" class="nav-link"><i class="fas fa-shopping-cart me-2"></i>Orders</a></li>
                    <li><a href="{{ route('admin.reports') }}" class="nav-link"><i class="fas fa-chart-line me-2"></i>Reports</a></li>
                    <li><a href="{{ route('admin.users') }}" class="nav-link"><i class="fas fa-users me-2"></i>User Management</a></li>
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
            <div class="page-header">
                <div class="container d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fs-2 fw-bold mb-2">Table Management</h1>
                        <p class="mb-0 opacity-75">Manage your restaurant tables and their availability</p>
                    </div>
                    <button class="btn btn-light add-table-btn" data-bs-toggle="modal" data-bs-target="#addTableModal">
                        <i class="fas fa-plus me-2"></i> Add New Table
                    </button>
                </div>
            </div>

            <div class="container table-management">
                <div class="row">
                    @foreach ($tables as $table)
                    <div class="col-lg-4 col-md-6">
                        <div class="card table-card">
                            <div class="table-card-header d-flex justify-content-between align-items-center">
                                <h5 class="table-number">{{ $table->table_number }}</h5>
                                <span class="status-badge 
                                    {{ $table->status == 'available' ? 'status-available' : 
                                       ($table->status == 'occupied' ? 'status-occupied' : 'status-reserved') }}">
                                    @if ($table->status == 'available')
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    @elseif ($table->status == 'occupied')
                                        <i class="fas fa-users me-1"></i>Occupied
                                    @else
                                        <i class="fas fa-clock me-1"></i>Reserved
                                    @endif
                                </span>
                            </div>
                            <div class="table-info">
                                <div class="seats-info">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $table->seats }} seats</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-edit btn-action" data-bs-toggle="modal"
                                            data-bs-target="#editTableModal"
                                            onclick="editTable({{ $table->id }}, '{{ $table->table_number }}', {{ $table->seats }}, '{{ $table->status }}')">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.table.delete', $table->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete btn-action" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Table -->
<div class="modal fade" id="addTableModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.table.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Add Table</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Table Number</label>
                    <input type="text" name="table_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Number of Seats</label>
                    <input type="number" name="seats" class="form-control" min="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Add Table</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Table -->
<div class="modal fade" id="editTableModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editTableForm" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Table</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editTableId">
                <div class="mb-3">
                    <label class="form-label">Table Number</label>
                    <input type="text" name="table_number" id="editTableNumber" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Seats</label>
                    <input type="number" name="seats" id="editSeats" class="form-control" min="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="editStatus" class="form-select">
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal (Opsional)</label>
                    <input type="date" name="schedule_date" id="editScheduleDate" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam (Opsional)</label>
                    <input type="time" name="schedule_time" id="editScheduleTime" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function editTable(id, number, seats, status) {
        const form = document.getElementById('editTableForm');
        form.action = `/admin/table/${id}`;
        document.getElementById('editTableId').value = id;
        document.getElementById('editTableNumber').value = number;
        document.getElementById('editSeats').value = seats;
        document.getElementById('editStatus').value = status;
        document.getElementById('editScheduleDate').value = '';
        document.getElementById('editScheduleTime').value = '';
    }
</script>
</body>
</html>