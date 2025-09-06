<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Ajouter un équipement - Equipment Tracker</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-container">

    <!-- App Header -->
    <header class="app-header">
        <div>
            <a href="{{ route('admin.equipment.index') }}" class="equipment-detail-back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        
        <div class="equipment-detail-title">
            <h1 class="app-title">Ajouter équipement</h1>
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
                <form method="POST" action="{{ route('admin.equipment.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de l'équipement *
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name') }}"
                               placeholder="ex: Perceuse Bosch, Scie circulaire..."
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type d'équipement
                        </label>
                        <input type="text" name="type" id="type"
                               value="{{ old('type') }}"
                               placeholder="ex: Perceuse, Scie, Marteau..."
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Serial Number -->
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Numéro de série
                        </label>
                        <input type="text" name="serial_number" id="serial_number"
                               value="{{ old('serial_number') }}"
                               placeholder="ex: ABC123456"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        @error('serial_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Statut *
                        </label>
                        <select name="status" id="status" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choisir un statut...</option>
                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="rented" {{ old('status') === 'rented' ? 'selected' : '' }}>En cours d'utilisation</option>
                            <option value="broken" {{ old('status') === 'broken' ? 'selected' : '' }}>En panne</option>
                            <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="current_location_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Emplacement actuel *
                        </label>
                        <select name="current_location_id" id="current_location_id" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choisir un emplacement...</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" 
                                        {{ old('current_location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('current_location_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photo -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Photo de l'équipement
                        </label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF (max 2MB)</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (optionnel)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Remarques, état de l'équipement, instructions spéciales...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-4 pt-4">
                        <button type="submit" class="primary-button flex-1">
                            CRÉER L'ÉQUIPEMENT
                        </button>
                        <a href="{{ route('admin.equipment.index') }}" 
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