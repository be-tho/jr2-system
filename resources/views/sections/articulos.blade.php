<?php
    /** @var \App\Models\Articulo $articulos **/
?>
@extends('layout.app')
@section('title', 'Artículos')
@section('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .group:hover .group-hover\:scale-105 {
        transform: scale(1.05);
    }
    
    .group:hover .group-hover\:text-primary-600 {
        color: #ec4899;
    }
    
    @media (max-width: 768px) {
        .grid {
            gap: 1rem;
        }
    }
</style>
@endsection
@section('content')
    <x-container-wrapp>
        <!-- Mensajes de notificación -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293a1 1 0 101.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293a1 1 0 00-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Formulario de búsqueda y filtros -->
        <div class="mb-6">
            <form method="get" action="{{route('articulos.index')}}" class="space-y-4">
                <!-- Búsqueda principal -->
                <div class="max-w-md">
                    <label for="search" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Buscar artículos</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-neutral-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input
                            type="search"
                            name="search"
                            id="search"
                            class="block w-full p-3 ps-10 text-sm text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Buscar por nombre, código o descripción"
                            value="{{ $filters['search'] ?? '' }}"
                        />
                    </div>
                </div>

                <!-- Filtros avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filtro por categoría -->
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ ($filters['categoria_id'] ?? '') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por temporada -->
                    <div>
                        <label for="temporada_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Temporada</label>
                        <select name="temporada_id" id="temporada_id" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas las temporadas</option>
                            @foreach($temporadas as $temporada)
                                <option value="{{ $temporada->id }}" {{ ($filters['temporada_id'] ?? '') == $temporada->id ? 'selected' : '' }}>
                                    {{ $temporada->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordenamiento -->
                    <div>
                        <label for="order_by" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Ordenar por</label>
                        <select name="order_by" id="order_by" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="latest" {{ ($filters['order_by'] ?? 'latest') == 'latest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="oldest" {{ ($filters['order_by'] ?? '') == 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                            <option value="nombre_asc" {{ ($filters['order_by'] ?? '') == 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                            <option value="nombre_desc" {{ ($filters['order_by'] ?? '') == 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
                            <option value="precio_asc" {{ ($filters['order_by'] ?? '') == 'precio_asc' ? 'selected' : '' }}>Precio menor</option>
                            <option value="precio_desc" {{ ($filters['order_by'] ?? '') == 'precio_desc' ? 'selected' : '' }}>Precio mayor</option>
                            <option value="stock_asc" {{ ($filters['order_by'] ?? '') == 'stock_asc' ? 'selected' : '' }}>Stock menor</option>
                            <option value="stock_desc" {{ ($filters['order_by'] ?? '') == 'stock_desc' ? 'selected' : '' }}>Stock mayor</option>
                        </select>
                    </div>

                    <!-- Elementos por página -->
                    <div>
                        <label for="per_page" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Por página</label>
                        <select name="per_page" id="per_page" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="12" {{ ($filters['per_page'] ?? 12) == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ ($filters['per_page'] ?? 12) == 24 ? 'selected' : '' }}>24</option>
                            <option value="36" {{ ($filters['per_page'] ?? 12) == 36 ? 'selected' : '' }}>36</option>
                            <option value="48" {{ ($filters['per_page'] ?? 12) == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3">
                    <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-6 py-3">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>
                    
                    <a href="{{ route('articulos.index') }}" class="text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 focus:ring-4 focus:outline-none focus:ring-neutral-300 font-medium rounded-lg text-sm px-6 py-3">
                        Limpiar filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Información de resultados -->
        @if($filters['search'] || $filters['categoria_id'] || $filters['temporada_id'])
            <div class="mb-4 p-4 bg-primary-50 dark:bg-primary-950/20 border border-primary-200 dark:border-primary-800 rounded-lg">
                <p class="text-sm text-primary-800 dark:text-primary-200">
                    <strong>Filtros aplicados:</strong>
                    @if($filters['search'])
                        Búsqueda: "{{ $filters['search'] }}"
                    @endif
                    @if($filters['categoria_id'])
                        @php $categoria = $categorias->firstWhere('id', $filters['categoria_id']); @endphp
                        @if($categoria) | Categoría: {{ $categoria->nombre }} @endif
                    @endif
                    @if($filters['temporada_id'])
                        @php $temporada = $temporadas->firstWhere('id', $filters['temporada_id']); @endphp
                        @if($temporada) | Temporada: {{ $temporada->nombre }} @endif
                    @endif
                    | Total: {{ $articulos->total() }} artículos
                </p>
            </div>
        @endif

        <!-- Header con título y botón crear -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Artículos</h1>
            <a href="{{ route('articulos.create') }}" class="text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Crear artículo nuevo
            </a>
        </div>

        <!-- Estadísticas de artículos -->
        <x-articulos-stats :articulos="$articulos" />

        <!-- Grid de artículos -->
        @if($articulos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($articulos as $articulo)
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden group">
                    <!-- Imagen del artículo -->
                    <div class="relative overflow-hidden">
                        <a href="{{ route('articulos.show', $articulo) }}" class="block">
                            <img class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 {{ \App\Helpers\ImageHelper::getDefaultImageClass($articulo->imagen, 'default-articulo.svg') }}" 
                                 src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                                 alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($articulo->imagen, 'default-articulo.svg', $articulo->nombre, 'artículo') }}" />
                        </a>
                        
                        <!-- Badge de stock -->
                        <div class="absolute top-3 right-3">
                            @if($articulo->stock > 10)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    En stock
                                </span>
                            @elseif($articulo->stock > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Stock bajo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Sin stock
                                </span>
                            @endif
                        </div>

                        <!-- Badge de precio -->
                        <div class="absolute bottom-3 left-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-white/90 text-gray-900 shadow-sm">
                                ${{ number_format($articulo->precio, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Contenido del artículo -->
                    <div class="p-5 space-y-3">
                        <!-- Nombre y código -->
                        <div>
                            <a href="{{ route('articulos.show', $articulo) }}" class="block">
                                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-1 group-hover:text-primary-600 transition-colors duration-200 line-clamp-2">
                                    {{ $articulo->nombre }}
                                </h3>
                            </a>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 font-mono">#{{ $articulo->codigo }}</p>
                        </div>

                        <!-- Categoría y temporada -->
                        <div class="flex flex-wrap gap-2">
                            @if($articulo->categoria)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $articulo->categoria->nombre }}
                                </span>
                            @endif
                            @if($articulo->temporada)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-secondary-100 dark:bg-secondary-900/20 text-secondary-800 dark:text-secondary-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $articulo->temporada->nombre }}
                                </span>
                            @endif
                        </div>

                        <!-- Stock -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-neutral-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                    Stock: <span class="font-semibold {{ $articulo->stock > 10 ? 'text-green-600' : ($articulo->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">{{ $articulo->stock }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('articulos.show', $articulo) }}" 
                               class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium py-2 px-4 rounded-lg text-center transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver
                            </a>
                            
                            <a href="{{ route('articulos.edit', $articulo) }}" 
                               class="bg-neutral-600 hover:bg-neutral-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($articulos->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $articulos->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Mensaje cuando no hay resultados -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No se encontraron artículos</h3>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    @if($filters['search'] || $filters['categoria_id'] || $filters['temporada_id'])
                        Intenta ajustar los filtros de búsqueda.
                    @else
                        No hay artículos disponibles en este momento.
                    @endif
                </p>
                @if($filters['search'] || $filters['categoria_id'] || $filters['temporada_id'])
                    <div class="mt-6">
                        <a href="{{ route('articulos.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            Limpiar filtros
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </x-container-wrapp>
@endsection
