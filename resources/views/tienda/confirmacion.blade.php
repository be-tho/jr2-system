@extends('tienda.layout')
@section('title', 'Confirmación de Pedido - Tienda')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-8 text-center">
        <div class="mb-6">
            <div class="w-20 h-20 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ri-checkbox-circle-line text-5xl text-green-600 dark:text-green-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">¡Pedido Confirmado!</h1>
            <p class="text-neutral-600 dark:text-neutral-400">Gracias por tu compra</p>
        </div>

        <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-6 mb-6">
            <p class="text-lg text-neutral-700 dark:text-neutral-300 mb-2">
                Tu número de orden es:
            </p>
            <p class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                {{ $venta->numero_orden }}
            </p>
        </div>

        <div class="text-left bg-neutral-50 dark:bg-neutral-900 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Detalles del Pedido</h2>
            
            <div class="space-y-2 mb-4">
                <p><span class="font-medium">Cliente:</span> {{ $venta->cliente_nombre_completo }}</p>
                <p><span class="font-medium">Email:</span> {{ $venta->cliente_email }}</p>
                <p><span class="font-medium">Teléfono:</span> {{ $venta->cliente_telefono }}</p>
                <p><span class="font-medium">Fecha:</span> {{ $venta->fecha_venta_formateada }}</p>
            </div>

            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4 mt-4">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">Productos:</h3>
                <div class="space-y-2">
                    @foreach($venta->items as $item)
                        <div class="flex justify-between">
                            <span>{{ $item->articulo->nombre }} x{{ $item->cantidad }}</span>
                            <span class="font-medium">${{ number_format($item->subtotal, 2, '.', ',') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                    <span class="text-lg font-bold text-neutral-900 dark:text-white">Total:</span>
                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400">{{ $venta->total_formateado }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('tienda.index') }}" class="bg-primary-500 text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition-colors inline-block">
                Continuar Comprando
            </a>
        </div>

        <p class="mt-6 text-sm text-neutral-500 dark:text-neutral-400">
            Recibirás un correo electrónico con los detalles de tu pedido.
        </p>
    </div>
</div>
@endsection

