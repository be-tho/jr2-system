@extends('layout.app')
@section('title', 'Editar Venta')
@section('content')
    <x-container-wrapp>
        <!-- Mensajes de notificación -->
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

        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Editar Venta #{{ $venta->id }}</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Modificar los datos de la venta realizada</p>
                </div>
                <div class="flex space-x-3">
                    <x-buttons.secondary href="{{ route('ventas.show', $venta) }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver Venta
                    </x-buttons.secondary>
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
            <!-- Panel izquierdo: Búsqueda y lista de artículos -->
            <div class="lg:col-span-2">
                <!-- Lista de artículos disponibles -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Artículos Disponibles</h3>
                        <div class="text-sm text-neutral-500 dark:text-neutral-400">
                            <span id="articulos-count">0</span> artículos
                        </div>
                    </div>
                    
                    <!-- Campo de búsqueda -->
                    <div class="relative mb-4">
                        <input type="text" 
                               id="search-articulos" 
                               placeholder="🔍 Buscar productos por nombre o código..." 
                               class="w-full px-4 py-2 pl-10 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                               autocomplete="off">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <div id="articulos-disponibles" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                        <!-- Los artículos se cargan aquí -->
                    </div>
                </div>

                <!-- Lista de artículos agregados -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Artículos en la Venta</h3>
                        <span id="items-count" class="bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 px-2 py-1 rounded-full text-sm font-medium">0 artículos</span>
                    </div>
                    
                    <div id="items-list" class="space-y-4">
                        <!-- Los artículos se agregan aquí dinámicamente -->
                    </div>
                </div>
            </div>

            <!-- Panel derecho: Información de la venta -->
            <div class="space-y-6">
                <!-- Formulario de venta -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Información de la Venta</h3>
                    
                    <form id="venta-form" method="POST" action="{{ route('ventas.update', $venta) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Cliente -->
                        <div class="mb-4">
                            <label for="cliente_nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Cliente <span class="text-gray-500">(opcional)</span>
                            </label>
                            <input type="text" 
                                   name="cliente_nombre" 
                                   id="cliente_nombre" 
                                   value="{{ old('cliente_nombre', $venta->cliente_nombre) }}"
                                   placeholder="Nombre del cliente"
                                   class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <!-- Notas -->
                        <div class="mb-6">
                            <label for="notas" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Notas <span class="text-gray-500">(opcional)</span>
                            </label>
                            <textarea name="notas" 
                                      id="notas" 
                                      rows="3" 
                                      placeholder="Observaciones adicionales..."
                                      class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">{{ old('notas', $venta->notas) }}</textarea>
                        </div>

                        <!-- Total -->
                        <div class="border-t border-neutral-200 dark:border-neutral-600 pt-4 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-medium text-neutral-700 dark:text-neutral-300">Total:</span>
                                <span id="total-venta" class="text-2xl font-bold text-primary-600 dark:text-primary-400">$0.00</span>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="space-y-3">
                            <x-buttons.primary type="submit" id="btn-guardar" class="w-full" disabled>
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Venta
                            </x-buttons.primary>
                            
                            <x-buttons.secondary href="{{ route('ventas.show', $venta) }}" class="w-full">
                                Cancelar
                            </x-buttons.secondary>
                        </div>
                    </form>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Información importante</h4>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>El stock se actualizará automáticamente al guardar los cambios</li>
                                    <li>Los artículos originales se restaurarán al stock antes de aplicar los nuevos</li>
                                    <li>Puedes agregar, modificar o eliminar artículos de la venta</li>
                                    <li>La cantidad debe ser mayor a 0 y no exceder el stock disponible</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container-wrapp>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== CONFIGURACIÓN =====
            const CONFIG = {
                SEARCH_DELAY: 300,
                IMAGE_BASE_URL: '{{ asset('src/assets/uploads/articulos/') }}/',
                ROUTES: {
                    SEARCH_ARTICULOS: '{{ route('ventas.search-articulos') }}',
                    UPDATE_VENTA: '{{ route('ventas.update', $venta) }}'
                }
            };

            // ===== DATOS DE LA VENTA ORIGINAL =====
            const ventaOriginal = @json($ventaOriginal);

            // ===== ESTADO DE LA APLICACIÓN =====
            const state = {
                itemsVenta: [...ventaOriginal],
                todosLosArticulos: [],
                searchTimeout: null
            };

            // ===== ELEMENTOS DEL DOM =====
            const elements = {
                articulosDisponibles: document.getElementById('articulos-disponibles'),
                searchInput: document.getElementById('search-articulos'),
                articulosCount: document.getElementById('articulos-count'),
                itemsList: document.getElementById('items-list'),
                itemsCount: document.getElementById('items-count'),
                totalVenta: document.getElementById('total-venta'),
                btnGuardar: document.getElementById('btn-guardar'),
                ventaForm: document.getElementById('venta-form')
            };

            // ===== FUNCIONES AUXILIARES =====
            const utils = {
                // Generar URL de imagen con fallback
                getImageUrl: (imagen) => `${CONFIG.IMAGE_BASE_URL}${imagen}`,
                
                // Obtener clase CSS según el stock
                getStockClass: (stock) => {
                    if (stock > 10) return 'text-green-600 dark:text-green-400';
                    if (stock > 5) return 'text-yellow-600 dark:text-yellow-400';
                    return 'text-red-600 dark:text-red-400';
                },
                
                // Formatear precio
                formatPrice: (precio) => {
                    const numPrecio = parseFloat(precio);
                    return isNaN(numPrecio) ? '0.00' : numPrecio.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                },
                
                // Escapar HTML para prevenir XSS
                escapeHtml: (text) => text.replace(/"/g, '&quot;'),
                
                // Validar cantidad
                validateQuantity: (cantidad, stock) => Math.max(1, Math.min(cantidad, stock))
            };

            // ===== INICIALIZACIÓN =====
            function init() {
                cargarArticulosDisponibles();
                setupEventListeners();
                actualizarVista();
            }

            // ===== EVENT LISTENERS =====
            function setupEventListeners() {
                elements.searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.trim();
                    clearTimeout(state.searchTimeout);
                    state.searchTimeout = setTimeout(() => filtrarArticulos(query), CONFIG.SEARCH_DELAY);
                });

                elements.ventaForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (state.itemsVenta.length === 0) {
                        alert('Debe agregar al menos un artículo a la venta');
                        return;
                    }
                    enviarVenta();
                });
            }

            // ===== CARGAR ARTÍCULOS =====
            async function cargarArticulosDisponibles() {
                try {
                    const response = await fetch(`${CONFIG.ROUTES.SEARCH_ARTICULOS}?q=`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });
                    
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    
                    const data = await response.json();
                    state.todosLosArticulos = data;
                    mostrarArticulosDisponibles(data);
                } catch (error) {
                    console.error('Error al cargar artículos:', error);
                    mostrarError('Error al cargar los artículos');
                }
            }

            // ===== MOSTRAR ARTÍCULOS =====
            function mostrarArticulosDisponibles(articulos) {
                elements.articulosCount.textContent = articulos.length;
                
                if (articulos.length === 0) {
                    mostrarMensajeVacio('No se encontraron artículos');
                } else {
                    elements.articulosDisponibles.innerHTML = articulos.map(crearCardArticulo).join('');
                }
            }

            function crearCardArticulo(articulo) {
                const stockClass = utils.getStockClass(articulo.stock);
                const imageUrl = utils.getImageUrl(articulo.imagen);
                const escapedArticulo = utils.escapeHtml(JSON.stringify(articulo));
                
                return `
                    <div class="bg-neutral-50 dark:bg-neutral-700 rounded-lg p-4 border border-neutral-200 dark:border-neutral-600 hover:border-primary-300 dark:hover:border-primary-600 transition-colors duration-200 cursor-pointer"
                         onclick="agregarArticulo(${escapedArticulo})">
                        <div class="flex items-center space-x-3">
                            <img src="${imageUrl}" 
                                 alt="${articulo.nombre}" 
                                 class="w-12 h-12 object-cover rounded-lg flex-shrink-0" 
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-12 h-12 bg-neutral-100 dark:bg-neutral-600 rounded-lg flex items-center justify-center flex-shrink-0" style="display: none;">
                                <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-neutral-900 dark:text-white truncate">${articulo.nombre}</div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">Código: ${articulo.codigo}</div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="text-sm font-medium text-green-600 dark:text-green-400">${articulo.precio_formateado}</div>
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Stock:</span>
                                        <span class="text-xs font-medium ${stockClass}">${articulo.stock}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                `;
            }

            function mostrarMensajeVacio(mensaje) {
                elements.articulosDisponibles.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-neutral-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-neutral-500 dark:text-neutral-400">${mensaje}</p>
                    </div>
                `;
            }

            function mostrarError(mensaje) {
                elements.articulosDisponibles.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-600 dark:text-red-400">${mensaje}</p>
                    </div>
                `;
            }

            // ===== FILTRADO =====
            function filtrarArticulos(query) {
                const articulos = query === '' 
                    ? state.todosLosArticulos 
                    : state.todosLosArticulos.filter(articulo => 
                        articulo.nombre.toLowerCase().includes(query.toLowerCase()) ||
                        articulo.codigo.toLowerCase().includes(query.toLowerCase()) ||
                        (articulo.descripcion && articulo.descripcion.toLowerCase().includes(query.toLowerCase()))
                    );
                
                mostrarArticulosDisponibles(articulos);
            }

            // ===== GESTIÓN DE ARTÍCULOS EN VENTA =====
            function agregarArticulo(articulo) {
                if (state.itemsVenta.find(item => item.id === articulo.id)) {
                    alert('Este artículo ya está agregado a la venta');
                    return;
                }

                state.itemsVenta.push({
                    id: parseInt(articulo.id),
                    nombre: articulo.nombre,
                    codigo: articulo.codigo,
                    precio: parseFloat(articulo.precio),
                    stock: parseInt(articulo.stock),
                    imagen: articulo.imagen,
                    cantidad: 1,
                    subtotal: parseFloat(articulo.precio)
                });

                actualizarVista();
            }

            function eliminarArticulo(index) {
                state.itemsVenta.splice(index, 1);
                actualizarVista();
            }

            function actualizarCantidad(index, nuevaCantidad) {
                const item = state.itemsVenta[index];
                nuevaCantidad = parseInt(nuevaCantidad) || 1;
                nuevaCantidad = utils.validateQuantity(nuevaCantidad, item.stock);
                
                if (nuevaCantidad > item.stock) {
                    alert(`La cantidad no puede exceder el stock disponible (${item.stock})`);
                    return;
                }
                
                item.cantidad = nuevaCantidad;
                item.subtotal = item.cantidad * parseFloat(item.precio);
                actualizarVista();
            }

            // ===== ACTUALIZAR VISTA =====
            function actualizarVista() {
                actualizarContadores();
                actualizarTotal();
                actualizarListaItems();
            }

            function actualizarContadores() {
                elements.itemsCount.textContent = `${state.itemsVenta.length} artículo${state.itemsVenta.length !== 1 ? 's' : ''}`;
            }

            function actualizarTotal() {
                const total = state.itemsVenta.reduce((sum, item) => {
                    const subtotal = parseFloat(item.subtotal) || 0;
                    return sum + subtotal;
                }, 0);
                elements.totalVenta.textContent = `$${utils.formatPrice(total)}`;
                elements.btnGuardar.disabled = state.itemsVenta.length === 0;
            }

            function actualizarListaItems() {
                elements.itemsList.innerHTML = state.itemsVenta.length === 0 
                    ? crearEstadoVacio() 
                    : state.itemsVenta.map((item, index) => crearItemVenta(item, index)).join('');
            }

            function crearEstadoVacio() {
                return `
                    <div id="empty-state" class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No hay artículos agregados</h3>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                            Busca y selecciona artículos para agregar a la venta.
                        </p>
                    </div>
                `;
            }

            function crearItemVenta(item, index) {
                const imageUrl = utils.getImageUrl(item.imagen);
                
                return `
                    <div class="bg-neutral-50 dark:bg-neutral-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 flex-1">
                                <img src="${imageUrl}" 
                                     alt="${item.nombre}" 
                                     class="w-10 h-10 object-cover rounded-lg flex-shrink-0" 
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-10 h-10 bg-neutral-100 dark:bg-neutral-600 rounded-lg flex items-center justify-center flex-shrink-0" style="display: none;">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-neutral-900 dark:text-white">${item.nombre}</h4>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Código: ${item.codigo}</p>
                                    <p class="text-sm font-medium text-green-600 dark:text-green-400">$${utils.formatPrice(item.precio)} c/u</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-neutral-700 dark:text-neutral-300">Cantidad:</label>
                                    <input type="number" 
                                           min="1" 
                                           max="${item.stock}" 
                                           value="${item.cantidad}" 
                                           onchange="actualizarCantidad(${index}, parseInt(this.value))"
                                           class="w-16 px-2 py-1 text-sm border border-neutral-300 dark:border-neutral-600 rounded bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white">Subtotal</p>
                                    <p class="text-lg font-bold text-primary-600 dark:text-primary-400">$${utils.formatPrice(item.subtotal)}</p>
                                </div>
                                <button onclick="eliminarArticulo(${index})" 
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }

            // ===== ENVÍO DE VENTA =====
            function enviarVenta() {
                crearInputsOcultos();
                mostrarLoading();
                elements.ventaForm.submit();
            }

            function crearInputsOcultos() {
                state.itemsVenta.forEach((item, index) => {
                    const inputs = [
                        { name: 'items[' + index + '][articulo_id]', value: item.id },
                        { name: 'items[' + index + '][cantidad]', value: item.cantidad },
                        { name: 'items[' + index + '][precio_unitario]', value: item.precio },
                        { name: 'items[' + index + '][detalle]', value: item.detalle || item.nombre }
                    ];

                    inputs.forEach(input => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = input.name;
                        hiddenInput.value = input.value;
                        elements.ventaForm.appendChild(hiddenInput);
                    });
                });
            }

            function mostrarLoading() {
                elements.btnGuardar.disabled = true;
                elements.btnGuardar.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Actualizando...
                `;
            }

            // ===== FUNCIONES GLOBALES =====
            window.agregarArticulo = agregarArticulo;
            window.eliminarArticulo = eliminarArticulo;
            window.actualizarCantidad = actualizarCantidad;

            // ===== INICIALIZAR APLICACIÓN =====
            init();
        });
    </script>
@endsection
