<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="safe-area">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Prendre un outil - Equipment Tracker</title>
    
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
            <h1 class="app-title">Prendre un outil</h1>
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

        @if($errors->any())
            <div class="message message-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="content-section">
            <div class="equipment-take-card">
                <form method="POST" action="{{ route('rentals.store') }}">
                    @csrf
                    
                    <!-- Equipment Selection -->
                    <div class="equipment-take-section">
                        <h2 class="equipment-take-section-title">Équipement sélectionné</h2>
                        
                        @if(request('equipment_id'))
                            @php
                                $selectedEquipment = $availableEquipment->firstWhere('id', request('equipment_id'));
                            @endphp
                            @if($selectedEquipment)
                                <!-- Selected Equipment Display -->
                                <div class="equipment-take-selected">
                                    <div class="equipment-take-selected-photo">
                                        @if($selectedEquipment->photo_path)
                                            <img src="{{ asset('storage/' . $selectedEquipment->photo_path) }}" 
                                                 alt="{{ $selectedEquipment->name }}"
                                                 class="equipment-take-selected-image">
                                        @else
                                            <div class="equipment-take-selected-placeholder">
                                                📦
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="equipment-take-selected-info">
                                        <h3 class="equipment-take-selected-name">{{ $selectedEquipment->name }}</h3>
                                        <p class="equipment-take-selected-location">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                                            </svg>
                                            {{ $selectedEquipment->currentLocation->name }}
                                        </p>
                                        @if($selectedEquipment->type)
                                            <p class="equipment-take-selected-type">{{ $selectedEquipment->type }}</p>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="equipment_item_id" value="{{ $selectedEquipment->id }}">
                            @else
                                <div class="equipment-take-field">
                                    <label for="equipment_item_id" class="equipment-take-label">Équipement</label>
                                    <select name="equipment_item_id" id="equipment_item_id" class="equipment-take-select" required>
                                        <option value="">Sélectionner un équipement...</option>
                                        @foreach($availableEquipment as $equipment)
                                            <option value="{{ $equipment->id }}">
                                                {{ $equipment->name }} - {{ $equipment->currentLocation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @else
                            <div class="equipment-take-field">
                                <label for="equipment_item_id" class="equipment-take-label">Équipement</label>
                                <select name="equipment_item_id" id="equipment_item_id" class="equipment-take-select" required>
                                    <option value="">Sélectionner un équipement...</option>
                                    @foreach($availableEquipment as $equipment)
                                        <option value="{{ $equipment->id }}">
                                            {{ $equipment->name }} - {{ $equipment->currentLocation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>

                    <!-- User Assignment (Admin Only) -->
                    @if(auth()->user()->role === 'admin')
                        <div class="equipment-take-section">
                            <h2 class="equipment-take-section-title">Assigné à</h2>
                            
                            <div class="equipment-take-field">
                                <select name="user_id" id="user_id" class="equipment-take-select" required>
                                    <option value="">Sélectionner un utilisateur...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($user->id === auth()->id()) selected @endif>
                                            {{ $user->name }}@if($user->id === auth()->id()) (moi)@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <!-- Destination -->
                    <div class="equipment-take-section">
                        <h2 class="equipment-take-section-title">Destination</h2>
                        
                        <div class="equipment-take-field">
                            <select name="to_location_id" id="to_location_id" class="equipment-take-select" required>
                                <option value="">Sélectionner une destination...</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Notes (Optional) -->
                    <div class="equipment-take-section">
                        <h2 class="equipment-take-section-title">Notes (optionnel)</h2>
                        
                        <div class="equipment-take-field">
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3" 
                                      class="equipment-take-textarea"
                                      placeholder="Ex: Travaux de rénovation, intervention urgente...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="equipment-take-actions">
                        <button type="submit" class="btn btn-primary btn-full btn-large">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 8px;">
                                <path d="M21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18H19C20.1046 18 21 17.1046 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 10V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            CONFIRMER LA PRISE
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </main>

    <script>
        // Auto-select equipment if specified in URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const equipmentId = urlParams.get('equipment_id');
            if (equipmentId) {
                const select = document.getElementById('equipment_item_id');
                select.value = equipmentId;
            }
        });
    </script>

    <!-- Alpine.js for interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>