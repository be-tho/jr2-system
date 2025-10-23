
@extends('layout.app')
@section('title', 'Nueva Venta')
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
                    <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Nueva Venta</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Registrar una nueva venta de artículos</p>
                </div>
                <x-buttons.secondary href="{{ route('ventas.index') }}">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </x-buttons.secondary>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel izquierdo: Botón para abrir modal y lista de artículos agregados -->
            <div class="lg:col-span-2">
                <!-- Botón para abrir modal de búsqueda -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Agregar Artículos</h3>
                        <div class="flex items-center space-x-4">
                            <!-- Toggle para usar precio promocional -->
                            <div class="flex items-center space-x-3">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" 
                                           id="usar-precio-promocion" 
                                           class="hidden"
                                           onchange="togglePrecioPromocion()">
                                    <div class="relative">
                                        <!-- Fondo del toggle -->
                                        <div class="w-12 h-6 bg-gray-300 dark:bg-gray-600 rounded-full shadow-inner transition-all duration-300 ease-in-out group-hover:shadow-md"></div>
                                        <!-- Círculo del toggle -->
                                        <div class="absolute w-5 h-5 bg-white rounded-full shadow-lg top-0.5 left-0.5 transition-all duration-300 ease-in-out transform"></div>
                                        <!-- Icono de descuento cuando está activo -->
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-200">
                                        Usar Precio Promocional
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botón para abrir modal -->
                    <button type="button" 
                            id="btn-abrir-modal" 
                            onclick="abrirModalArticulos()"
                            class="w-full px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Buscar y Agregar Artículos</span>
                    </button>
                </div>

                <!-- Lista de artículos agregados -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Artículos en la Venta</h3>
                        <span id="items-count" class="bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 px-2 py-1 rounded-full text-sm font-medium">0 artículos</span>
                    </div>
                    
                    <div id="items-list" class="space-y-4">
                        <!-- Los artículos se agregan aquí dinámicamente -->
                        <div id="empty-state" class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No hay artículos agregados</h3>
                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                                Busca y selecciona artículos para agregar a la venta.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel derecho: Información de la venta -->
            <div class="space-y-6">
                <!-- Formulario de venta -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Información de la Venta</h3>
                    
                    <form id="venta-form" method="POST" action="{{ route('ventas.store') }}">
                        @csrf
                        
                        <!-- Cliente -->
                        <div class="mb-4">
                            <label for="cliente_nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Cliente <span class="text-gray-500">(opcional)</span>
                            </label>
                            <input type="text" 
                                   name="cliente_nombre" 
                                   id="cliente_nombre" 
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
                                      class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"></textarea>
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
                                Guardar Venta
                            </x-buttons.primary>
                            
                            <x-buttons.secondary href="{{ route('ventas.index') }}" class="w-full">
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
                                    <li>El stock se actualizará automáticamente al guardar la venta</li>
                                    <li>Puedes agregar múltiples artículos a la venta</li>
                                    <li>El precio se toma del artículo, pero puedes modificarlo</li>
                                    <li>La cantidad debe ser mayor a 0 y no exceder el stock disponible</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container-wrapp>

    <!-- Modal para búsqueda de artículos -->
    <div id="modal-articulos" class="fixed inset-0 bg-gray-950 bg-opacity-90 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-xl w-full max-w-6xl max-h-[90vh] overflow-hidden">
                <!-- Header del modal -->
                <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-white">Buscar Artículos</h3>
                    <button type="button" 
                            onclick="cerrarModalArticulos()"
                            class="p-2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Contenido del modal -->
                <div class="p-6">
                    <!-- Campo de búsqueda -->
                    <div class="relative mb-6">
                        <input type="text" 
                               id="search-modal-articulos" 
                               placeholder="🔍 Buscar productos por nombre o código..." 
                               class="w-full px-4 py-3 pl-12 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                               autocomplete="off">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Lista de artículos -->
                    <div id="articulos-modal-disponibles" class="space-y-2 max-h-96 overflow-y-auto">
                        <!-- Los artículos se cargan aquí -->
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="flex items-center justify-end space-x-3 p-6 border-t border-neutral-200 dark:border-neutral-700">
                    <button type="button" 
                            onclick="cerrarModalArticulos()"
                            class="px-4 py-2 text-neutral-600 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="button" 
                            onclick="cerrarModalArticulos()"
                            class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const CONFIG = {
                SEARCH_DELAY: 300,
                IMAGE_BASE_URL: '{{ asset('src/assets/uploads/articulos/') }}/',
                ROUTES: {
                    SEARCH_ARTICULOS: '{{ route('ventas.search-articulos') }}',
                    STORE_VENTA: '{{ route('ventas.store') }}'
                }
            };

            const state = {
                itemsVenta: [],
                todosLosArticulos: [],
                searchTimeout: null,
                usarPrecioPromocion: false
            };

            const elements = {
                modal: document.getElementById('modal-articulos'),
                modalSearchInput: document.getElementById('search-modal-articulos'),
                modalArticulosDisponibles: document.getElementById('articulos-modal-disponibles'),
                itemsList: document.getElementById('items-list'),
                itemsCount: document.getElementById('items-count'),
                totalVenta: document.getElementById('total-venta'),
                btnGuardar: document.getElementById('btn-guardar'),
                ventaForm: document.getElementById('venta-form')
            };

            const utils = {
                getImageUrl: (imagen) => `${CONFIG.IMAGE_BASE_URL}${imagen}`,
                
                getStockClass: (stock) => {
                    if (stock > 10) return 'text-green-600 dark:text-green-400';
                    if (stock > 5) return 'text-yellow-600 dark:text-yellow-400';
                    return 'text-red-600 dark:text-red-400';
                },
                
                formatPrice: (precio) => {
                    const numPrecio = parseFloat(precio);
                    if (isNaN(numPrecio) || numPrecio < 0) return '0.00';
                    return numPrecio.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                },
                
                escapeHtml: (text) => text.replace(/"/g, '&quot;'),
                
                validateQuantity: (cantidad, stock) => Math.max(1, Math.min(parseInt(cantidad) || 1, stock)),
                
                validatePrice: (precio) => {
                    const numPrecio = parseFloat(precio);
                    return isNaN(numPrecio) || numPrecio < 0 ? 0 : numPrecio;
                },
                
                getEffectivePrice: (articulo, usarPromocion) => {
                    if (usarPromocion && articulo.tiene_precio_promocion) {
                        return parseFloat(articulo.precio_promocion);
                    }
                    return parseFloat(articulo.precio_original);
                }
            };

            function init() {
                setupEventListeners();
            }

            function setupEventListeners() {
                elements.modalSearchInput.addEventListener('input', function(e) {
                    const query = e.target.value.trim();
                    clearTimeout(state.searchTimeout);
                    state.searchTimeout = setTimeout(() => filtrarArticulosModal(query), CONFIG.SEARCH_DELAY);
                });

                elements.ventaForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (state.itemsVenta.length === 0) {
                        alert('Debe agregar al menos un artículo a la venta');
                        return;
                    }
                    enviarVenta();
                });

                elements.modal.addEventListener('click', function(e) {
                    if (e.target === elements.modal) {
                        cerrarModalArticulos();
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !elements.modal.classList.contains('hidden')) {
                        cerrarModalArticulos();
                    }
                });
            }

            async function cargarArticulosModal(query = '') {
                try {
                    const params = new URLSearchParams({
                        q: query,
                        usar_precio_promocion: state.usarPrecioPromocion
                    });
                    
                    const response = await fetch(`${CONFIG.ROUTES.SEARCH_ARTICULOS}?${params}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });
                    
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    
                    const data = await response.json();
                    state.todosLosArticulos = data;
                    mostrarArticulosModal(data);
                } catch (error) {
                    console.error('Error al cargar artículos:', error);
                    mostrarErrorModal('Error al cargar los artículos');
                }
            }

            function mostrarArticulosModal(articulos) {
                if (articulos.length === 0) {
                    mostrarMensajeVacioModal('No se encontraron artículos');
                } else {
                    elements.modalArticulosDisponibles.innerHTML = articulos.map(crearCardArticuloModal).join('');
                }
            }

            function crearCardArticuloModal(articulo) {
                const stockClass = utils.getStockClass(articulo.stock);
                const imageUrl = utils.getImageUrl(articulo.imagen);
                const escapedArticulo = utils.escapeHtml(JSON.stringify(articulo));
                
                const tienePromocion = articulo.tiene_precio_promocion === true;
                const precioPromocionFormateado = articulo.precio_promocion_formateado || '';
                
                let precioInfo = '';
                if (tienePromocion && state.usarPrecioPromocion) {
                    precioInfo = `
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">${articulo.precio_formateado || '$0.00'}</span>
                        <span class="text-xs text-neutral-500 line-through ml-1">${articulo.precio_original_formateado || '$0.00'}</span>
                    `;
                } else if (tienePromocion) {
                    precioInfo = `
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">${articulo.precio_original_formateado || '$0.00'}</span>
                        <span class="text-xs text-blue-600 dark:text-blue-400 ml-1">Promo: ${precioPromocionFormateado}</span>
                    `;
                } else {
                    precioInfo = `<span class="text-sm font-medium text-green-600 dark:text-green-400">${articulo.precio_original_formateado || '$0.00'}</span>`;
                }
                
                return `
                    <div class="flex items-center justify-between p-3 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors duration-200">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <img src="${imageUrl}" 
                                 alt="${articulo.nombre}" 
                                 class="w-10 h-10 object-cover rounded-lg flex-shrink-0" 
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-10 h-10 bg-neutral-100 dark:bg-neutral-600 rounded-lg flex items-center justify-center flex-shrink-0" style="display: none;">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-neutral-900 dark:text-white truncate">${articulo.nombre}</div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">Código: ${articulo.codigo}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 flex-shrink-0">
                            <div class="text-right">
                                <div class="text-sm">${precioInfo}</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Stock: <span class="font-medium ${stockClass}">${articulo.stock}</span>
                                </div>
                            </div>
                            <button onclick="agregarArticuloDesdeModal(${escapedArticulo})" 
                                    class="px-3 py-1 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition-colors duration-200 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Agregar</span>
                            </button>
                        </div>
                    </div>
                `;
            }

            function mostrarMensajeVacioModal(mensaje) {
                elements.modalArticulosDisponibles.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-neutral-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-neutral-500 dark:text-neutral-400">${mensaje}</p>
                    </div>
                `;
            }

            function mostrarErrorModal(mensaje) {
                elements.modalArticulosDisponibles.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-600 dark:text-red-400">${mensaje}</p>
                    </div>
                `;
            }

            async function filtrarArticulosModal(query) {
                try {
                    const params = new URLSearchParams({
                        q: query,
                        usar_precio_promocion: state.usarPrecioPromocion
                    });
                    
                    const response = await fetch(`${CONFIG.ROUTES.SEARCH_ARTICULOS}?${params}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });
                    
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    
                    const data = await response.json();
                    mostrarArticulosModal(data);
                } catch (error) {
                    console.error('Error al filtrar artículos:', error);
                    mostrarErrorModal('Error al filtrar los artículos');
                }
            }

            function agregarArticuloDesdeModal(articulo) {
                if (state.itemsVenta.find(item => item.id === articulo.id)) {
                    alert('Este artículo ya está agregado a la venta');
                    return;
                }

                const precioAUsar = utils.getEffectivePrice(articulo, state.usarPrecioPromocion);

                state.itemsVenta.push({
                    id: articulo.id,
                    nombre: articulo.nombre,
                    codigo: articulo.codigo,
                    precio: precioAUsar,
                    precioOriginal: precioAUsar,
                    stock: parseInt(articulo.stock),
                    imagen: articulo.imagen,
                    cantidad: 1,
                    subtotal: precioAUsar
                });

                actualizarVista();
                
                // Mostrar feedback visual de que se agregó
                mostrarFeedbackAgregado(articulo.nombre);
            }

            function eliminarArticulo(index) {
                state.itemsVenta.splice(index, 1);
                actualizarVista();
            }

            function actualizarCantidad(index, nuevaCantidad) {
                const item = state.itemsVenta[index];
                const cantidadValidada = utils.validateQuantity(nuevaCantidad, item.stock);
                
                if (cantidadValidada !== nuevaCantidad) {
                    alert(`La cantidad se ajustó al límite disponible (${item.stock})`);
                }
                
                item.cantidad = cantidadValidada;
                item.subtotal = item.cantidad * item.precio;
                actualizarVista();
            }

            function actualizarPrecio(index, nuevoPrecio) {
                const item = state.itemsVenta[index];
                const precioValidado = utils.validatePrice(nuevoPrecio);
                
                if (precioValidado === 0 && nuevoPrecio !== '0') {
                    alert('El precio debe ser un número válido');
                    return;
                }
                
                item.precio = precioValidado;
                item.subtotal = item.cantidad * precioValidado;
                actualizarVista();
            }

            function actualizarVista() {
                actualizarContadores();
                actualizarTotal();
                actualizarListaItems();
            }

            function actualizarContadores() {
                elements.itemsCount.textContent = `${state.itemsVenta.length} artículo${state.itemsVenta.length !== 1 ? 's' : ''}`;
            }

            function actualizarTotal() {
                const total = state.itemsVenta.reduce((sum, item) => sum + item.subtotal, 0);
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
                const precioModificado = item.precio !== item.precioOriginal;
                
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
                                    
                                    <!-- Precio editable -->
                                    <div class="flex items-center space-x-2 mt-1">
                                        <label class="text-sm text-neutral-600 dark:text-neutral-400">Precio:</label>
                                        <div class="relative">
                                            <input type="number" 
                                                   min="0" 
                                                   step="0.01"
                                                   value="${item.precio}"
                                                   onchange="actualizarPrecio(${index}, this.value)"
                                                   class="w-20 px-2 py-1 text-sm border ${precioModificado ? 'border-orange-400 bg-orange-50 dark:bg-orange-900/20' : 'border-neutral-300 dark:border-neutral-600'} rounded bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                                            ${precioModificado ? '<div class="absolute -top-1 -right-1 w-2 h-2 bg-orange-400 rounded-full" title="Precio modificado"></div>' : ''}
                                        </div>
                                        ${precioModificado ? `<span class="text-xs text-orange-600 dark:text-orange-400">Original: $${utils.formatPrice(item.precioOriginal)}</span>` : ''}
                                    </div>
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

            function enviarVenta() {
                crearInputsOcultos();
                mostrarLoading();
                elements.ventaForm.submit();
            }

            function crearInputsOcultos() {
                state.itemsVenta.forEach((item, index) => {
                    const inputs = [
                        { name: `items[${index}][articulo_id]`, value: item.id },
                        { name: `items[${index}][cantidad]`, value: item.cantidad },
                        { name: `items[${index}][precio_unitario]`, value: item.precio },
                        { name: `items[${index}][detalle]`, value: item.nombre }
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
                    Guardando...
                `;
            }

            function abrirModalArticulos() {
                elements.modal.classList.remove('hidden');
                elements.modalSearchInput.focus();
                cargarArticulosModal('');
            }

            function cerrarModalArticulos() {
                elements.modal.classList.add('hidden');
                elements.modalSearchInput.value = '';
                elements.modalArticulosDisponibles.innerHTML = '';
            }

            function mostrarFeedbackAgregado(nombreArticulo) {
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center space-x-2';
                notification.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>${nombreArticulo} agregado a la venta</span>
                `;
                
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }

            window.agregarArticuloDesdeModal = agregarArticuloDesdeModal;
            window.eliminarArticulo = eliminarArticulo;
            window.actualizarCantidad = actualizarCantidad;
            window.actualizarPrecio = actualizarPrecio;
            window.togglePrecioPromocion = togglePrecioPromocion;
            window.abrirModalArticulos = abrirModalArticulos;
            window.cerrarModalArticulos = cerrarModalArticulos;

            // ===== TOGGLE PRECIO PROMOCIONAL =====
            function togglePrecioPromocion() {
                const checkbox = document.getElementById('usar-precio-promocion');
                state.usarPrecioPromocion = checkbox.checked;
                
                const toggleContainer = checkbox.nextElementSibling;
                const toggleBackground = toggleContainer.querySelector('div:first-child');
                const toggleCircle = toggleContainer.querySelector('div:nth-child(2)');
                const toggleIcon = toggleContainer.querySelector('div:last-child');
                
                if (state.usarPrecioPromocion) {
                    toggleBackground.className = 'w-12 h-6 bg-primary-500 dark:bg-primary-400 rounded-full shadow-inner transition-all duration-300 ease-in-out group-hover:shadow-md';
                    toggleCircle.className = 'absolute w-5 h-5 bg-white rounded-full shadow-lg top-0.5 left-6 transition-all duration-300 ease-in-out transform';
                    toggleIcon.className = 'absolute inset-0 flex items-center justify-center opacity-100 transition-opacity duration-300';
                } else {
                    toggleBackground.className = 'w-12 h-6 bg-gray-300 dark:bg-gray-600 rounded-full shadow-inner transition-all duration-300 ease-in-out group-hover:shadow-md';
                    toggleCircle.className = 'absolute w-5 h-5 bg-white rounded-full shadow-lg top-0.5 left-0.5 transition-all duration-300 ease-in-out transform';
                    toggleIcon.className = 'absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300';
                }
                
                if (!elements.modal.classList.contains('hidden')) {
                    const query = elements.modalSearchInput.value.trim();
                    filtrarArticulosModal(query);
                }
                
                actualizarPreciosItemsVenta();
            }
            
            function actualizarPreciosItemsVenta() {
                state.itemsVenta.forEach(item => {
                    const articuloActualizado = state.todosLosArticulos.find(a => a.id === item.id);
                    if (articuloActualizado) {
                        const nuevoPrecio = utils.getEffectivePrice(articuloActualizado, state.usarPrecioPromocion);
                        
                        // Solo actualizar si el precio original no ha sido modificado manualmente
                        if (item.precio === item.precioOriginal) {
                            item.precio = nuevoPrecio;
                            item.precioOriginal = nuevoPrecio;
                            item.subtotal = item.cantidad * nuevoPrecio;
                        }
                    }
                });
                actualizarVista();
            }

            // ===== INICIALIZAR APLICACIÓN =====
            init();
        });
    </script>
@endsection
