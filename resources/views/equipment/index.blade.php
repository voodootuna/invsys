<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                    ← Retour
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tous les outils
                </h2>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">
                    {{ $equipment->count() }} outils trouvés
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Search and Filters -->
            <div class="mb-6">
                <form method="GET" action="{{ route('equipment.index') }}" class="space-y-4">
                    <!-- Search -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            🔍
                        </span>
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Rechercher un outil..."
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Filters -->
                    <div class="flex gap-4">
                        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Disponibles</option>
                            <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>En cours</option>
                            <option value="broken" {{ request('status') === 'broken' ? 'selected' : '' }}>En panne</option>
                        </select>
                        
                        <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">Tous les types</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Equipment Grid -->
            @if($equipment->count() > 0)
                <div class="equipment-grid">
                    @foreach($equipment as $item)
                        <a href="{{ route('equipment.show', $item) }}">
                            <x-equipment-card :equipment="$item" />
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun outil trouvé</h3>
                    <p class="text-gray-500">Essayez de modifier vos critères de recherche.</p>
                    <a href="{{ route('equipment.index') }}" class="inline-block mt-4 text-blue-500 hover:text-blue-700">
                        Afficher tous les outils
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>