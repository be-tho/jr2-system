<?php
/** @var \App\Models\Articulo $articulo **/
?>
@extends('layout.app')
@section('title', $articulo->nombre)
@section('content')
    <x-container-wrapp>
        <!-- Header con breadcrumb y botón volver -->
        <div class="mb-6">
            <nav aria-label="Breadcrumb" class="mb-4">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li>
                        <a href="{{ route('articulos.index') }}" class="hover:text-blue-600 transition-colors duration-200">
                            Artículos
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    @if($articulo->categoria)
                    <li>
                        <a href="{{ route('articulos.index', ['categoria_id' => $articulo->categoria->id]) }}" class="hover:text-blue-600 transition-colors duration-200">
                            {{ $articulo->categoria->nombre }}
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    @endif
                    <li class="text-gray-900 font-medium">{{ $articulo->nombre }}</li>
                </ol>
            </nav>

            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $articulo->nombre }}</h1>
                    <p class="text-lg text-gray-600 font-mono">#{{ $articulo->codigo }}</p>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('articulos.edit', $articulo) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    
                    <a href="{{ route('articulos.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Columna izquierda - Imagen -->
            <div class="space-y-6">
                <!-- Imagen principal -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="relative group cursor-pointer" onclick="openImageModal()">
                        <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                             alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($articulo->imagen, 'default-articulo.svg', $articulo->nombre, 'artículo') }}" 
                             class="w-full h-96 object-cover {{ \App\Helpers\ImageHelper::getDefaultImageClass($articulo->imagen, 'default-articulo.svg') }}" />
                        
                        <!-- Overlay de zoom -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 text-center">
                        <p class="text-sm text-gray-500">Click para ampliar</p>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información del Artículo
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Código:</span>
                            <span class="font-mono font-medium text-gray-900">#{{ $articulo->codigo }}</span>
                        </div>
                        
                        @if($articulo->categoria)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Categoría:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $articulo->categoria->nombre }}
                            </span>
                        </div>
                        @endif
                        
                        @if($articulo->temporada)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Temporada:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-purple-100 text-purple-800">
                                {{ $articulo->temporada->nombre }}
                            </span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Fecha de creación:</span>
                            <span class="text-gray-900">{{ $articulo->created_at ? $articulo->created_at->format('d/m/Y') : 'No disponible' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Última actualización:</span>
                            <span class="text-gray-900">{{ $articulo->updated_at ? $articulo->updated_at->format('d/m/Y') : 'No disponible' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información del producto -->
            <div class="space-y-6">
                <!-- Precio y stock -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">${{ number_format($articulo->precio, 0, ',', '.') }}</h2>
                        
                        <!-- Badge de stock -->
                        @if($articulo->stock > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                En stock
                            </span>
                        @elseif($articulo->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"></path>
                                </svg>
                                Stock bajo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"></path>
                                </svg>
                                Sin stock
                            </span>
                        @endif
                    </div>
                    
                    <!-- Información de stock -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Stock disponible:</span>
                            <span class="text-2xl font-bold {{ $articulo->stock > 10 ? 'text-green-600' : ($articulo->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $articulo->stock }} unidades
                            </span>
                        </div>
                        
                        @if($articulo->stock > 0)
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $stockPercentage = min(100, ($articulo->stock / max(1, $articulo->stock)) * 100);
                                    $stockColor = $articulo->stock > 10 ? 'bg-green-500' : 'bg-yellow-500';
                                @endphp
                                <div class="{{ $stockColor }} h-2 rounded-full transition-all duration-300" style="width: {{ $stockPercentage }}%"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Acciones rápidas -->
                    <div class="space-y-3">
                        <a href="{{ route('articulos.edit', $articulo) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Artículo
                        </a>
                        
                        <button onclick="window.print()" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Imprimir
                        </button>
                    </div>
                </div>

                <!-- Descripción -->
                @if($articulo->descripcion)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Descripción
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $articulo->descripcion }}</p>
                </div>
                @endif

                <!-- Características del producto -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Características
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Código único identificador</span>
                        </div>
                        
                        @if($articulo->categoria)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Categorizado como {{ $articulo->categoria->nombre }}</span>
                        </div>
                        @endif
                        
                        @if($articulo->temporada)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Temporada {{ $articulo->temporada->nombre }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Precio competitivo en el mercado</span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Control de inventario en tiempo real</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de imagen -->
        <div id="imageModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
            <div class="relative max-w-4xl max-h-full">
                <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                     alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($articulo->imagen, 'default-articulo.svg', $articulo->nombre, 'artículo') }}" 
                     class="w-full h-auto max-h-[90vh] object-contain rounded-lg shadow-2xl {{ \App\Helpers\ImageHelper::getDefaultImageClass($articulo->imagen, 'default-articulo.svg') }}">
                
                <!-- Botón cerrar -->
                <button onclick="closeImageModal()" 
                        class="absolute -top-4 -right-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <script>
        function openImageModal() {
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });

        // Cerrar modal haciendo click fuera de la imagen
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
        </script>
    </x-container-wrapp>
@endsection
