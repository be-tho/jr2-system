<?php
    /** @var \App\Models\Costurero $costureros **/
?>
@extends('layout.app')
@section('title', 'Costureros')
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
    
    .search-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z'/%3e%3c/svg%3e");
        background-position: 12px center;
        background-repeat: no-repeat;
        background-size: 20px;
        padding-left: 44px;
    }
    
    .dark .search-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%39ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z'/%3e%3c/svg%3e");
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .stats-card-blue {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stats-card-green {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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

        <!-- Header de la sección -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Costureros</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Gestiona el listado de costureros del sistema</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('costureros.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nuevo Costurero
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario de búsqueda y filtros -->
        <div class="mb-6">
            <form method="get" action="{{route('costureros.index')}}" class="space-y-4">
                <!-- Búsqueda principal -->
                <div class="max-w-md">
                    <label for="search" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Buscar costureros</label>
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
                            placeholder="Buscar por nombre, celular o dirección"
                            value="{{ $filters['search'] ?? '' }}"
                        />
                    </div>
                </div>

                <!-- Filtros avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Ordenamiento -->
                    <div>
                        <label for="order_by" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Ordenar por</label>
                        <select name="order_by" id="order_by" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="latest" {{ ($filters['order_by'] ?? 'latest') == 'latest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="oldest" {{ ($filters['order_by'] ?? '') == 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                            <option value="nombre_asc" {{ ($filters['order_by'] ?? '') == 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                            <option value="nombre_desc" {{ ($filters['order_by'] ?? '') == 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
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
                    <x-buttons.primary type="submit">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </x-buttons.primary>
                    
                    <x-buttons.secondary href="{{ route('costureros.index') }}">
                        Limpiar filtros
                    </x-buttons.secondary>
                </div>
            </form>
        </div>

        <!-- Información de resultados -->
        @if($filters['search'])
            <div class="mb-4 p-4 bg-primary-50 dark:bg-primary-950/20 border border-primary-200 dark:border-primary-800 rounded-lg">
                <p class="text-sm text-primary-800 dark:text-primary-200">
                    <strong>Filtros aplicados:</strong>
                    @if($filters['search'])
                        Búsqueda: "{{ $filters['search'] }}"
                    @endif
                    | Total: {{ $costureros->total() }} costureros
                </p>
            </div>
        @endif

        <!-- Estadísticas rápidas -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-neutral-800 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Costureros</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $costureros->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listado de costureros -->
        @if($costureros->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($costureros as $costurero)
                    <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 group">
                        <div class="p-6">
                            <!-- Header del card -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 transition-colors duration-200">
                                        {{ $costurero->nombre_completo }}
                                    </h3>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                        ID: {{ $costurero->id }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('costureros.show', $costurero) }}" class="p-2 text-neutral-400 hover:text-primary-600 transition-colors duration-200" title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('costureros.edit', $costurero) }}" class="p-2 text-neutral-400 hover:text-blue-600 transition-colors duration-200" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Información del costurero -->
                            <div class="space-y-3">
                                <!-- Celular -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-neutral-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-sm text-neutral-600 dark:text-neutral-300">{{ $costurero->celular }}</span>
                                </div>

                                <!-- Dirección -->
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-300 line-clamp-2">{{ $costurero->direccion }}</p>
                                </div>

                                <!-- Fecha de registro -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-neutral-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                        Registrado: {{ $costurero->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Acciones del card -->
                            <div class="mt-6 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <div class="flex space-x-2">
                                    <a href="{{ route('costureros.show', $costurero) }}" class="flex-1 text-center px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        Ver Detalles
                                    </a>
                                    <a href="{{ route('costureros.edit', $costurero) }}" class="flex-1 text-center px-3 py-2 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $costureros->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-neutral-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">No hay costureros registrados</h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">Comienza agregando el primer costurero al sistema.</p>
                <a href="{{ route('costureros.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Agregar Primer Costurero
                </a>
            </div>
        @endif
    </x-container-wrapp>
@endsection
