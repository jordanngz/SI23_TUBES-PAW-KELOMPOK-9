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
                <li><a href="#special-requests">Special Requests</a></li>
                <li><a href="{{ route('payment.status.final') }}">Payment Status</a></li>
                <li><a href="#confirmation">Confirmation</a></li>
            </ul>
        </div>

        <div class="sidebar-section">   
        <h4>Your Reservation</h4>

        @if ($userReservation && $userReservation->table)
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
                            <img src="https://source.unsplash.com/300x200/?restaurant,table,{{ $table->id }}" alt="Table {{ $table->id }}">
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

            <div class="section-title" id="special-requests">
                <h2>Special Requests</h2>
                <p>Let us know if you have any special requirements</p>
            </div>
            <div class="special-requests-form">
                <textarea placeholder="Please let us know if you have any special requests..."></textarea>
            </div>

            <div class="reservation-actions">
                <button class="back-btn">Back</button>
                <button class="next-btn">Proceed to Menu Selection</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
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
