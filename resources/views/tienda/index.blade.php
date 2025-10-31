@extends('tienda.layout')
@section('title', 'Tienda - Catálogo de Productos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">Nuestros Productos</h1>
        <p class="text-neutral-600 dark:text-neutral-400">Explora nuestra amplia selección de productos</p>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('tienda.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Búsqueda -->
            <div>
                <input type="text" name="buscar" value="{{ request('buscar') }}" 
                       placeholder="Buscar productos..." 
                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white">
            </div>

            <!-- Categoría -->
            <div>
                <select name="categoria_id" class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-neutral-700 dark:text-white">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Orden -->
            <div>
                <select name="orden" class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-neutral-700 dark:text-white">
                    <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                    <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                    <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                    <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>Nombre A-Z</option>
                </select>
            </div>

            <!-- Botón -->
            <div>
                <button type="submit" class="w-full bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                    <i class="ri-search-line mr-2"></i>Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- Grid de Productos -->
    @if($articulos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($articulos as $articulo)
                <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <a href="{{ route('tienda.show', $articulo) }}">
                        <div class="relative aspect-square bg-neutral-100 dark:bg-neutral-700">
                            @if($articulo->imagen)
                                <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                                     alt="{{ $articulo->nombre }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ri-image-line text-4xl text-neutral-400"></i>
                                </div>
                            @endif
                            @if($articulo->hasPrecioPromocion())
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    -{{ $articulo->getDescuentoPorcentaje() }}%
                                </span>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-4">
                        <a href="{{ route('tienda.show', $articulo) }}">
                            <h3 class="font-semibold text-neutral-900 dark:text-white mb-2 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                {{ $articulo->nombre }}
                            </h3>
                        </a>
                        
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-3">
                            {{ $articulo->codigo }}
                        </p>

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                @if($articulo->hasPrecioPromocion())
                                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400">
                                        ${{ number_format($articulo->precio_promocion, 2, '.', ',') }}
                                    </span>
                                    <span class="text-sm text-neutral-500 line-through ml-2">
                                        ${{ number_format($articulo->precio, 2, '.', ',') }}
                                    </span>
                                @else
                                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400">
                                        ${{ number_format($articulo->precio, 2, '.', ',') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($articulo->stock > 0)
                            <button onclick="agregarAlCarrito({{ $articulo->id }})" 
                                    class="w-full bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors flex items-center justify-center">
                                <i class="ri-shopping-cart-line mr-2"></i>
                                Agregar al carrito
                            </button>
                        @else
                            <button disabled class="w-full bg-neutral-300 dark:bg-neutral-600 text-neutral-500 dark:text-neutral-400 px-4 py-2 rounded-lg cursor-not-allowed">
                                Sin stock
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $articulos->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="ri-search-line text-6xl text-neutral-400 mb-4"></i>
            <p class="text-xl text-neutral-600 dark:text-neutral-400 mb-2">No se encontraron productos</p>
            <p class="text-neutral-500 dark:text-neutral-500">Intenta con otros filtros de búsqueda</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
function agregarAlCarrito(articuloId) {
    fetch('{{ route('carrito.agregar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            articulo_id: articuloId,
            cantidad: 1
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

