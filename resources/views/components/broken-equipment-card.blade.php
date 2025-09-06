@props(['equipment'])

<div class="broken-equipment-card">
    <!-- Equipment Photo -->
    <div class="broken-equipment-photo">
        @if($equipment->photo_path)
            <img src="{{ asset('storage/' . $equipment->photo_path) }}" 
                 alt="{{ $equipment->name }}"
                 class="broken-equipment-image">
        @else
            <div class="broken-equipment-placeholder">
                📦
            </div>
        @endif
        <!-- Broken overlay -->
        <div class="broken-overlay">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                <path d="M1 21L12 2L23 21H1Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 9V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 17H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>
    
    <!-- Equipment Info -->
    <div class="broken-equipment-info">
        <div class="broken-equipment-header">
            <h3 class="broken-equipment-name">{{ $equipment->name }}</h3>
        </div>
        
        <div class="broken-equipment-details">
            <p class="broken-equipment-location">
                <svg class="broken-equipment-icon" width="12" height="12" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                </svg>
                {{ $equipment->currentLocation->name }}
            </p>
            
            @if($equipment->notes)
                <p class="broken-equipment-notes">
                    "{{ $equipment->notes }}"
                </p>
            @endif
        </div>
    </div>
    
    <!-- Fix Button for Admin -->
    @if(auth()->user()->role === 'admin')
        <div class="broken-equipment-actions">
            <form method="POST" action="{{ route('admin.equipment.update', $equipment) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="available">
                <button type="submit" 
                        class="broken-equipment-fix-btn"
                        onclick="return confirm('Marquer {{ $equipment->name }} comme réparé?')">
                    RÉPARER
                </button>
            </form>
        </div>
    @endif
</div>