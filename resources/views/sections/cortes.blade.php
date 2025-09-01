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
                    <label for="search" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Buscar cortes</label>
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
                            placeholder="Buscar por número de corte o tipo de tela"
                            value="{{ request()->search }}"
                        />
                    </div>
                </div>

                <!-- Filtros avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filtro por estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Estado</label>
                        <select name="estado" id="estado" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos los estados</option>
                            <option value="0" {{ request()->estado == '0' ? 'selected' : '' }}>Cortado</option>
                            <option value="1" {{ request()->estado == '1' ? 'selected' : '' }}>Costurando</option>
                            <option value="2" {{ request()->estado == '2' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>

                    <!-- Filtro por fecha -->
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Fecha</label>
                        <select name="fecha" id="fecha" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas las fechas</option>
                            <option value="today" {{ request()->fecha == 'today' ? 'selected' : '' }}>Hoy</option>
                            <option value="week" {{ request()->fecha == 'week' ? 'selected' : '' }}>Esta semana</option>
                            <option value="month" {{ request()->fecha == 'month' ? 'selected' : '' }}>Este mes</option>
                        </select>
                    </div>

                    <!-- Ordenamiento -->
                    <div>
                        <label for="order_by" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Ordenar por</label>
                        <select name="order_by" id="order_by" class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="latest" {{ (request()->order_by ?? 'latest') == 'latest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="oldest" {{ request()->order_by == 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                            <option value="numero_asc" {{ request()->order_by == 'numero_asc' ? 'selected' : '' }}>Número A-Z</option>
                            <option value="numero_desc" {{ request()->order_by == 'numero_desc' ? 'selected' : '' }}>Número Z-A</option>
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
                    
                    <x-buttons.secondary href="{{ route('cortes.index') }}">
                        Limpiar filtros
                    </x-buttons.secondary>
                </div>
            </form>
        </div>

        <!-- Información de resultados -->
        @if(request()->search || request()->estado || request()->fecha)
            <div class="mb-4 p-4 bg-primary-50 dark:bg-primary-950/20 border border-primary-200 dark:border-primary-800 rounded-lg">
                <p class="text-sm text-primary-800 dark:text-primary-200">
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
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Cortes</h1>
            @if(auth()->user()->hasRole('administrador'))
                <x-buttons.primary href="{{ route('cortes.create') }}">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Crear corte nuevo
                </x-buttons.primary>
            @endif
        </div>

        <!-- Estadísticas de cortes -->
        <x-cortes-stats :cortes="$cortes" />

        <!-- Grid de cortes -->
        @if($cortes->count() > 0)
            <!-- Vista de tarjetas para móvil (visible solo en móvil) -->
            <div class="block lg:hidden space-y-4 mb-6">
                @foreach($cortes as $corte)
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-4">
                        <!-- Header de la tarjeta -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center">
                                    <span class="text-lg font-bold text-white">{{ $corte->numero_corte }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">
                                        Corte #{{ $corte->numero_corte }}
                                    </h3>
                                    @if($corte->descripcion)
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                            {{ Str::limit($corte->descripcion, 40) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <!-- Estado -->
                            <div class="text-right">
                                @if($corte->estado == 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Cortado
                                    </span>
                                @elseif($corte->estado == 1)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-accent-100 dark:bg-accent-900/20 text-accent-800 dark:text-accent-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Costurando
                                    </span>
                                @elseif($corte->estado == 2)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Entregado
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Detalles de la tarjeta -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-1">Tipo de Tela</p>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $corte->tipo_tela }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-1">Cantidad</p>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $corte->cantidad_total }} unidades</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-1">Fecha</p>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($corte->fecha)->locale('es')->isoFormat('D/M/Y') }}
                                </p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ \Carbon\Carbon::parse($corte->fecha)->locale('es')->isoFormat('dddd') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-1">ID</p>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">#{{ $corte->id }}</p>
                            </div>
                        </div>

                        <!-- Acciones de la tarjeta -->
                        <div class="flex flex-col space-y-2">
                            <x-buttons.primary href="{{ route('cortes.show', $corte) }}" class="w-full justify-center">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Detalles
                            </x-buttons.primary>
                            
                            @if(auth()->user()->hasRole('administrador'))
                                <div class="grid grid-cols-2 gap-2">
                                    <x-buttons.outline href="{{ route('cortes.edit', $corte) }}" class="w-full justify-center">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar
                                    </x-buttons.outline>
                                    
                                    <x-delete-modal 
                                        :route="route('cortes.delete', $corte)"
                                        triggerText="Eliminar"
                                        modalTitle="Eliminar Corte"
                                        modalMessage="¿Estás seguro de que quieres eliminar este corte?"
                                        modalDescription="Esta acción eliminará permanentemente el corte y no se puede deshacer."
                                        confirmText="Sí, eliminar corte"
                                        cancelText="Cancelar"
                                        class="w-full justify-center"
                                        variant="danger"
                                        icon="ri-delete-bin-line"
                                        fullWidth="false"
                                        itemName="corte"
                                        modalId="deleteModal{{ $corte->id }}"
                                    />
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tabla de cortes para desktop (oculta en móvil) -->
            <div class="hidden lg:block bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Corte
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Tipo de Tela
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($cortes as $corte)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors duration-150">
                                <!-- Número de corte -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ $corte->numero_corte }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                                Corte #{{ $corte->numero_corte }}
                                            </div>
                                            @if($corte->descripcion)
                                                <div class="text-xs text-neutral-500 dark:text-neutral-400 truncate max-w-32" title="{{ $corte->descripcion }}">
                                                    {{ Str::limit($corte->descripcion, 30) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Tipo de Tela -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                        {{ $corte->tipo_tela }}
                                    </div>
                                </td>

                                <!-- Cantidad Total -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                                            <i class="ri-stack-line mr-1"></i>
                                            {{ $corte->cantidad_total }} unidades
                                        </span>
                                    </div>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($corte->estado == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Cortado
                                        </span>
                                    @elseif($corte->estado == 1)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-100 dark:bg-accent-900/20 text-accent-800 dark:text-accent-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Costurando
                                        </span>
                                    @elseif($corte->estado == 2)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Entregado
                                        </span>
                                    @endif
                                </td>

                                <!-- Fecha -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($corte->fecha)->locale('es')->isoFormat('D/M/Y') }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ \Carbon\Carbon::parse($corte->fecha)->locale('es')->isoFormat('dddd') }}
                                    </div>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <x-buttons.primary href="{{ route('cortes.show', $corte) }}" size="sm">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </x-buttons.primary>
                                        
                                        @if(auth()->user()->hasRole('administrador'))
                                            <x-buttons.outline href="{{ route('cortes.edit', $corte) }}" size="sm">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </x-buttons.outline>
                                            
                                            <x-delete-modal 
                                                :route="route('cortes.delete', $corte)"
                                                triggerText="Eliminar Corte"
                                                modalTitle="Eliminar Corte"
                                                modalMessage="¿Estás seguro de que quieres eliminar este corte?"
                                                modalDescription="Esta acción eliminará permanentemente el corte y no se puede deshacer."
                                                confirmText="Sí, eliminar corte"
                                                cancelText="Cancelar"
                                                size="sm"
                                                variant="danger"
                                                icon="ri-delete-bin-line"
                                                fullWidth="false"
                                                itemName="corte"
                                                modalId="deleteModal{{ $corte->id }}"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-white">No se encontraron cortes</h3>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    @if(request()->search || request()->estado || request()->fecha)
                        Intenta ajustar los filtros de búsqueda.
                    @else
                        No hay cortes disponibles en este momento.
                    @endif
                </p>
                @if(request()->search || request()->estado || request()->fecha)
                    <div class="mt-6">
                        <x-buttons.primary href="{{ route('cortes.index') }}">
                            Limpiar filtros
                        </x-buttons.primary>
                    </div>
                @endif
            </div>
        @endif
    </x-container-wrapp>
@endsection
