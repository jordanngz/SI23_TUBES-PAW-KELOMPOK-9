<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kerapu Fine Dining - Table Reservation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleseat.css') }}">
    <style>
    /* Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    color: #333;
    background-color: #f9f9f9;
    line-height: 1.6;
}

h1, h2, h3, h4 {
    font-family: 'Playfair Display', serif;
    font-weight: 600;
}

.container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar Styles */
.sidebar {
    width: 300px;
    background-color: #1a1a1a;
    color: #fff;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
}

.logo {
    margin-bottom: 2rem;
    text-align: center;
}

.logo h3 {
    font-size: 1.5rem;
    color: #e0c080;
    letter-spacing: 1px;
}

.sidebar-section {
    margin-bottom: 2rem;
}

.sidebar-section h4 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #e0c080;
}

.sidebar-menu {
    list-style: none;
}

.sidebar-menu li {
    margin-bottom: 0.8rem;
}

.sidebar-menu a {
    color: #fff;
    text-decoration: none;
    font-size: 0.95rem;
    display: block;
    padding: 0.5rem 0;
    transition: color 0.3s;
}

.sidebar-menu a:hover {
    color: #e0c080;
}

.sidebar-menu li.active a {
    color: #e0c080;
    font-weight: 500;
}

.reservation-status {
    color: #999;
    font-style: italic;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.reservation-details {
    margin-bottom: 1.5rem;
}

.reservation-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.continue-btn {
    width: 100%;
    padding: 0.8rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.continue-btn:hover {
    background-color: #d4b06e;
}

/* Main Content Styles */
.main-content {
    flex-grow: 1;
    margin-left: 300px;
    padding: 2rem;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header h1 {
    font-size: 2.2rem;
    color: #333;
}

.date-picker input {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
}

.reservation-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.section-title {
    margin-bottom: 1.5rem;
}

.section-title h2 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.section-title p {
    color: #666;
}

.time-selection {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    align-items: center;
}

.time-selection label {
    font-size: 0.9rem;
    color: #666;
}

.time-selection select {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
}

.tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.table-card {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s;
    cursor: pointer;
}

.table-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.table-image {
    height: 200px;
    overflow: hidden;
}

.table-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.table-card:hover .table-image img {
    transform: scale(1.05);
}

.table-info {
    padding: 1.5rem;
}

.table-info h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.table-info p {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.table-status {
    display: inline-block;
    padding: 0.3rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.table-status.available {
    background-color: #e8f5e9;
    color: #4CAF50;
}

.table-status.reserved {
    background-color: #ffebee;
    color: #F44336;
}

.restaurant-layout {
    position: relative;
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 3rem;
}

.floor-plan {
    width: 100%;
    height: auto;
    display: block;
}

.layout-legend {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
}

.legend-color {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: inline-block;
}

.legend-color.available {
    background-color: #4CAF50;
}

.legend-color.reserved {
    background-color: #F44336;
}

.special-requests-form {
    margin-bottom: 2rem;
}

.special-requests-form textarea {
    width: 100%;
    height: 120px;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    resize: vertical;
}

.reservation-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
}

.back-btn {
    padding: 0.8rem 1.5rem;
    background-color: #fff;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.back-btn:hover {
    background-color: #f5f5f5;
}

.next-btn {
    padding: 0.8rem 1.5rem;
    background-color: #e0c080;
    color: #1a1a1a;
    border: none;
    border-radius: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.next-btn:hover {
    background-color: #d4b06e;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .menu-toggle {
        display: block;
    }
}

@media (max-width: 768px) {
    .tables-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
    
    .header h1 {
        font-size: 1.8rem;
    }
    
    .time-selection {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .time-selection select {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .tables-grid {
        grid-template-columns: 1fr;
    }
    
    .main-content {
        padding: 1rem;
    }
    
    .header h1 {
        font-size: 1.5rem;
    }
    
    .reservation-container {
        padding: 1.5rem;
    }
    
    .reservation-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .back-btn, .next-btn {
        width: 100%;
    }
    
    .layout-legend {
        position: relative;
        bottom: auto;
        right: auto;
        margin-top: 1rem;
    }
}

.payment-card {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 24px;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: box-shadow 0.3s ease;
}

.payment-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.payment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.payment-id {
    font-weight: 600;
    font-size: 16px;
    color: #333;
}

.payment-status {
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 13px;
    font-weight: 500;
    text-transform: uppercase;
}

.payment-status.pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.payment-status.paid {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.payment-status.confirmed {
    background-color: #d4edda;
    color: #1cca45;
    border: 1px solid #c3e6cb;
}

.payment-info {
    margin-top: 20px;
}

.payment-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 15px;
    color: #444;
}

.payment-value {
    font-weight: 500;
    color: #000;
}

.payment-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.cancel-btn, .pay-btn {
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.cancel-btn {
    background-color: #f8d7da;
    color: #721c24;
}

.cancel-btn:hover {
    background-color: #f5c6cb;
}

.pay-btn {
    background-color: #cce5ff;
    color: #004085;
}

.pay-btn:hover {
    background-color: #b8daff;
}
        .reservation-details { display: none; }
        .table-card { cursor: pointer; }
        .table-card.selected {
            border: 2px solid #ffd700;
            box-shadow: 0 0 10px #ffd700;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo"><h3>Kerapu Fine Dining</h3></div>

        <div class="sidebar-section">
            <h4>Reservation</h4>
            <ul class="sidebar-menu">
                <li class="active"><a href="#table-selection">Table Selection</a></li>
                <li><a href="{{ route('menu') }}">Menu Selection</a></li>
                <li><a href="#table-layout">Table Layout</a></li>
                <li><a href="{{ route('payment.status.final') }}">Payment Status</a></li>
            </ul>
        </div>

        <div class="sidebar-section">   
            <h4>Your Reservation</h4>
            @php
                $temp = session('temp_reservation');
            @endphp

            @if ($temp)
                <div class="reservation-details" style="display:block">
                    <div class="reservation-item">
                        <span>Table:</span> 
                        <span id="selected-table">
                            {{ $temp['table']['table_number'] ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="reservation-item">
                        <span>Date:</span> 
                        <span id="selected-date">
                            {{ \Carbon\Carbon::parse($temp['reserved_at'])->format('Y-m-d') }}
                        </span>
                    </div>
                    <div class="reservation-item">
                        <span>Time:</span> 
                        <span id="selected-time">
                            {{ \Carbon\Carbon::parse($temp['reserved_at'])->format('H:i') }}
                        </span>
                    </div>
                    <div class="reservation-item">
                        <span>Guests:</span> 
                        <span id="selected-guests">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
            @elseif ($userReservation && $userReservation->table)
                <div class="reservation-details" style="display:block">
                    <div class="reservation-item">
                        <span>Table:</span> 
                        <span id="selected-table">
                            {{ $userReservation->table->table_number ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="reservation-item">
                        <span>Date:</span> 
                        <span id="selected-date">
                            {{ \Carbon\Carbon::parse($userReservation->reserved_at)->format('Y-m-d') }}
                        </span>
                    </div>
                    <div class="reservation-item">
                        <span>Time:</span> 
                        <span id="selected-time">
                            {{ \Carbon\Carbon::parse($userReservation->reserved_at)->format('H:i') }}
                        </span>
                    </div>
                    <div class="reservation-item">
                        <span>Guests:</span> 
                        <span id="selected-guests">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
            @else
                <p class="reservation-status">No table selected yet</p>
                <div class="reservation-details">
                    <div class="reservation-item">
                        <span>Table:</span> <span id="selected-table">-</span>
                    </div>
                    <div class="reservation-item">
                        <span>Date:</span> <span id="selected-date">-</span>
                    </div>
                    <div class="reservation-item">
                        <span>Time:</span> <span id="selected-time">-</span>
                    </div>
                    <div class="reservation-item">
                        <span>Guests:</span> <span id="selected-guests">-</span>
                    </div>
                </div>
            @endif

            <a href="{{ route('menu') }}">
                <button class="continue-btn">Continue to Menu</button>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Table Reservation</h1>
            <div class="date-picker">
                <input type="date" id="reservation-date" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="reservation-container">
            <div class="section-title">
                <h2>Seat Information</h2>
                <p>Select a table for your dining experience</p>
            </div>

            <div class="time-selection">
                <label for="reservation-time">Select Time:</label>
                <select id="reservation-time">
                    <option value="17:00">5:00 PM</option>
                    <option value="17:30">5:30 PM</option>
                    <option value="18:00">6:00 PM</option>
                    <option value="18:30">6:30 PM</option>
                    <option value="19:00" selected>7:00 PM</option>
                    <option value="19:30">7:30 PM</option>
                    <option value="20:00">8:00 PM</option>
                    <option value="20:30">8:30 PM</option>
                    <option value="21:00">9:00 PM</option>
                </select>

                <label for="party-size">Party Size:</label>
                <select id="party-size">
                    <option value="1">1 Person</option>
                    <option value="2" selected>2 People</option>
                    <option value="3">3 People</option>
                    <option value="4">4 People</option>
                    <option value="5">5 People</option>
                    <option value="6">6 People</option>
                    <option value="7+">7+ People</option>
                </select>
            </div>

            <div class="tables-grid">
                @foreach ($tables as $table)
                    <div class="table-card {{ $userReservation && $userReservation->table_id == $table->id ? 'selected' : '' }}"
                         data-table="{{ $table->id }}"
                         data-status="{{ $table->status }}">
                        <div class="table-image">
                           <img src="{{ asset('storage/' . $table->image) }}" alt="Table Image"> 
                        </div>
                        <div class="table-info">
                            <h3>Table {{ $table->table_number }}</h3>
                            <p>Suitable for {{ $table->seats }} people</p>
                            <div class="table-status {{ $table->status }}">
                                {{ $table->status === 'available' ? 'Available' : 'Already Reserved' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="reservation-actions">
                <button class="back-btn" onclick="window.location.href='{{ route('home') }}'">Back</button>
                <button class="next-btn" onclick="window.location.href='{{ route('menu') }}'">Proceed to Menu Selection</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Sinkronkan dropdown dengan query string saat halaman dimuat
window.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const partySize = params.get('party_size');
    const time = params.get('time');
    const date = params.get('date');

    if (partySize) {
        document.getElementById('party-size').value = partySize;
    }
    if (time) {
        document.getElementById('reservation-time').value = time;
    }
    if (date) {
        document.getElementById('reservation-date').value = date;
    }
});

// Filtering: reload table list when date, time, or party size changes
document.getElementById('reservation-date').addEventListener('change', filterTables);
document.getElementById('reservation-time').addEventListener('change', filterTables);
document.getElementById('party-size').addEventListener('change', filterTables);

function filterTables() {
    const date = document.getElementById('reservation-date').value;
    const time = document.getElementById('reservation-time').value;
    const partySize = document.getElementById('party-size').value;
    window.location.href = `?date=${date}&time=${time}&party_size=${partySize}`;
}

// Reservasi meja
document.querySelectorAll('.table-card').forEach(card => {
    card.addEventListener('click', () => {
        const status = card.getAttribute('data-status');
        const tableId = card.getAttribute('data-table');
        const tableName = card.querySelector('h3').innerText;
        const date = document.getElementById('reservation-date').value;
        const time = document.getElementById('reservation-time').value;
        const reservedAt = `${date}T${time}`;
        const guests = "{{ Auth::user()->name }}";

        if (status === 'available') {
            if (confirm(`Do you want to reserve ${tableName}?`)) {
                fetch("{{ route('reserve.temp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        table_id: tableId,
                        reserved_at: reservedAt
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();  
                })
                .catch(() => alert('Failed to reserve table.'));
            }
        } else {
            alert('Sorry, this table is already reserved.');
        }

        // Optional: update sidebar reservation info (jika ingin interaktif tanpa reload)
        document.querySelector('.reservation-status').style.display = 'none';
        document.querySelector('.reservation-details').style.display = 'block';
        document.getElementById('selected-table').innerText = tableName;
        document.getElementById('selected-date').innerText = date;
        document.getElementById('selected-time').innerText = time;
        document.getElementById('selected-guests').innerText = guests;
    });
});
</script>
</body>
</html>