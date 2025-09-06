<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Modifier {{ $location->name }} - Equipment Tracker</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-container">

    <!-- App Header -->
    <header class="app-header">
        <div>
            <a href="{{ route('admin.locations.index') }}" class="equipment-detail-back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        
        <div class="equipment-detail-title">
            <h1 class="app-title">Modifier lieu</h1>
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

        <div class="content-section">
            <div class="admin-form-card">
                <form method="POST" action="{{ route('admin.locations.update', $location) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom du lieu *
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name', $location->name) }}"
                               placeholder="ex: Bureau principal, Entrepôt A, Chantier Rivière Noire..."
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type de lieu *
                        </label>
                        <select name="type" id="type" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="warehouse" {{ old('type', $location->type) === 'warehouse' ? 'selected' : '' }}>Entrepôt</option>
                            <option value="client" {{ old('type', $location->type) === 'client' ? 'selected' : '' }}>Chez client</option>
                            <option value="job_site" {{ old('type', $location->type) === 'job_site' ? 'selected' : '' }}>Chantier</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse (optionnel)
                        </label>
                        <textarea name="address" id="address" rows="3"
                                  class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Adresse complète du lieu...">{{ old('address', $location->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $location->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Lieu actif (disponible pour les équipements)
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-4 pt-4">
                        <button type="submit" class="primary-button flex-1">
                            SAUVEGARDER
                        </button>
                        <a href="{{ route('admin.locations.index') }}" 
                           class="flex-1 text-center py-4 px-6 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </main>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>