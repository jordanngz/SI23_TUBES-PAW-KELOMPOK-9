<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
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
                    <li><a href="{{ route('admin.menu.management') }}" class="nav-link active"><i class="fas fa-utensils me-2"></i>Menu Management</a></li>
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
            <div class="container py-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="fs-3 fw-bold">Menu Management</h1>
                    <!-- Button trigger Add Modal -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                        <i class="fas fa-plus"></i> Add Menu
                    </button>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                    <td>
                                    @if($product->image)
                                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:120px; max-height:80px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                    @else
                                        <img src="https://via.placeholder.com/120x80?text=No+Image" alt="{{ $product->name }}" style="max-width:120px; max-height:80px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                    @endif
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $product->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editMenuModal{{ $product->id }}" tabindex="-1" aria-labelledby="editMenuModalLabel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.menu.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editMenuModalLabel{{ $product->id }}">Edit Menu</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control" required value="{{ $product->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Description</label>
                                                                <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Price</label>
                                                                <input type="number" name="price" class="form-control" required value="{{ $product->price }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Image</label>
                                                                <input type="file" name="image" class="form-control">
                                                                @if($product->image)
                                                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:120px; max-height:80px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                                                @else
                                                                    <img src="https://via.placeholder.com/120x80?text=No+Image" alt="{{ $product->name }}" style="max-width:120px; max-height:80px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                                                @endif
                                                                <small class="text-muted d-block">Leave blank to keep current image.</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.menu.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @if($products->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No menu items found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuModalLabel">Add Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted d-block">Optional. jpg, jpeg, png, gif. Max 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>