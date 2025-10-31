@extends('tienda.layout')
@section('title', $articulo->nombre . ' - Tienda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('tienda.index') }}" class="text-primary-600 dark:text-primary-400 hover:underline mb-4 inline-block">
        <i class="ri-arrow-left-line mr-1"></i> Volver al catálogo
    </a>

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Imagen -->
            <div class="aspect-square bg-neutral-100 dark:bg-neutral-700 rounded-lg overflow-hidden">
                @if($articulo->imagen)
                    <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" alt="{{ $articulo->nombre }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="ri-image-line text-6xl text-neutral-400"></i>
                    </div>
                @endif
            </div>

            <!-- Información -->
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ $articulo->nombre }}</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mb-4">Código: {{ $articulo->codigo }}</p>

                @if($articulo->descripcion)
                    <p class="text-neutral-700 dark:text-neutral-300 mb-6">{{ $articulo->descripcion }}</p>
                @endif

                <!-- Precio -->
                <div class="mb-6">
                    @if($articulo->hasPrecioPromocion())
                        <div class="flex items-center space-x-4 mb-2">
                            <span class="text-4xl font-bold text-primary-600 dark:text-primary-400">
                                ${{ number_format($articulo->precio_promocion, 2, '.', ',') }}
                            </span>
                            <span class="text-xl text-neutral-500 line-through">
                                ${{ number_format($articulo->precio, 2, '.', ',') }}
                            </span>
                            <span class="bg-red-500 text-white text-sm font-bold px-2 py-1 rounded">
                                -{{ $articulo->getDescuentoPorcentaje() }}%
                            </span>
                        </div>
                    @else
                        <span class="text-4xl font-bold text-primary-600 dark:text-primary-400">
                            ${{ number_format($articulo->precio, 2, '.', ',') }}
                        </span>
                    @endif
                </div>

                <!-- Stock -->
                @if($articulo->stock > 0)
                    <p class="text-green-600 dark:text-green-400 mb-4">
                        <i class="ri-checkbox-circle-line mr-1"></i>
                        {{ $articulo->stock }} unidades disponibles
                    </p>

                    <!-- Cantidad y Agregar -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Cantidad
                        </label>
                        <div class="flex items-center space-x-4">
                            <button onclick="cambiarCantidad(-1)" class="w-10 h-10 border border-neutral-300 dark:border-neutral-600 rounded-lg flex items-center justify-center hover:bg-neutral-100 dark:hover:bg-neutral-700">
                                <i class="ri-subtract-line"></i>
                            </button>
                            <input type="number" id="cantidad" value="1" min="1" max="{{ $articulo->stock }}" 
                                   class="w-20 text-center border border-neutral-300 dark:border-neutral-600 rounded-lg dark:bg-neutral-700 dark:text-white">
                            <button onclick="cambiarCantidad(1)" class="w-10 h-10 border border-neutral-300 dark:border-neutral-600 rounded-lg flex items-center justify-center hover:bg-neutral-100 dark:hover:bg-neutral-700">
                                <i class="ri-add-line"></i>
                            </button>
                        </div>
                    </div>

                    <button onclick="agregarAlCarrito({{ $articulo->id }})" 
                            class="w-full bg-primary-500 text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition-colors flex items-center justify-center text-lg font-semibold">
                        <i class="ri-shopping-cart-line mr-2"></i>
                        Agregar al carrito
                    </button>
                @else
                    <div class="bg-neutral-100 dark:bg-neutral-700 px-4 py-3 rounded-lg mb-6">
                        <p class="text-neutral-600 dark:text-neutral-400 text-center">
                            <i class="ri-error-warning-line mr-1"></i>
                            Producto sin stock disponible
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cambiarCantidad(delta) {
    const input = document.getElementById('cantidad');
    const nuevoValor = parseInt(input.value) + delta;
    const max = parseInt(input.max);
    const min = parseInt(input.min);
    
    if (nuevoValor >= min && nuevoValor <= max) {
        input.value = nuevoValor;
    }
}

function agregarAlCarrito(articuloId) {
    const cantidad = parseInt(document.getElementById('cantidad').value);
    
    fetch('{{ route('carrito.agregar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            articulo_id: articuloId,
            cantidad: cantidad
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto agregado al carrito');
            actualizarCarrito();
        } else {
            alert(data.message || 'Error al agregar producto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al agregar producto al carrito');
    });
}
</script>
@endpush
@endsection

