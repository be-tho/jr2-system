<?php
    /** @var \App\Models\Corte $cortes */
?>
@extends('layout.app')
@section('title', 'Cortes')
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
            <form method="get" action="{{route('cortes.index')}}" class="space-y-4">
                <!-- Búsqueda principal -->
                <div class="max-w-md">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar cortes</label>
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
                            placeholder="Buscar por número de corte o nombre"
                            value="{{ request()->search }}"
                        />
                    </div>
                </div>

                <!-- Filtros avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filtro por estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" id="estado" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="0" {{ request()->estado == '0' ? 'selected' : '' }}>Cortado</option>
                            <option value="1" {{ request()->estado == '1' ? 'selected' : '' }}>Costurando</option>
                            <option value="2" {{ request()->estado == '2' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>

                    <!-- Filtro por fecha -->
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <select name="fecha" id="fecha" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las fechas</option>
                            <option value="today" {{ request()->fecha == 'today' ? 'selected' : '' }}>Hoy</option>
                            <option value="week" {{ request()->fecha == 'week' ? 'selected' : '' }}>Esta semana</option>
                            <option value="month" {{ request()->fecha == 'month' ? 'selected' : '' }}>Este mes</option>
                        </select>
                    </div>

                    <!-- Ordenamiento -->
                    <div>
                        <label for="order_by" class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                        <select name="order_by" id="order_by" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="latest" {{ (request()->order_by ?? 'latest') == 'latest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="oldest" {{ request()->order_by == 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                            <option value="numero_asc" {{ request()->order_by == 'numero_asc' ? 'selected' : '' }}>Número A-Z</option>
                            <option value="numero_desc" {{ request()->order_by == 'numero_desc' ? 'selected' : '' }}>Número Z-A</option>
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
                    
                    <a href="{{ route('cortes.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-6 py-3">
                        Limpiar filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Información de resultados -->
        @if(request()->search || request()->estado || request()->fecha)
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Filtros aplicados:</strong>
                    @if(request()->search)
                        Búsqueda: "{{ request()->search }}"
                    @endif
                    @if(request()->estado)
                        @php 
                            $estados = ['0' => 'Cortado', '1' => 'Costurando', '2' => 'Entregado'];
                            $estadoNombre = $estados[request()->estado] ?? request()->estado;
                        @endphp
                        | Estado: {{ $estadoNombre }}
                    @endif
                    @if(request()->fecha)
                        @php 
                            $fechas = ['today' => 'Hoy', 'week' => 'Esta semana', 'month' => 'Este mes'];
                            $fechaNombre = $fechas[request()->fecha] ?? request()->fecha;
                        @endphp
                        | Fecha: {{ $fechaNombre }}
                    @endif
                    | Total: {{ $cortes->count() }} cortes
                </p>
            </div>
        @endif

        <!-- Header con título y botón crear -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">Cortes</h1>
            <a href="{{ route('cortes.create') }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Crear corte nuevo
            </a>
        </div>

        <!-- Estadísticas de cortes -->
        <x-cortes-stats :cortes="$cortes" />

        <!-- Grid de cortes -->
        @if($cortes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cortes as $corte)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <!-- Header con número de corte -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white">Corte #{{ $corte->numero_corte }}</h3>
                            <div class="flex items-center space-x-2">
                                @if($corte->estado == 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Cortado
                                    </span>
                                @elseif($corte->estado == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Costurando
                                    </span>
                                @elseif($corte->estado == 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Entregado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contenido del corte -->
                    <div class="p-6 space-y-4">
                        <!-- Nombre de la tela -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $corte->nombre }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tela del corte</p>
                        </div>

                        <!-- Información del corte -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center mb-1">
                                    <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Cantidad</span>
                                </div>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $corte->cantidad }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center mb-1">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Artículos</span>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $corte->articulos }}">
                                    {{ Str::limit($corte->articulos, 20) }}
                                </p>
                            </div>
                        </div>

                        <!-- Fecha -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-medium text-blue-700 dark:text-blue-400">Fecha de corte</span>
                            </div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-300">
                                {{ \Carbon\Carbon::parse($corte->fecha)->locale('es')->isoFormat('dddd D/M/Y') }}
                            </p>
                        </div>

                        <!-- Colores -->
                        @if($corte->colores)
                        <div>
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Colores</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $corte->colores) as $color)
                                    <span class="inline-block bg-white dark:bg-gray-700 px-2 py-1 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        {{ trim($color) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Acciones -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('cortes.show', $corte) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg text-center transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver
                            </a>
                            
                            <a href="{{ route('cortes.edit', $corte) }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            
                            <form action="{{ route('cortes.delete', $corte) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro que deseas eliminar este corte?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($cortes->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $cortes->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Mensaje cuando no hay resultados -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron cortes</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request()->search || request()->estado || request()->fecha)
                        Intenta ajustar los filtros de búsqueda.
                    @else
                        No hay cortes disponibles en este momento.
                    @endif
                </p>
                @if(request()->search || request()->estado || request()->fecha)
                    <div class="mt-6">
                        <a href="{{ route('cortes.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Limpiar filtros
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </x-container-wrapp>
@endsection
