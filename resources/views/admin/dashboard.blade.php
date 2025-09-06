<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Administration - Equipment Tracker</title>
    
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
            <h1 class="app-title">Administration</h1>
        </div>
        
        <div>
            <!-- Empty space for symmetry -->
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

        <!-- Stats Grid -->
        <div class="content-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_equipment'] }}</div>
                    <div class="stat-label">Équipements</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_users'] }}</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_locations'] }}</div>
                    <div class="stat-label">Lieux</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number stat-number-accent">{{ $stats['active_rentals'] }}</div>
                    <div class="stat-label">En cours</div>
                </div>
            </div>
        </div>

        <!-- Management Sections -->
        
        <!-- Equipment Management -->
        <div class="content-section">
            <div class="admin-section-card">
                <div class="admin-section-header">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18H19C20.1046 18 21 17.1046 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 10V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h2 class="admin-section-title">Équipements</h2>
                </div>
                
                <div class="admin-section-actions">
                    <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary btn-full">
                        GÉRER LES ÉQUIPEMENTS
                    </a>
                    <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary btn-full">
                        AJOUTER ÉQUIPEMENT
                    </a>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="content-section">
            <div class="admin-section-card">
                <div class="admin-section-header">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        <path d="M23 21V19C23 18.1645 22.7155 17.3541 22.2094 16.7071C21.7033 16.0601 20.9979 15.6136 20.2 15.4373" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.13C16.7974 3.30657 17.5021 3.75307 18.0076 4.39993C18.5131 5.04679 18.7974 5.85717 18.7974 6.695C18.7974 7.53283 18.5131 8.34321 18.0076 8.99007C17.5021 9.63693 16.7974 10.0834 16 10.26" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h2 class="admin-section-title">Utilisateurs</h2>
                </div>
                
                <div class="admin-section-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-full">
                        GÉRER LES UTILISATEURS
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-full">
                        AJOUTER UTILISATEUR
                    </a>
                </div>
            </div>
        </div>

        <!-- Location Management -->
        <div class="content-section">
            <div class="admin-section-card">
                <div class="admin-section-header">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                    </svg>
                    <h2 class="admin-section-title">Lieux</h2>
                </div>
                
                <div class="admin-section-actions">
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary btn-full">
                        GÉRER LES LIEUX
                    </a>
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-full">
                        AJOUTER LIEU
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>