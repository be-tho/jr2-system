<?php
    /** @var \App\Models\Venta $ventas **/
    /** @var \App\Models\Articulo $articulos **/
?>
@extends('layout.app')
@section('title', 'Gestión de Ventas')
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

        <!-- Header con título y botón crear -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Gestión de Ventas</h1>
            <x-buttons.primary href="{{ route('ventas.create') }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nueva Venta
            </x-buttons.primary>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Ventas</p>
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $ventas->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Monto Total</p>
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            ${{ number_format($ventas->sum('total'), 2, '.', ',') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Promedio Venta</p>
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            ${{ number_format($ventas->avg('total'), 2, '.', ',') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Filtros de Búsqueda</h3>
            <form method="GET" action="{{ route('ventas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Fecha Desde</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $filtros['fecha_inicio'] }}" 
                           class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Fecha Hasta</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $filtros['fecha_fin'] }}" 
                           class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="cliente" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Cliente</label>
                    <input type="text" name="cliente" id="cliente" value="{{ $filtros['cliente'] }}" placeholder="Nombre del cliente"
                           class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="articulo_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Artículo</label>
                    <select name="articulo_id" id="articulo_id" 
                            class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Todos los artículos</option>
                        @foreach($articulos as $articulo)
                            <option value="{{ $articulo->id }}" {{ $filtros['articulo_id'] == $articulo->id ? 'selected' : '' }}>
                                {{ $articulo->nombre }} ({{ $articulo->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-4 flex gap-3">
                    <x-buttons.primary type="submit">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </x-buttons.primary>
                    <x-buttons.secondary href="{{ route('ventas.index') }}">
                        Limpiar Filtros
                    </x-buttons.secondary>
                </div>
            </form>
        </div>

        <!-- Tabla de ventas -->
        @if($ventas->count() > 0)
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($ventas as $venta)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors duration-150">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                        #{{ $venta->id }}
                                    </div>
                                </td>

                                <!-- Fecha -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        {{ $venta->fecha_venta->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ $venta->fecha_venta->format('H:i') }}
                                    </div>
                                </td>

                                <!-- Cliente -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        {{ $venta->cliente_nombre ?: 'Sin especificar' }}
                                    </div>
                                </td>

                                <!-- Total -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                                        {{ $venta->total_formateado }}
                                    </div>
                                </td>

                                <!-- Usuario -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        {{ $venta->user->name }}
                                    </div>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <x-buttons.primary href="{{ route('ventas.show', $venta) }}" size="sm">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </x-buttons.primary>
                                        
                                        @hasrole('administrador')
                                            <x-delete-modal 
                                                :route="route('ventas.destroy', $venta)"
                                                triggerText="Eliminar Venta"
                                                modalTitle="Eliminar Venta"
                                                modalMessage="¿Estás seguro de que quieres eliminar esta venta?"
                                                modalDescription="Esta acción eliminará permanentemente la venta y restaurará el stock de los artículos."
                                                confirmText="Sí, eliminar venta"
                                                cancelText="Cancelar"
                                                size="sm"
                                                variant="danger"
                                                icon="ri-delete-bin-line"
                                                fullWidth="false"
                                                itemName="venta"
                                                modalId="deleteModal{{ $venta->id }}"
                                            />
                                        @endhasrole
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if($ventas->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $ventas->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Mensaje cuando no hay ventas -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No hay ventas registradas</h3>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Comienza registrando la primera venta del sistema.
                </p>
                <div class="mt-6">
                    <x-buttons.primary href="{{ route('ventas.create') }}">
                        Registrar primera venta
                    </x-buttons.primary>
                </div>
            </div>
        @endif
    </x-container-wrapp>
@endsection
