@extends('layout.app')
@section('title', 'Detalle de Venta')
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

        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Detalle de Venta</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Información completa de la venta #{{ $venta->id }}</p>
                </div>
                <div class="flex gap-3">
                    <x-buttons.outline onclick="window.print()">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Imprimir
                    </x-buttons.outline>
                    <x-buttons.secondary href="{{ route('ventas.index') }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </x-buttons.secondary>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información principal -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Artículos Vendidos</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                            <thead class="bg-neutral-50 dark:bg-neutral-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Artículo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Precio Unitario
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                                @foreach($venta->items as $item)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors duration-150">
                                    <!-- Artículo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                                    {{ $item->articulo->nombre }}
                                                </div>
                                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                    Código: {{ $item->articulo->codigo }}
                                                </div>
                                                @if($item->detalle)
                                                    <div class="text-xs text-neutral-600 dark:text-neutral-300 mt-1">
                                                        {{ $item->detalle }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Cantidad -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-neutral-900 dark:text-white">
                                            {{ $item->cantidad }}
                                        </div>
                                    </td>

                                    <!-- Precio Unitario -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-neutral-900 dark:text-white">
                                            {{ $item->precio_unitario_formateado }}
                                        </div>
                                    </td>

                                    <!-- Subtotal -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-neutral-900 dark:text-white">
                                            {{ $item->subtotal_formateado }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="space-y-6">
                <!-- Información de la venta -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Información de la Venta</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">ID de Venta:</span>
                            <span class="text-sm text-neutral-900 dark:text-white ml-2">#{{ $venta->id }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Fecha:</span>
                            <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $venta->fecha_venta_formateada }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Cliente:</span>
                            <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $venta->cliente_nombre ?: 'Sin especificar' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Registrado por:</span>
                            <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $venta->user->name }}</span>
                        </div>
                        @if($venta->notas)
                            <div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Notas:</span>
                                <div class="text-sm text-neutral-900 dark:text-white mt-1 p-2 bg-neutral-50 dark:bg-neutral-700 rounded">
                                    {{ $venta->notas }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Resumen de totales -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Resumen</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-neutral-700 dark:text-neutral-300">Total de artículos:</span>
                            <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $venta->items->sum('cantidad') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-neutral-700 dark:text-neutral-300">Items diferentes:</span>
                            <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $venta->items->count() }}</span>
                        </div>
                        <div class="border-t border-neutral-200 dark:border-neutral-600 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-medium text-neutral-700 dark:text-neutral-300">Total:</span>
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $venta->total_formateado }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                @hasrole('administrador')
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Acciones</h3>
                    </div>
                    <div class="p-6">
                        <x-delete-modal 
                            :route="route('ventas.destroy', $venta)"
                            triggerText="Eliminar Venta"
                            modalTitle="Eliminar Venta"
                            modalMessage="¿Estás seguro de que quieres eliminar esta venta?"
                            modalDescription="Esta acción eliminará permanentemente la venta y restaurará el stock de los artículos vendidos."
                            confirmText="Sí, eliminar venta"
                            cancelText="Cancelar"
                            variant="danger"
                            icon="ri-delete-bin-line"
                            fullWidth="true"
                            itemName="venta"
                            modalId="deleteModal{{ $venta->id }}"
                        />
                    </div>
                </div>
                @endhasrole
            </div>
        </div>
    </x-container-wrapp>

    <!-- Estilos para impresión -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12px;
            }
            
            .bg-white, .bg-neutral-800 {
                background: white !important;
                color: black !important;
            }
            
            .border {
                border: 1px solid #000 !important;
            }
            
            .text-primary-600, .text-primary-400 {
                color: black !important;
            }
        }
    </style>
@endsection
