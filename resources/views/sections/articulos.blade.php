<?php
    /** @var \App\Models\Articulo $articulos **/
?>
@extends('layout.app')
@section('title', 'Artículos')
@section('content')
    <x-container-wrapp>
        <!-- Formulario de búsqueda y filtros -->
        <div class="mb-6">
            <form method="get" action="{{route('articulos.index')}}" class="space-y-4">
                <!-- Búsqueda principal -->
                <div class="max-w-md">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar artículos</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input
                            type="search"
                            name="search"
                            id="search"
                            class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Buscar por nombre, código o descripción"
                            value="{{ $filters['search'] ?? '' }}"
                        />
                    </div>
                </div>

                <!-- Filtros avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filtro por categoría -->
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
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
                        <label for="temporada_id" class="block text-sm font-medium text-gray-700 mb-2">Temporada</label>
                        <select name="temporada_id" id="temporada_id" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
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
                        <label for="order_by" class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                        <select name="order_by" id="order_by" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="latest" {{ ($filters['order_by'] ?? 'latest') == 'latest' ? 'selected' : '' }}>Más recientes</option>
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
                        <label for="per_page" class="block text-sm font-medium text-gray-700 mb-2">Por página</label>
                        <select name="per_page" id="per_page" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="8" {{ ($filters['per_page'] ?? 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="16" {{ ($filters['per_page'] ?? 8) == 16 ? 'selected' : '' }}>16</option>
                            <option value="24" {{ ($filters['per_page'] ?? 8) == 24 ? 'selected' : '' }}>24</option>
                            <option value="32" {{ ($filters['per_page'] ?? 8) == 32 ? 'selected' : '' }}>32</option>
                        </select>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-3">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>
                    
                    <a href="{{ route('articulos.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-6 py-3">
                        Limpiar filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Información de resultados -->
        @if($filters['search'] || $filters['categoria_id'] || $filters['temporada_id'])
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
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
            <h1 class="text-4xl font-bold text-gray-800">Artículos</h1>
            <a href="{{ route('articulos.create') }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Crear artículo nuevo
            </a>
        </div>

        <!-- Grid de artículos -->
        @if($articulos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mx-auto mb-5">
                @foreach($articulos as $articulo)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-200 dark:bg-gray-800 dark:border-gray-700 justify-center items-center mx-auto">
                    <a href="{{ route('articulos.show', $articulo) }}">
                        <img class="p-4 rounded-t-lg w-full h-48 object-cover {{ \App\Helpers\ImageHelper::getDefaultImageClass($articulo->imagen, 'default-articulo.svg') }}" 
                             src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                             alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($articulo->imagen, 'default-articulo.svg', $articulo->nombre, 'artículo') }}" />
                    </a>
                    <div class="px-5 pb-5">
                        <a href="{{ route('articulos.show', $articulo) }}">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white mb-2">{{ $articulo->nombre }}</h5>
                            <p class="text-sm text-gray-600 mb-1">Código: #{{ $articulo->codigo }}</p>
                            @if($articulo->categoria)
                                <p class="text-sm text-gray-500 mb-1">Categoría: {{ $articulo->categoria->nombre }}</p>
                            @endif
                            @if($articulo->temporada)
                                <p class="text-sm text-gray-500 mb-1">Temporada: {{ $articulo->temporada->nombre }}</p>
                            @endif
                        </a>
                        
                        <!-- Rating (placeholder) -->
                        <div class="flex items-center mt-2.5 mb-3">
                            <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-300' : 'text-gray-200' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded ms-3">4.0</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">$ {{ number_format($articulo->precio, 0, ',', '.') }}</span>
                            <a href="{{ route('articulos.show', $articulo) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación mejorada -->
            @if($articulos->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $articulos->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Mensaje cuando no hay resultados -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron artículos</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($filters['search'] || $filters['categoria_id'] || $filters['temporada_id'])
                        Intenta ajustar los filtros de búsqueda.
                    @else
                        No hay artículos disponibles en este momento.
                    @endif
                </p>
                @if($filters['search'] || $filters['categoria_id'] || $filters['temporada_id'])
                    <div class="mt-6">
                        <a href="{{ route('articulos.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Limpiar filtros
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </x-container-wrapp>
@endsection
