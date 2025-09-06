@props(['rental'])

<div class="rental-list-card">
    <!-- Equipment Photo -->
    <div class="rental-list-photo">
        @if($rental->equipment->photo_path)
            <img src="{{ asset('storage/' . $rental->equipment->photo_path) }}" 
                 alt="{{ $rental->equipment->name }}"
                 class="rental-list-image">
        @else
            <div class="rental-list-placeholder">
                📦
            </div>
        @endif
    </div>
    
    <!-- Rental Info -->
    <div class="rental-list-info">
        <div class="rental-list-header">
            <h3 class="rental-list-name">{{ $rental->equipment->name }}</h3>
        </div>
        
        <div class="rental-list-details">
            <p class="rental-list-user">{{ $rental->user->name }}</p>
            <p class="rental-list-location">
                <svg class="rental-list-icon" width="12" height="12" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                </svg>
                {{ $rental->toLocation->name }}
            </p>
            <p class="rental-list-date">{{ $rental->taken_date->locale('fr')->diffForHumans() }}</p>
        </div>
    </div>
    
    <!-- Return Button -->
    @if($rental->user_id === auth()->id() || auth()->user()->role === 'admin')
        <div class="rental-list-actions">
            <form method="POST" action="{{ route('rentals.return', $rental) }}">
                @csrf
                <button type="submit" 
                        class="rental-list-return-btn"
                        onclick="return confirm('Retourner {{ $rental->equipment->name }}?')">
                    RETOUR
                </button>
            </form>
        </div>
    @endif
</div>