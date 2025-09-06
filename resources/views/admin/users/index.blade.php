<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Gestion des utilisateurs - Equipment Tracker</title>
    
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
            <h1 class="app-title">Utilisateurs</h1>
        </div>
        
        <div>
            <a href="{{ route('admin.users.create') }}" class="equipment-detail-edit-btn">
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

        <!-- Users List -->
        @forelse($users as $user)
            <div class="content-section">
                <div class="admin-list-card">
                    <!-- Item Header -->
                    <div class="admin-list-header">
                        <div class="admin-list-photo">
                            <div class="admin-list-placeholder">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="admin-list-info">
                            <div class="admin-list-title">{{ $user->name }}</div>
                            <div class="admin-list-details">
                                <span class="admin-list-detail-item">
                                    <span class="admin-list-role admin-list-role-{{ $user->role }}">
                                        {{ $user->role === 'admin' ? 'ADMIN' : 'EMPLOYÉ' }}
                                    </span>
                                </span>
                                <span class="admin-list-detail-item">{{ $user->email }}</span>
                                @if($user->phone)
                                    <div class="admin-list-phone">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                            <path d="M22 16.92V19.92C22 20.4728 21.7893 21.0033 21.4142 21.4142C21.0391 21.8251 20.5304 22.0696 20 22.02C16.7564 21.692 13.611 20.5131 10.8589 18.5839C8.28779 16.8134 6.18408 14.7097 4.41382 12.1389C2.48863 9.38673 1.30964 6.24103 1.00001 2.98003C0.95159 2.45001 1.19579 1.94084 1.60665 1.56568C2.01751 1.19052 2.5475 0.98003 3.10001 0.98003H6.10001C6.95002 0.97003 7.76227 1.37003 8.26229 2.05003C8.76231 2.73003 8.89002 3.62003 8.60002 4.42003L7.53002 7.51003C7.37002 7.96003 7.47002 8.46003 7.79002 8.81003L9.32002 10.32C11.3 12.24 13.76 14.68 15.69 16.68L17.2 18.21C17.55 18.53 18.05 18.63 18.5 18.47L21.59 17.4C22.39 17.11 23.28 17.24 23.96 17.74C24.64 18.24 25.04 19.05 25.03 19.9L22 16.92Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $user->phone }}</span>
                                    </div>
                                @endif
                            </div>
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
                                    <a href="{{ route('admin.users.edit', $user) }}" class="admin-list-menu-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5 2.5C18.8978 2.10218 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10218 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10218 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Modifier
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                              onsubmit="return confirm('Supprimer {{ $user->name }}?')">
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
                                                <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            C'est vous
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
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        <path d="M23 21V19C23 18.1645 22.7155 17.3541 22.2094 16.7071C21.7033 16.0601 20.9979 15.6136 20.2 15.4373" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.13C16.7974 3.30657 17.5021 3.75307 18.0076 4.39993C18.5131 5.04679 18.7974 5.85717 18.7974 6.695C18.7974 7.53283 18.5131 8.34321 18.0076 8.99007C17.5021 9.63693 16.7974 10.0834 16 10.26" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="admin-empty-text">Aucun utilisateur trouvé</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        AJOUTER LE PREMIER UTILISATEUR
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="content-section">
                <div class="admin-pagination">
                    {{ $users->links() }}
                </div>
            </div>
        @endif

    </main>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>