<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Management</title>
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
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .table-management {
            margin: 20px;
        }
    </style>
</head>
<body>
&nbsp;
&nbsp;

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
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tables.index') }}" class="nav-link active">
                            <i class="fas fa-chair shortcut-icon me-2"></i>
                            Table Management
                        </a>
                    </li>
                    <!-- Other navigation items -->
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser 1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/32" alt="Admin" width="32" height="32" class="rounded-circle me-2">
                        <strong>Admin</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser 1">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
&nbsp;
&nbsp;

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-auto">
            <div class="container py-4 table-management">
                <h1 class="fs-3 fw-bold">Table Management</h1>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTableModal">
                    <i class="fas fa-plus me-2"></i> Add New Table
                </button>
&nbsp;
&nbsp;

                <!-- Table List -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Table Number</th>
                            <th>Seats</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr>
                            <td>1</td>
                            <td>Table 1</td>
                            <td>4</td>
                            <td>Available</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTableModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Repeat for more tables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
&nbsp;
&nbsp;

<!-- Add Table Modal -->
<div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTableModalLabel">Add New Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="tableNumber" class="form-label">Table Number</label>
                        <input type="text" class="form-control" id="tableNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="seats" class="form-label">Number of Seats</label>
                        <input type="number" class="form-control" id="seats" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Table</button>
            </div>
        </div>
    </div>
</div>
&nbsp;
&nbsp;

<!-- Edit Table Modal -->
<div class="modal fade" id="editTableModal" tabindex="-1" aria-labelledby="editTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTableModalLabel">Edit Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editTableNumber" class="form-label">Table Number</label>
                        <input type="text" class="form-control" id="editTableNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSeats" class="form-label">Number of Seats</label>
                        <input type="number" class="form-control" id="editSeats" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
&nbsp;
&nbsp;

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>