@extends('tienda.layout')
@section('title', 'Checkout - Tienda')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8">Finalizar Pedido</h1>

    <form action="{{ route('checkout.procesar') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf

        <!-- Información del Cliente -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-6">Información de Contacto</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="cliente_nombre" value="{{ old('cliente_nombre') }}" required
                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white">
                    @error('cliente_nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Apellido <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="cliente_apellido" value="{{ old('cliente_apellido') }}" required
                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white">
                    @error('cliente_apellido')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Correo Electrónico <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="cliente_email" value="{{ old('cliente_email') }}" required
                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white">
                    @error('cliente_email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Teléfono <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="cliente_telefono" value="{{ old('cliente_telefono') }}" required
                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white">
                    @error('cliente_telefono')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Notas (opcional)
                    </label>
                    <textarea name="notas" rows="3"
                              class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white">{{ old('notas') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Resumen del Pedido -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-6">Resumen del Pedido</h2>

            <div id="cart-summary" class="space-y-4 mb-6">
                <!-- Items del carrito se cargarán aquí -->
            </div>

            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4">
                <div class="flex justify-between items-center text-xl font-bold text-neutral-900 dark:text-white">
                    <span>Total:</span>
                    <span id="cart-total">$0.00</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary-500 text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition-colors mt-6 font-semibold">
                Confirmar Pedido
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Cargar resumen del carrito
fetch('{{ route('carrito.index') }}')
    .then(response => response.json())
    .then(data => {
        const summaryDiv = document.getElementById('cart-summary');
        const totalDiv = document.getElementById('cart-total');

        if (data.items.length === 0) {
            summaryDiv.innerHTML = '<p class="text-neutral-500">Tu carrito está vacío</p>';
            totalDiv.textContent = '$0.00';
            return;
        }

        let html = '';
        data.items.forEach(item => {
            html += `
                <div class="flex justify-between items-center py-2 border-b border-neutral-200 dark:border-neutral-700">
                    <div>
                        <p class="font-medium text-neutral-900 dark:text-white">${item.nombre}</p>
                        <p class="text-sm text-neutral-500">Cantidad: ${item.cantidad}</p>
                    </div>
                    <span class="font-semibold text-neutral-900 dark:text-white">${item.subtotal_formateado}</span>
                </div>
            `;
        });

        summaryDiv.innerHTML = html;
        totalDiv.textContent = data.total_formateado;
    })
    .catch(error => {
        console.error('Error al cargar carrito:', error);
    });
</script>
@endpush
@endsection

