@props(['equipment', 'clickable' => true])

<div class="equipment-card @if($clickable) touch-feedback @endif">
    <!-- Equipment Photo -->
    <div class="equipment-photo-container">
        @if($equipment->photo_path)
            <img src="{{ asset('storage/' . $equipment->photo_path) }}" 
                 alt="{{ $equipment->name }}"
                 class="equipment-photo">
        @else
            <div class="equipment-photo-placeholder">
                📦
            </div>
        @endif
    </div>
    
    <!-- Status Indicator -->
    <div class="status-indicator status-{{ $equipment->status }}"></div>
    
    <!-- Equipment Info -->
    <div class="equipment-info">
        <!-- Header with name -->
        <div class="equipment-header">
            <h3 class="equipment-name">{{ Str::limit($equipment->name, 20) }}</h3>
        </div>
        
        <!-- Meta information -->
        <div class="equipment-meta">
            <div class="equipment-location">
                <svg class="location-icon" width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                </svg>
                {{ $equipment->currentLocation->name }}
            </div>
        </div>
    </div>
</div>