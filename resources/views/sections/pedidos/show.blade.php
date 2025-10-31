@extends('layout.app')
@section('title', 'Detalle del Pedido - ' . $pedido->numero_orden)
@section('content')
<x-container-wrapp>
    <!-- Botón Volver -->
    <a href="{{ route('pedidos.index') }}" class="text-primary-600 dark:text-primary-400 hover:underline mb-6 inline-block">
        <i class="ri-arrow-left-line mr-1"></i> Volver a Pedidos
    </a>

    <!-- Header -->
    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                    Pedido {{ $pedido->numero_orden }}
                </h1>
                <p class="text-neutral-600 dark:text-neutral-400">
                    Fecha: {{ $pedido->fecha_venta_formateada }}
                </p>
            </div>
            <div>
                @php
                    $estadoColors = [
                        'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                        'procesado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                        'completado' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                        'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                    ];
                @endphp
                <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $estadoColors[$pedido->estado] ?? '' }}">
                    {{ $pedido->estado_nombre }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del Cliente -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Información del Cliente</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Nombre:</span>
                        <p class="text-neutral-900 dark:text-white">{{ $pedido->cliente_nombre_completo }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Email:</span>
                        <p class="text-neutral-900 dark:text-white">{{ $pedido->cliente_email }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Teléfono:</span>
                        <p class="text-neutral-900 dark:text-white">{{ $pedido->cliente_telefono }}</p>
                    </div>
                </div>
            </div>

            <!-- Items del Pedido -->
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Productos</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Cantidad</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Precio Unit.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($pedido->items as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            @if($item->articulo->imagen)
                                                <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($item->articulo->imagen) }}" 
                                                     alt="{{ $item->articulo->nombre }}" 
                                                     class="w-12 h-12 object-cover rounded mr-3">
                                            @endif
                                            <div>
                                                <p class="font-medium text-neutral-900 dark:text-white">{{ $item->articulo->nombre }}</p>
                                                <p class="text-sm text-neutral-500">{{ $item->articulo->codigo }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-neutral-900 dark:text-white">{{ $item->cantidad }}</td>
                                    <td class="px-4 py-3 text-neutral-900 dark:text-white">{{ $item->precio_unitario_formateado }}</td>
                                    <td class="px-4 py-3 font-semibold text-neutral-900 dark:text-white">{{ $item->subtotal_formateado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Notas -->
            @if($pedido->notas)
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Notas</h2>
                    <p class="text-neutral-700 dark:text-neutral-300">{{ $pedido->notas }}</p>
                </div>
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Resumen -->
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Resumen</h2>
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-neutral-600 dark:text-neutral-400">Subtotal:</span>
                        <span class="text-neutral-900 dark:text-white">{{ $pedido->total_formateado }}</span>
                    </div>
                    <div class="border-t border-neutral-200 dark:border-neutral-700 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-neutral-900 dark:text-white">Total:</span>
                            <span class="text-xl font-bold text-primary-600 dark:text-primary-400">{{ $pedido->total_formateado }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cambiar Estado -->
            @hasrole('administrador')
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Cambiar Estado</h2>
                    <form action="{{ route('pedidos.actualizar-estado', $pedido) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="estado" class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg dark:bg-neutral-700 dark:text-white mb-4">
                            <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="procesado" {{ $pedido->estado == 'procesado' ? 'selected' : '' }}>Procesado</option>
                            <option value="completado" {{ $pedido->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        <button type="submit" class="w-full bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600">
                            Actualizar Estado
                        </button>
                    </form>
                </div>
            @endhasrole

            <!-- Agregar Notas -->
            @hasrole('administrador')
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Notas Internas</h2>
                    <form action="{{ route('pedidos.actualizar-notas', $pedido) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="notas" rows="4" 
                                  class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg dark:bg-neutral-700 dark:text-white mb-4">{{ $pedido->notas }}</textarea>
                        <button type="submit" class="w-full bg-neutral-500 text-white px-4 py-2 rounded-lg hover:bg-neutral-600">
                            Guardar Notas
                        </button>
                    </form>
                </div>
            @endhasrole
        </div>
    </div>
</x-container-wrapp>
@endsection

