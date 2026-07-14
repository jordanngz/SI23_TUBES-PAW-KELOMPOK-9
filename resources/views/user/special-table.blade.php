<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Table Reservation — Kerapu Fine Dining</title>
    <meta name="description" content="Reserve an exclusive private dining experience at Kerapu Fine Dining. Perfect for anniversaries, birthdays, corporate events, and proposals.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        try {
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "background": "#16130c",
                            "on-surface": "#eae1d4",
                            "surface-container-low": "#1f1b13",
                            "surface-container-high": "#2e2921",
                            "surface": "#16130c",
                            "surface-variant": "#39342b",
                            "outline-variant": "#4e4636",
                            "stone-surface": "#1E1E1E",
                            "on-surface-variant": "#d1c5b0",
                            "ivory-text": "#F5F5F5",
                            "surface-container-highest": "#39342b",
                            "obsidian-deep": "#0A0A0A",
                            "on-primary-container": "#6e5300",
                            "champagne-lowlight": "#2D2A22",
                            "secondary-container": "#474746",
                            "surface-container": "#231f17",
                            "gold-leaf": "#F5C754",
                            "gold-muted": "#A68A46",
                            "outline": "#9a907c",
                            "on-background": "#eae1d4",
                            "primary": "#ffe7b4",
                            "on-primary": "#3f2e00",
                            "on-secondary-container": "#b7b5b4",
                        },
                        "fontFamily": {
                            "body-md": ["DM Sans"],
                            "headline-md": ["Playfair Display"],
                            "display-lg": ["Playfair Display"],
                            "display-lg-mobile": ["Playfair Display"],
                            "body-lg": ["DM Sans"],
                            "subheading-sm": ["DM Sans"],
                        },
                        "fontSize": {
                            "label-sm":  ["12px", { "lineHeight": "1.2", "fontWeight": "500" }],
                            "body-md":   ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                            "headline-md": ["32px", { "lineHeight": "1.3", "fontWeight": "600" }],
                            "display-lg": ["64px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                            "display-lg-mobile": ["40px", { "lineHeight": "1.2", "fontWeight": "700" }],
                            "body-lg":   ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                            "subheading-sm": ["14px", { "lineHeight": "1.5", "letterSpacing": "0.15em", "fontWeight": "600" }],
                        },
                        "spacing": {
                            "container-max": "1200px",
                            "margin-mobile": "1.25rem",
                            "gutter": "2rem",
                            "section-gap": "8rem",
                            "element-gap": "1.5rem",
                        },
                    },
                },
            }
        } catch (_e) {}
    </script>
    <style>
        .gold-border-focus:focus {
            outline: none;
            border-color: #F5C754;
            box-shadow: 0 1px 0 0 #F5C754;
        }
        select option { background-color: #2e2921; color: #F5F5F5; }
        input[type="checkbox"]:checked { background-color: #F5C754; border-color: #F5C754; }
        input[type="radio"]:checked { background-color: #F5C754; border-color: #F5C754; }
        .table-card { transition: all 0.3s ease; border: 1px solid transparent; }
        .table-card:hover { border-color: rgba(245,199,84,0.4); transform: translateY(-2px); }
        .table-card.selected { border-color: #F5C754 !important; background: rgba(245,199,84,0.05); }
        .fade-in { animation: fadeIn 1.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .skeleton { animation: pulse 1.5s infinite; background: linear-gradient(90deg, #2e2921 25%, #39342b 50%, #2e2921 75%); background-size: 200% 100%; }
        @keyframes pulse { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-gold-leaf selection:text-obsidian-deep">

{{-- TopNavBar --}}
<nav class="fixed top-0 w-full z-50 flex justify-between items-center px-[1.25rem] md:px-[2rem] h-24 bg-background border-b border-[#2D2A22]/30">
    <a href="{{ route('home') }}" class="font-['Playfair_Display'] text-[32px] font-semibold text-gold-leaf">
        KERAPU
    </a>
    <div class="hidden md:flex gap-8 items-center font-['DM_Sans'] text-[14px] uppercase tracking-widest">
        <a href="{{ route('menu') }}" class="text-on-surface-variant hover:text-gold-leaf transition-colors duration-300">The Menu</a>
        <a href="{{ route('special.table') }}" class="text-gold-leaf">Private Dining</a>
        <a href="{{ route('home') }}" class="text-on-surface-variant hover:text-gold-leaf transition-colors duration-300">Our Story</a>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('reserve') }}" class="bg-gold-leaf text-obsidian-deep px-6 py-2 font-['DM_Sans'] text-[14px] tracking-widest uppercase transition-transform duration-200 hover:scale-95 font-bold">
            RESERVE
        </a>
        @auth
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-on-surface-variant hover:text-gold-leaf text-[14px] font-['DM_Sans'] uppercase tracking-widest transition-colors">
                Logout
            </button>
        </form>
        @endauth
    </div>
</nav>

<main class="pt-24 min-h-screen">

    {{-- ===== HERO SECTION ===== --}}
    <header class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center brightness-50"
                 style="background-image: url('{{ asset('images/background.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-background/50"></div>
        </div>
        <div class="relative z-10 text-center px-[1.25rem] fade-in">
            <div class="inline-flex items-center gap-2 mb-4 bg-gold-leaf/10 border border-gold-leaf/30 px-4 py-1 rounded-full">
                <span class="material-symbols-outlined text-gold-leaf text-sm" style="font-variation-settings:'FILL' 1; font-size:14px;">stars</span>
                <span class="font-['DM_Sans'] text-[12px] text-gold-leaf uppercase tracking-widest">The VIP Experience</span>
            </div>
            <h1 class="font-['Playfair_Display'] text-[40px] md:text-[64px] font-bold text-ivory-text mb-6 leading-tight">
                ✨ Special Table Reservation
            </h1>
            <p class="font-['DM_Sans'] text-[18px] text-on-surface-variant max-w-2xl mx-auto leading-relaxed">
                Secure an evening of unparalleled intimacy. Our special tables offer curated sensory journeys designed for the most significant milestones.
            </p>
        </div>
    </header>

    {{-- ===== ALERT MESSAGES ===== --}}
    @if(session('error'))
    <div class="max-w-[1200px] mx-auto px-[1.25rem] md:px-[2rem] mt-6">
        <div class="bg-red-900/20 border border-red-500/40 text-red-300 px-6 py-4 font-['DM_Sans'] text-[14px] flex items-center gap-3">
            <span class="material-symbols-outlined text-red-400" style="font-size:18px;">error</span>
            {{ session('error') }}
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="max-w-[1200px] mx-auto px-[1.25rem] md:px-[2rem] mt-6">
        <div class="bg-green-900/20 border border-green-500/40 text-green-300 px-6 py-4 font-['DM_Sans'] text-[14px] flex items-center gap-3">
            <span class="material-symbols-outlined text-green-400" style="font-size:18px;">check_circle</span>
            {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- ===== MAIN CONTENT ===== --}}
    <section class="max-w-[1200px] mx-auto px-[1.25rem] md:px-[2rem] py-[8rem] grid grid-cols-1 lg:grid-cols-12 gap-16">

        {{-- ===== LEFT: RESERVATION FORM ===== --}}
        <div class="lg:col-span-7 bg-surface-container-low p-8 md:p-12 border border-[#2D2A22]/30">
            <h2 class="font-['Playfair_Display'] text-[32px] font-semibold text-gold-leaf mb-12">
                Reservation Details
            </h2>

            @if($errors->any())
            <div class="mb-8 bg-red-900/20 border border-red-500/30 p-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="font-['DM_Sans'] text-[14px] text-red-300">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="specialTableForm" action="{{ route('special.table.store') }}" method="POST" class="space-y-10">
                @csrf
                {{-- Hidden: selected table_id --}}
                <input type="hidden" name="table_id" id="selected_table_id" value="{{ old('table_id') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    {{-- Event Type --}}
                    <div class="relative group">
                        <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-2">
                            Event Type
                        </label>
                        <select name="event_type" id="event_type"
                                class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant text-ivory-text py-3 px-0 font-['DM_Sans'] text-[16px] gold-border-focus appearance-none cursor-pointer">
                            @foreach(['Anniversary', 'Birthday', 'Corporate Event', 'Proposal', 'Other'] as $type)
                            <option value="{{ $type }}" {{ old('event_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Party Size --}}
                    <div class="relative group">
                        <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-2">
                            Party Size (Min. 6)
                        </label>
                        <input type="number" name="party_size" id="party_size"
                               min="6" value="{{ old('party_size', 6) }}"
                               class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant text-ivory-text py-3 px-0 font-['DM_Sans'] text-[16px] gold-border-focus">
                    </div>

                    {{-- Date --}}
                    <div class="relative group">
                        <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-2">
                            Select Date
                        </label>
                        <input type="date" name="date" id="reservation_date"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('date') }}"
                               class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant text-ivory-text py-3 px-0 font-['DM_Sans'] text-[16px] gold-border-focus dark:[color-scheme:dark]">
                    </div>

                    {{-- Time --}}
                    <div class="relative group">
                        <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-2">
                            Select Time
                        </label>
                        <input type="time" name="time" id="reservation_time"
                               value="{{ old('time', '19:00') }}"
                               class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant text-ivory-text py-3 px-0 font-['DM_Sans'] text-[16px] gold-border-focus dark:[color-scheme:dark]">
                    </div>

                </div>

                {{-- Decoration Requests --}}
                <div>
                    <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-6">
                        Enhance Your Atmosphere
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach([
                            'flowers'        => '🌸 Flowers',
                            'balloons'       => '🎈 Balloons',
                            'candles'        => '🕯️ Candles',
                            'custom_banner'  => '🪧 Custom Banner',
                            'live_music'     => '🎵 Live Music',
                        ] as $value => $label)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox"
                                   name="decoration_request[]"
                                   value="{{ $value }}"
                                   {{ in_array($value, old('decoration_request', [])) ? 'checked' : '' }}
                                   class="w-5 h-5 bg-transparent border-gold-muted text-gold-leaf rounded-none focus:ring-0 focus:ring-offset-0">
                            <span class="font-['DM_Sans'] text-[16px] text-on-surface-variant group-hover:text-gold-leaf transition-colors">
                                {{ $label }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Menu Preference --}}
                <div>
                    <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-6">
                        Menu Preference
                    </label>
                    <div class="flex gap-10">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="menu_preference" value="set_menu"
                                   {{ old('menu_preference') === 'set_menu' ? 'checked' : '' }}
                                   class="w-5 h-5 bg-transparent border-gold-muted text-gold-leaf focus:ring-0 focus:ring-offset-0">
                            <span class="font-['DM_Sans'] text-[16px] text-on-surface-variant group-hover:text-gold-leaf transition-colors">
                                Set Menu
                            </span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="menu_preference" value="a_la_carte"
                                   {{ old('menu_preference', 'a_la_carte') === 'a_la_carte' ? 'checked' : '' }}
                                   class="w-5 h-5 bg-transparent border-gold-muted text-gold-leaf focus:ring-0 focus:ring-offset-0">
                            <span class="font-['DM_Sans'] text-[16px] text-on-surface-variant group-hover:text-gold-leaf transition-colors">
                                À La Carte
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Contact & Notes --}}
                <div class="space-y-10">
                    <div class="relative group">
                        <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-2">
                            Phone Number
                        </label>
                        <input type="tel" name="phone"
                               value="{{ old('phone') }}"
                               placeholder="+62 812-3456-7890"
                               class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant text-ivory-text py-3 px-0 font-['DM_Sans'] text-[16px] gold-border-focus placeholder:text-outline">
                    </div>
                    <div class="relative group">
                        <label class="block font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-2">
                            Special Requests
                        </label>
                        <textarea name="special_request" rows="3"
                                  placeholder="Tell us about dietary restrictions or specific table preferences..."
                                  class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant text-ivory-text py-3 px-0 font-['DM_Sans'] text-[16px] gold-border-focus resize-none placeholder:text-outline">{{ old('special_request') }}</textarea>
                    </div>
                </div>

            </form>
        </div>

        {{-- ===== RIGHT: TABLE SELECTION + SUMMARY ===== --}}
        <div class="lg:col-span-5 flex flex-col gap-8">

            {{-- Available Special Tables --}}
            <div class="bg-surface-container-highest p-8 border border-gold-leaf/20">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-['DM_Sans'] text-[14px] font-bold text-gold-leaf uppercase tracking-widest">
                        Available Special Tables
                    </h3>
                    <button id="refreshTablesBtn" onclick="loadAvailableTables()"
                            class="text-gold-muted hover:text-gold-leaf transition-colors font-['DM_Sans'] text-[12px] uppercase tracking-widest flex items-center gap-1">
                        <span class="material-symbols-outlined" style="font-size:16px;">refresh</span>
                        Search
                    </button>
                </div>

                {{-- Tables Container --}}
                <div id="tablesContainer" class="space-y-6">
                    {{-- Initial state --}}
                    <div id="tablesInitial" class="text-center py-8">
                        <span class="material-symbols-outlined text-gold-muted mb-3 block" style="font-size:48px; font-variation-settings:'FILL' 0;">table_restaurant</span>
                        <p class="font-['DM_Sans'] text-[14px] text-on-surface-variant">
                            Fill in your date, time, and party size above,<br>then click <strong class="text-gold-leaf">Search</strong> to see available tables.
                        </p>
                    </div>
                    {{-- Loading skeleton --}}
                    <div id="tablesLoading" class="hidden space-y-4">
                        <div class="skeleton h-32 w-full rounded"></div>
                        <div class="skeleton h-32 w-full rounded"></div>
                    </div>
                    {{-- Tables list --}}
                    <div id="tablesList" class="hidden space-y-6"></div>
                    {{-- No tables found --}}
                    <div id="tablesEmpty" class="hidden text-center py-8">
                        <span class="material-symbols-outlined text-outline mb-3 block" style="font-size:48px;">event_busy</span>
                        <p class="font-['DM_Sans'] text-[14px] text-on-surface-variant">
                            No special tables available for the selected time.<br>
                            <span class="text-gold-muted">Try a different date or time.</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Summary & CTA --}}
            <div class="bg-obsidian-deep p-8 border border-[#2D2A22] shadow-2xl">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <p class="font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-1">
                            Selected Table
                        </p>
                        <p id="selectedTableName" class="font-['Playfair_Display'] text-[24px] font-semibold text-gold-leaf">
                            None selected
                        </p>
                        <p id="selectedTableSeats" class="font-['DM_Sans'] text-[12px] text-on-surface-variant mt-1"></p>
                    </div>
                    <div class="text-right">
                        <p class="font-['DM_Sans'] text-[12px] text-gold-muted uppercase tracking-widest mb-1">Status</p>
                        <p id="selectedTableStatus" class="font-['DM_Sans'] text-[14px] text-outline italic">—</p>
                    </div>
                </div>

                <button id="submitBtn" onclick="submitReservation()"
                        disabled
                        class="w-full bg-gold-leaf text-obsidian-deep py-5 font-['DM_Sans'] text-[14px] uppercase tracking-[0.2em] font-bold flex items-center justify-center gap-3 group transition-all hover:bg-gold-muted disabled:opacity-40 disabled:cursor-not-allowed">
                    Continue to Menu
                    <span class="material-symbols-outlined transition-transform group-hover:translate-x-2">arrow_forward</span>
                </button>
                <p class="mt-4 text-center font-['DM_Sans'] text-[12px] text-outline italic">
                    Final selection of dishes and wine will be required on the next step.
                </p>
            </div>

        </div>
    </section>
</main>

{{-- Footer --}}
<footer class="w-full py-[8rem] px-[1.25rem] md:px-[2rem] flex flex-col items-center text-center gap-[1.5rem] bg-obsidian-deep">
    <div class="font-['Playfair_Display'] text-[40px] font-bold text-gold-leaf">KERAPU</div>
    <div class="flex flex-wrap justify-center gap-8 font-['DM_Sans'] text-[16px] text-gold-muted">
        <a href="#" class="hover:text-gold-leaf transition-all opacity-80 hover:opacity-100">Privacy Policy</a>
        <a href="#" class="hover:text-gold-leaf transition-all opacity-80 hover:opacity-100">Terms of Service</a>
        <a href="#" class="hover:text-gold-leaf transition-all opacity-80 hover:opacity-100">Accessibility</a>
    </div>
    <div class="mt-8 font-['DM_Sans'] text-[16px] text-on-surface-variant uppercase tracking-widest opacity-60">
        © {{ date('Y') }} KERAPU FINE DINING. ALL RIGHTS RESERVED.
    </div>
</footer>

<script>
    const AVAILABLE_URL = "{{ route('special.table.available') }}";
    const CSRF_TOKEN    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let selectedTable = null;

    // ─── Load available special tables via AJAX ─────────────────────────────
    async function loadAvailableTables() {
        const date      = document.getElementById('reservation_date').value;
        const time      = document.getElementById('reservation_time').value;
        const partySize = document.getElementById('party_size').value;

        if (!date || !time || !partySize) {
            alert('Please fill in Date, Time, and Party Size first.');
            return;
        }

        // Show loading
        document.getElementById('tablesInitial').classList.add('hidden');
        document.getElementById('tablesLoading').classList.remove('hidden');
        document.getElementById('tablesList').classList.add('hidden');
        document.getElementById('tablesEmpty').classList.add('hidden');

        try {
            const params = new URLSearchParams({ date, time, party_size: partySize });
            const res    = await fetch(`${AVAILABLE_URL}?${params}`, {
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            });
            const data = await res.json();

            document.getElementById('tablesLoading').classList.add('hidden');

            if (!data.tables || data.tables.length === 0) {
                document.getElementById('tablesEmpty').classList.remove('hidden');
                return;
            }

            renderTables(data.tables);
            document.getElementById('tablesList').classList.remove('hidden');
        } catch (err) {
            document.getElementById('tablesLoading').classList.add('hidden');
            document.getElementById('tablesEmpty').classList.remove('hidden');
            console.error('Failed to load tables:', err);
        }
    }

    // ─── Render table cards ──────────────────────────────────────────────────
    function renderTables(tables) {
        const container = document.getElementById('tablesList');
        container.innerHTML = '';

        tables.forEach(table => {
            const card = document.createElement('div');
            card.className = 'table-card cursor-pointer p-0 overflow-hidden';
            card.dataset.id    = table.id;
            card.dataset.name  = table.table_number;
            card.dataset.seats = table.seats;

            const badgeText  = table.seats >= 10 ? 'PREMIUM' : 'EXCLUSIVE';
            const imagePath  = table.image
                ? `/images/${table.image}`
                : 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80';

            card.innerHTML = `
                <div class="relative overflow-hidden" style="aspect-ratio:16/10;">
                    <div class="w-full h-full bg-cover bg-center transition-transform duration-700 hover:scale-110"
                         style="background-image:url('${imagePath}');"></div>
                    <div class="absolute top-4 right-4 bg-gold-leaf text-obsidian-deep px-3 py-1 text-[10px] font-bold tracking-tighter flex items-center gap-1">
                        <span class="material-symbols-outlined" style="font-size:12px; font-variation-settings:'FILL' 1;">auto_awesome</span>
                        ${badgeText}
                    </div>
                </div>
                <div class="p-4 flex justify-between items-start">
                    <div>
                        <h4 class="font-['Playfair_Display'] text-[18px] font-semibold text-ivory-text">${table.table_number}</h4>
                        <p class="font-['DM_Sans'] text-[12px] text-on-surface-variant">Capacity: ${table.seats} guests</p>
                    </div>
                    <span class="font-['DM_Sans'] text-[14px] font-bold text-gold-leaf">VIP</span>
                </div>
            `;

            card.addEventListener('click', () => selectTable(table, card));
            container.appendChild(card);
        });
    }

    // ─── Select a table ──────────────────────────────────────────────────────
    function selectTable(table, cardEl) {
        // Reset all cards
        document.querySelectorAll('.table-card').forEach(c => c.classList.remove('selected'));
        // Highlight selected
        cardEl.classList.add('selected');

        selectedTable = table;
        document.getElementById('selected_table_id').value = table.id;

        // Update summary
        document.getElementById('selectedTableName').textContent  = table.table_number;
        document.getElementById('selectedTableSeats').textContent = `Capacity: ${table.seats} guests`;
        document.getElementById('selectedTableStatus').textContent = 'Available ✓';
        document.getElementById('selectedTableStatus').className   = 'font-["DM_Sans"] text-[14px] text-green-400';

        // Enable submit
        document.getElementById('submitBtn').disabled = false;
    }

    // ─── Submit form ─────────────────────────────────────────────────────────
    function submitReservation() {
        if (!selectedTable) {
            alert('Please select a table first.');
            return;
        }
        document.getElementById('specialTableForm').submit();
    }

    // ─── Auto-trigger search when all key fields are filled ─────────────────
    ['reservation_date', 'reservation_time', 'party_size'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', () => {
            const d = document.getElementById('reservation_date').value;
            const t = document.getElementById('reservation_time').value;
            const p = document.getElementById('party_size').value;
            if (d && t && p >= 6) loadAvailableTables();
        });
    });
</script>
</body>
</html>
