{{-- Componente de filtros dinámicos con Alpine.js --}}
<div x-data="dynamicFilters()" class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Filtros</h3>
        <button 
            @click="clearFilters()" 
            class="text-sm text-gray-500 hover:text-gray-700"
        >
            Limpiar filtros
        </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Búsqueda --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Búsqueda
            </label>
            <input 
                type="text" 
                x-model="filters.search"
                @input="debouncedSearch()"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Buscar..."
            >
        </div>
        
        {{-- Categoría --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Categoría
            </label>
            <select 
                x-model="filters.categoria_id"
                @change="applyFilters()"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Todas las categorías</option>
                @if(isset($categorias))
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
        {{-- Temporada --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Temporada
            </label>
            <select 
                x-model="filters.temporada_id"
                @change="applyFilters()"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Todas las temporadas</option>
                @if(isset($temporadas))
                    @foreach($temporadas as $temporada)
                        <option value="{{ $temporada->id }}">{{ $temporada->nombre }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
        {{-- Ordenamiento --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Ordenar por
            </label>
            <select 
                x-model="filters.order_by"
                @change="applyFilters()"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="latest">Más recientes</option>
                <option value="oldest">Más antiguos</option>
                <option value="nombre_asc">Nombre A-Z</option>
                <option value="nombre_desc">Nombre Z-A</option>
                <option value="precio_asc">Precio menor</option>
                <option value="precio_desc">Precio mayor</option>
                <option value="stock_asc">Stock menor</option>
                <option value="stock_desc">Stock mayor</option>
            </select>
        </div>
    </div>
    
    {{-- Filtros avanzados (colapsables) --}}
    <div class="mt-4">
        <button 
            @click="$refs.advancedFilters.classList.toggle('hidden')"
            class="text-sm text-blue-600 hover:text-blue-800"
        >
            Filtros avanzados
        </button>
        
        <div x-ref="advancedFilters" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Stock mínimo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Stock mínimo
                </label>
                <input 
                    type="number" 
                    x-model="filters.stock_min"
                    @change="applyFilters()"
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="0"
                >
            </div>
            
            {{-- Stock máximo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Stock máximo
                </label>
                <input 
                    type="number" 
                    x-model="filters.stock_max"
                    @change="applyFilters()"
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="999"
                >
            </div>
            
            {{-- Precio mínimo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Precio mínimo
                </label>
                <input 
                    type="number" 
                    x-model="filters.precio_min"
                    @change="applyFilters()"
                    step="0.01"
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="0.00"
                >
            </div>
            
            {{-- Precio máximo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Precio máximo
                </label>
                <input 
                    type="number" 
                    x-model="filters.precio_max"
                    @change="applyFilters()"
                    step="0.01"
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="9999.99"
                >
            </div>
        </div>
    </div>
    
    {{-- Loading indicator --}}
    <div x-show="loading" class="mt-4 text-center">
        <div class="inline-flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Aplicando filtros...
        </div>
    </div>
</div>
