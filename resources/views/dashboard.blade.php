<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Equipment Tracker</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-container">

    <!-- App Header -->
    <header class="app-header">
        <div>
            <!-- User Profile -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = ! open" class="equipment-detail-back-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-20"
                     style="display: none;">
                    <div class="px-4 py-2 text-xs text-gray-500 border-b">
                        {{ Auth::user()->name }}
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profil
                    </a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Administration
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="equipment-detail-title">
            <h1 class="app-title">Equipment Tracker</h1>
        </div>
        
        <div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="equipment-detail-edit-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @else
                <!-- Empty space for symmetry -->
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="message message-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="message message-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Stats Row -->
        <div class="content-section">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-number available">{{ $stats['available'] }}</div>
                    <div class="stat-label">Libres</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number rented">{{ $stats['active_rentals'] }}</div>
                    <div class="stat-label">En cours</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number broken">{{ $stats['broken'] }}</div>
                    <div class="stat-label">En panne</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="content-section">
            <a href="{{ route('equipment.take') }}" class="btn btn-primary btn-large btn-full">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 8px;">
                    <path d="M21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18H19C20.1046 18 21 17.1046 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 10V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                PRENDRE ÉQUIPEMENT
            </a>
        </div>

        <!-- Search -->
        <div class="content-section">
            <div class="search-container">
                <form method="GET" action="{{ route('equipment.index') }}">
                    <div class="search-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                            <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <input type="search" 
                           name="search" 
                           placeholder="Rechercher un équipement..." 
                           class="form-input search-input">
                </form>
            </div>
        </div>

        <!-- Available Equipment -->
        @if($availableEquipment->count() > 0)
            <div class="content-section">
                <h2 class="section-header">Disponibles ({{ $availableEquipment->count() }})</h2>
                
                <div class="equipment-grid">
                    @foreach($availableEquipment as $equipment)
                        <a href="{{ route('equipment.show', $equipment) }}">
                            <x-equipment-card :equipment="$equipment" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Active Rentals -->
        @if($activeRentals->count() > 0)
            <div class="content-section">
                <h2 class="section-header">En cours ({{ $activeRentals->count() }})</h2>
                
                <div class="rental-list">
                    @foreach($activeRentals as $rental)
                        <x-rental-card :rental="$rental" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Broken Equipment -->
        @if($brokenEquipment->count() > 0)
            <div class="content-section">
                <h2 class="section-header">En panne ({{ $brokenEquipment->count() }})</h2>
                
                <div class="broken-equipment-list">
                    @foreach($brokenEquipment as $equipment)
                        <x-broken-equipment-card :equipment="$equipment" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($availableEquipment->count() === 0 && $activeRentals->count() === 0 && $brokenEquipment->count() === 0)
            <div class="content-section" style="text-align: center; padding: var(--space-12) var(--space-4);">
                <div style="font-size: 48px; margin-bottom: var(--space-4);">📦</div>
                <h3 class="section-header">Aucun équipement</h3>
                <p style="color: var(--gray-500);">Les équipements apparaîtront ici une fois ajoutés.</p>
            </div>
        @endif

    </main>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>