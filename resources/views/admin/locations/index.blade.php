<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Gestion des lieux - Equipment Tracker</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-container">

    <!-- App Header -->
    <header class="app-header">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="equipment-detail-back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        
        <div class="equipment-detail-title">
            <h1 class="app-title">Lieux</h1>
        </div>
        
        <div>
            <a href="{{ route('admin.locations.create') }}" class="equipment-detail-edit-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
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

        <!-- Locations List -->
        @forelse($locations as $location)
            <div class="content-section">
                <div class="admin-list-card">
                    <!-- Item Header -->
                    <div class="admin-list-header">
                        <div class="admin-list-photo">
                            <div class="admin-list-placeholder">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="admin-list-info">
                            <div class="admin-list-title">{{ $location->name }}</div>
                            <div class="admin-list-details">
                                <span class="admin-list-detail-item">
                                    <span class="admin-list-location-type admin-list-location-type-{{ $location->type }}">
                                        @switch($location->type)
                                            @case('warehouse') ENTREPÔT @break
                                            @case('client') CLIENT @break
                                            @case('job_site') CHANTIER @break
                                            @default {{ strtoupper($location->type) }}
                                        @endswitch
                                    </span>
                                </span>
                                <span class="admin-list-detail-item">
                                    <span class="admin-list-location-status admin-list-location-status-{{ $location->is_active ? 'active' : 'inactive' }}">
                                        {{ $location->is_active ? 'ACTIF' : 'INACTIF' }}
                                    </span>
                                </span>
                                <div class="admin-list-equipment-count">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18H19C20.1046 18 21 17.1046 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>{{ $location->equipment_items_count }} équipement{{ $location->equipment_items_count > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                            @if($location->address)
                                <div class="admin-list-address">{{ $location->address }}</div>
                            @endif
                        </div>
                        
                        <div class="admin-list-actions">
                            <div class="admin-list-actions-dropdown" x-data="{ open: false }">
                                <button @click="open = !open" class="admin-list-menu-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="1" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="12" cy="5" r="1" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="12" cy="19" r="1" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" 
                                     class="admin-list-menu"
                                     style="display: none;">
                                    <a href="{{ route('admin.locations.edit', $location) }}" class="admin-list-menu-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5 2.5C18.8978 2.10218 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10218 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10218 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Modifier
                                    </a>
                                    @if($location->equipment_items_count == 0)
                                        <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" 
                                              onsubmit="return confirm('Supprimer {{ $location->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-list-menu-item admin-list-menu-item-danger">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                    <polyline points="3,6 5,6 21,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    @else
                                        <div class="admin-list-menu-item admin-list-menu-item-disabled">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 9V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 17H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            Non supprimable
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="content-section">
                <div class="admin-empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                    </svg>
                    <p class="admin-empty-text">Aucun lieu trouvé</p>
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                        AJOUTER LE PREMIER LIEU
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($locations->hasPages())
            <div class="content-section">
                <div class="admin-pagination">
                    {{ $locations->links() }}
                </div>
            </div>
        @endif

    </main>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>