<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $equipment->name }} - Equipment Tracker</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-container">

    <!-- App Header -->
    <header class="app-header">
        <div>
            <a href="{{ route('dashboard') }}" class="equipment-detail-back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        
        <div class="equipment-detail-title">
            <h1 class="app-title">{{ Str::limit($equipment->name, 25) }}</h1>
        </div>
        
        <div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.equipment.edit', $equipment) }}" class="equipment-detail-edit-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.5 2.5C18.8978 2.10218 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10218 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10218 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
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

        <!-- Equipment Photo with Overlay Info -->
        @if($equipment->photo_path)
            <div class="equipment-detail-photo-section">
                <img src="{{ asset('storage/' . $equipment->photo_path) }}" 
                     alt="{{ $equipment->name }}"
                     class="equipment-detail-photo">
                
                <!-- Status Badge (Top Right) -->
                <div class="equipment-detail-photo-status">
                    <span class="equipment-detail-overlay-status status-{{ $equipment->status }}">
                        @if($equipment->status === 'available') LIBRE
                        @elseif($equipment->status === 'rented') EN COURS
                        @elseif($equipment->status === 'broken') EN PANNE
                        @elseif($equipment->status === 'maintenance') MAINTENANCE
                        @else {{ strtoupper($equipment->status) }}
                        @endif
                    </span>
                </div>
                
                <!-- Overlay Info -->
                <div class="equipment-detail-photo-overlay">
                    <h2 class="equipment-detail-overlay-name">{{ $equipment->name }}</h2>
                    
                    <div class="equipment-detail-overlay-info">
                        <div class="equipment-detail-overlay-row">
                            @if($equipment->type)
                                <div class="equipment-detail-overlay-item">
                                    <span class="equipment-detail-overlay-value">{{ $equipment->type }}</span>
                                </div>
                            @endif
                            
                            <div class="equipment-detail-overlay-item">
                                <div class="equipment-detail-overlay-location">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                                    </svg>
                                    <span>{{ $equipment->currentLocation->name }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($equipment->notes)
                            <div class="equipment-detail-overlay-item">
                                <p class="equipment-detail-overlay-notes">{{ $equipment->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Status Section -->
        <div class="content-section">
            @if($equipment->status === 'rented' && $equipment->activeRental)
                <div class="equipment-detail-status-card equipment-detail-status-card-rented">
                    <h3 class="equipment-detail-status-title">En cours d'utilisation</h3>
                    
                    <div class="equipment-detail-rental-info">
                        <div class="equipment-detail-rental-row">
                            <span class="equipment-detail-rental-label">Par</span>
                            <span class="equipment-detail-rental-value">{{ $equipment->activeRental->user->name }}</span>
                        </div>
                        
                        <div class="equipment-detail-rental-row">
                            <span class="equipment-detail-rental-label">Destination</span>
                            <span class="equipment-detail-rental-value">{{ $equipment->activeRental->toLocation->name }}</span>
                        </div>
                        
                        <div class="equipment-detail-rental-row">
                            <span class="equipment-detail-rental-label">Pris le</span>
                            <span class="equipment-detail-rental-value">{{ $equipment->activeRental->taken_date->format('d/m/Y à H:i') }}</span>
                        </div>
                        
                        <div class="equipment-detail-rental-row">
                            <span class="equipment-detail-rental-label">Durée</span>
                            <span class="equipment-detail-rental-value">{{ $equipment->activeRental->taken_date->locale('fr')->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    @if($equipment->activeRental->user_id === auth()->id() || auth()->user()->role === 'admin')
                        <form method="POST" action="{{ route('rentals.return', $equipment->activeRental) }}" class="equipment-detail-action-form">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-primary btn-full"
                                    onclick="return confirm('Retourner {{ $equipment->name }}?')">
                                RETOURNER L'ÉQUIPEMENT
                            </button>
                        </form>
                    @endif
                </div>
            @elseif($equipment->status === 'available')
                <div class="equipment-detail-status-card equipment-detail-status-card-available">
                    <h3 class="equipment-detail-status-title">Disponible</h3>
                    <p class="equipment-detail-status-description">Cet équipement est disponible pour être emprunté.</p>
                    
                    <a href="{{ route('equipment.take') }}?equipment_id={{ $equipment->id }}" 
                       class="btn btn-primary btn-full">
                        EMPRUNTER CET ÉQUIPEMENT
                    </a>
                </div>
            @elseif($equipment->status === 'broken')
                <div class="equipment-detail-status-card equipment-detail-status-card-broken">
                    <h3 class="equipment-detail-status-title">En panne</h3>
                    <p class="equipment-detail-status-description">Cet équipement nécessite une réparation.</p>
                    @if($equipment->notes)
                        <p class="equipment-detail-broken-notes"><strong>Détails:</strong> {{ $equipment->notes }}</p>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                        <form method="POST" action="{{ route('admin.equipment.update', $equipment) }}" class="equipment-detail-action-form">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="available">
                            <button type="submit" 
                                    class="btn btn-full"
                                    style="background: var(--status-broken); color: white;"
                                    onclick="return confirm('Marquer {{ $equipment->name }} comme réparé?')">
                                MARQUER COMME RÉPARÉ
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        <!-- Rental History -->
        @if($equipment->rentals->count() > 0)
            <div class="content-section">
                <h2 class="section-header">Historique des locations</h2>
                
                <div class="rental-history-list">
                    @foreach($equipment->rentals->take(10) as $rental)
                        <div class="rental-history-item">
                            <div class="rental-history-header">
                                <div class="rental-history-user-location">
                                    <div class="rental-history-user">
                                        <strong>{{ $rental->user->name }}</strong>
                                    </div>
                                    <div class="rental-history-route">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                                        </svg>
                                        {{ $rental->fromLocation->name }} → {{ $rental->toLocation->name }}
                                    </div>
                                </div>
                                <div class="rental-history-status rental-history-status-{{ $rental->status }}">
                                    @if($rental->status === 'active') EN COURS
                                    @elseif($rental->status === 'completed' || $rental->status === 'returned') TERMINÉ
                                    @else {{ strtoupper($rental->status) }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="rental-history-details">
                                <div class="rental-history-dates">
                                    <span class="rental-history-date">
                                        Pris: {{ $rental->taken_date->format('d/m/Y H:i') }}
                                    </span>
                                    @if($rental->returned_date)
                                        <span class="rental-history-date">
                                            Retourné: {{ $rental->returned_date->format('d/m/Y H:i') }}
                                        </span>
                                    @else
                                        <span class="rental-history-date rental-history-duration">
                                            {{ $rental->taken_date->locale('fr')->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($rental->notes)
                                <div class="rental-history-notes">
                                    "{{ $rental->notes }}"
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>