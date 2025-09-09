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
                <ol class="flex items-center space-x-2 text-sm text-neutral-600">
                    <li>
                        <a href="{{ route('articulos.index') }}" class="hover:text-primary-600 transition-colors duration-200">
                            Artículos
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    @if($articulo->categoria)
                    <li>
                        <a href="{{ route('articulos.index', ['categoria_id' => $articulo->categoria->id]) }}" class="hover:text-primary-600 transition-colors duration-200">
                            {{ $articulo->categoria->nombre }}
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    @endif
                    <li class="text-neutral-900 font-medium">{{ $articulo->nombre }}</li>
                </ol>
            </nav>

            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 mb-2">{{ $articulo->nombre }}</h1>
                    <p class="text-lg text-neutral-600 font-mono">#{{ $articulo->codigo }}</p>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('articulos.edit', $articulo) }}" 
                       class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    
                    <a href="{{ route('articulos.index') }}" 
                       class="bg-neutral-600 hover:bg-neutral-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8">
            <!-- Columna izquierda - Galería de imágenes -->
            <div class="space-y-4 lg:space-y-6">
                @if($articulo->hasMultipleImages())
                    <!-- Galería principal -->
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                        <!-- Imagen principal -->
                        <div class="relative group cursor-pointer touch-manipulation" onclick="openImageModal(0)">
                            <img id="mainImage" src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->getMainImage()) }}" 
                                 alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($articulo->getMainImage(), 'default-articulo.svg', $articulo->nombre, 'artículo') }}" 
                                 class="w-full h-80 sm:h-96 lg:h-[28rem] xl:h-[32rem] object-cover {{ \App\Helpers\ImageHelper::getDefaultImageClass($articulo->getMainImage(), 'default-articulo.svg') }}" />
                            
                            <!-- Overlay de zoom -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 group-active:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 group-active:opacity-100 transition-opacity duration-300">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Indicador de múltiples imágenes en móvil -->
                            @if($articulo->getImageCount() > 1)
                                <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full sm:hidden">
                                    {{ $articulo->getImageCount() }} imágenes
                                </div>
                            @endif
                        </div>
                        
                        <!-- Miniaturas -->
                        <div class="p-3 sm:p-4">
                            <div class="flex space-x-2 overflow-x-auto pb-2 -mb-2 thumbnails-scroll" style="scrollbar-width: thin;">
                                @foreach($articulo->getAllImages() as $index => $image)
                                    <button onclick="changeMainImage('{{ \App\Helpers\ImageHelper::getArticuloImageUrl($image) }}', {{ $index }})" 
                                            class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-500 active:border-primary-500 transition-colors duration-200 gallery-thumbnail touch-feedback {{ $index === 0 ? 'border-primary-500' : '' }}">
                                        <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($image) }}" 
                                             alt="Miniatura {{ $index + 1 }}" 
                                             class="w-full h-full object-cover" />
                                    </button>
                                @endforeach
                            </div>
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 mt-2 text-center">
                                <span class="hidden sm:inline">Click en una miniatura para cambiar la imagen principal</span>
                                <span class="sm:hidden">Toca una miniatura para cambiar</span>
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Imagen única -->
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                        <div class="relative group cursor-pointer touch-manipulation" onclick="openImageModal(0)">
                            <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                                 alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($articulo->imagen, 'default-articulo.svg', $articulo->nombre, 'artículo') }}" 
                                 class="w-full h-80 sm:h-96 lg:h-[28rem] xl:h-[32rem] object-cover {{ \App\Helpers\ImageHelper::getDefaultImageClass($articulo->imagen, 'default-articulo.svg') }}" />
                            
                            <!-- Overlay de zoom -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 group-active:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 group-active:opacity-100 transition-opacity duration-300">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-3 sm:p-4 text-center">
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                                <span class="hidden sm:inline">Click para ampliar</span>
                                <span class="sm:hidden">Toca para ampliar</span>
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Información adicional -->
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información del Artículo
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">Código:</span>
                            <span class="font-mono font-medium text-neutral-900 dark:text-white">#{{ $articulo->codigo }}</span>
                        </div>
                        
                        @if($articulo->categoria)
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">Categoría:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300">
                                {{ $articulo->categoria->nombre }}
                            </span>
                        </div>
                        @endif
                        
                        @if($articulo->temporada)
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">Temporada:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-secondary-100 dark:bg-secondary-900/20 text-secondary-800 dark:text-secondary-300">
                                {{ $articulo->temporada->nombre }}
                            </span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">Fecha de creación:</span>
                            <span class="text-neutral-900 dark:text-white">{{ $articulo->created_at ? $articulo->created_at->format('d/m/Y') : 'No disponible' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-neutral-600 dark:text-neutral-400">Última actualización:</span>
                            <span class="text-neutral-900 dark:text-white">{{ $articulo->updated_at ? $articulo->updated_at->format('d/m/Y') : 'No disponible' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información del producto -->
            <div class="space-y-6">
                <!-- Precio y stock -->
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">${{ number_format($articulo->precio, 0, ',', '.') }}</h2>
                        
                        <!-- Badge de stock -->
                        @if($articulo->stock > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                En stock
                            </span>
                        @elseif($articulo->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-accent-100 dark:bg-accent-900/20 text-accent-800 dark:text-accent-300">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"></path>
                                </svg>
                                Stock bajo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"></path>
                                </svg>
                                Sin stock
                            </span>
                        @endif
                    </div>
                    
                    <!-- Información de stock -->
                    <div class="bg-gradient-neutral-subtle-border dark:bg-gradient-neutral-subtle rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">Stock disponible:</span>
                            <span class="text-2xl font-bold {{ $articulo->stock > 10 ? 'text-green-600 dark:text-green-400' : ($articulo->stock > 0 ? 'text-accent-600 dark:text-accent-400' : 'text-red-600 dark:text-red-400') }}">
                                {{ $articulo->stock }} unidades
                            </span>
                        </div>
                        
                        @if($articulo->stock > 0)
                        <div class="mt-2">
                            <div class="w-full bg-neutral-200 dark:bg-neutral-600 rounded-full h-2">
                                @php
                                    $stockPercentage = min(100, ($articulo->stock / max(1, $articulo->stock)) * 100);
                                    $stockColor = $articulo->stock > 10 ? 'bg-green-500' : 'bg-accent-500';
                                @endphp
                                <div class="{{ $stockColor }} h-2 rounded-full transition-all duration-300" style="width: {{ $stockPercentage }}%"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Acciones rápidas -->
                    <div class="space-y-3">
                        <a href="{{ route('articulos.edit', $articulo) }}" 
                           class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Artículo
                        </a>
                        
                        <x-delete-modal 
                            :route="route('articulos.delete', $articulo)"
                            triggerText="Eliminar Artículo"
                            modalTitle="Eliminar Artículo"
                            modalMessage="¿Estás seguro de que quieres eliminar este artículo?"
                            modalDescription="Esta acción eliminará permanentemente el artículo y no se puede deshacer."
                            confirmText="Sí, eliminar artículo"
                            cancelText="Cancelar"
                            size="md"
                            variant="danger"
                            icon="ri-delete-bin-line"
                            fullWidth="true"
                            itemName="artículo"
                        />
                        
                        <button onclick="window.print()" 
                                class="w-full bg-neutral-600 hover:bg-neutral-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Imprimir
                        </button>
                    </div>
                </div>

                <!-- Descripción -->
                @if($articulo->descripcion)
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Descripción
                    </h3>
                    <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed">{{ $articulo->descripcion }}</p>
                </div>
                @endif

                <!-- Características del producto -->
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 text-secondary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Características
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-neutral-700 dark:text-neutral-300">Código único identificador</span>
                        </div>
                        
                        @if($articulo->categoria)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-neutral-700 dark:text-neutral-300">Categorizado como {{ $articulo->categoria->nombre }}</span>
                        </div>
                        @endif
                        
                        @if($articulo->temporada)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-neutral-700 dark:text-neutral-300">Temporada {{ $articulo->temporada->nombre }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-neutral-700 dark:text-neutral-300">Precio competitivo en el mercado</span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-neutral-700 dark:text-neutral-300">Control de inventario en tiempo real</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de galería de imágenes -->
        <div id="imageModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-2 sm:p-4 modal-mobile">
            <div class="relative max-w-6xl max-h-full w-full">
                @if($articulo->hasMultipleImages())
                    <!-- Galería completa -->
                    <div class="bg-white dark:bg-neutral-800 rounded-xl overflow-hidden">
                        <!-- Header del modal -->
                        <div class="flex items-center justify-between p-3 sm:p-4 border-b border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 dark:text-white truncate pr-2">
                                Galería - {{ $articulo->nombre }}
                            </h3>
                            <button onclick="closeImageModal()" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 touch-manipulation flex-shrink-0 w-8 h-8 sm:w-6 sm:h-6 flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Imagen principal del modal -->
                        <div class="relative">
                            <img id="modalMainImage" src="" alt="" class="w-full h-auto max-h-[60vh] sm:max-h-[70vh] object-contain">
                            
                            <!-- Navegación -->
                            @if($articulo->getImageCount() > 1)
                                <button id="prevBtn" onclick="previousImage()" class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-white/90 dark:bg-neutral-800/90 text-neutral-900 dark:text-white rounded-full w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-neutral-700 active:bg-white dark:active:bg-neutral-700 transition-colors duration-200 touch-manipulation">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                
                                <button id="nextBtn" onclick="nextImage()" class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-white/90 dark:bg-neutral-800/90 text-neutral-900 dark:text-white rounded-full w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-neutral-700 active:bg-white dark:active:bg-neutral-700 transition-colors duration-200 touch-manipulation">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        
                        <!-- Miniaturas del modal -->
                        @if($articulo->getImageCount() > 1)
                            <div class="p-3 sm:p-4 border-t border-neutral-200 dark:border-neutral-700">
                                <div class="flex space-x-2 overflow-x-auto justify-center pb-2 -mb-2 thumbnails-scroll" style="scrollbar-width: thin;">
                                    @foreach($articulo->getAllImages() as $index => $image)
                                        <button onclick="showModalImage({{ $index }})" 
                                                class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-500 active:border-primary-500 transition-colors duration-200 modal-thumbnail gallery-thumbnail touch-feedback" 
                                                data-index="{{ $index }}">
                                            <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($image) }}" 
                                                 alt="Miniatura {{ $index + 1 }}" 
                                                 class="w-full h-full object-cover" />
                                        </button>
                                    @endforeach
                                </div>
                                <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 mt-2 text-center">
                                    Imagen <span id="currentImageNumber">1</span> de {{ $articulo->getImageCount() }}
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Modal simple para imagen única -->
                    <div class="relative">
                        <img id="modalMainImage" src="" alt="" class="w-full h-auto max-h-[85vh] sm:max-h-[90vh] object-contain rounded-lg shadow-2xl">
                        
                        <!-- Botón cerrar -->
                        <button onclick="closeImageModal()" 
                                class="absolute -top-2 -right-2 sm:-top-4 sm:-right-4 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white rounded-full w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shadow-lg hover:bg-neutral-100 dark:hover:bg-neutral-700 active:bg-neutral-100 dark:active:bg-neutral-700 transition-colors duration-200 touch-manipulation">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <script>
        // Variables globales para la galería
        let currentImageIndex = 0;
        let images = [];
        let touchStartX = 0;
        let touchEndX = 0;
        let isModalOpen = false;
        
        // Inicializar imágenes
        document.addEventListener('DOMContentLoaded', function() {
            @if($articulo->hasMultipleImages())
                images = [
                    @foreach($articulo->getAllImages() as $index => $image)
                        '{{ \App\Helpers\ImageHelper::getArticuloImageUrl($image) }}'{{ $index < $articulo->getImageCount() - 1 ? ',' : '' }}
                    @endforeach
                ];
            @else
                images = ['{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}'];
            @endif
            
            // Configurar gestos táctiles para móvil
            setupTouchGestures();
        });

        // Configurar gestos táctiles
        function setupTouchGestures() {
            const modal = document.getElementById('imageModal');
            const mainImage = document.getElementById('mainImage');
            
            // Gestos para la imagen principal
            if (mainImage) {
                mainImage.addEventListener('touchstart', handleTouchStart, { passive: true });
                mainImage.addEventListener('touchend', handleTouchEnd, { passive: true });
            }
            
            // Gestos para el modal
            if (modal) {
                modal.addEventListener('touchstart', handleTouchStart, { passive: true });
                modal.addEventListener('touchend', handleTouchEnd, { passive: true });
            }
        }

        // Manejar inicio de toque
        function handleTouchStart(e) {
            touchStartX = e.touches[0].clientX;
        }

        // Manejar fin de toque
        function handleTouchEnd(e) {
            touchEndX = e.changedTouches[0].clientX;
            handleSwipeGesture();
        }

        // Manejar gesto de deslizar
        function handleSwipeGesture() {
            const swipeThreshold = 50;
            const swipeDistance = touchEndX - touchStartX;
            
            if (Math.abs(swipeDistance) > swipeThreshold) {
                if (swipeDistance > 0) {
                    // Deslizar hacia la derecha - imagen anterior
                    if (isModalOpen && images.length > 1) {
                        previousImage();
                    }
                } else {
                    // Deslizar hacia la izquierda - imagen siguiente
                    if (isModalOpen && images.length > 1) {
                        nextImage();
                    }
                }
            }
        }

        // Cambiar imagen principal desde miniatura
        function changeMainImage(imageSrc, index) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = imageSrc;
            currentImageIndex = index;
            
            // Actualizar bordes de miniaturas
            document.querySelectorAll('.flex-shrink-0').forEach((btn, i) => {
                btn.classList.toggle('border-primary-500', i === index);
                btn.classList.toggle('border-transparent', i !== index);
            });
        }

        // Abrir modal de imagen
        function openImageModal(index = 0) {
            currentImageIndex = index;
            isModalOpen = true;
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalMainImage');
            
            modalImage.src = images[currentImageIndex];
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Prevenir scroll en móvil
            if (window.innerWidth < 768) {
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            }
            
            updateModalUI();
        }

        // Cerrar modal
        function closeImageModal() {
            isModalOpen = false;
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Restaurar scroll en móvil
            if (window.innerWidth < 768) {
                document.body.style.position = '';
                document.body.style.width = '';
            }
        }

        // Mostrar imagen específica en el modal
        function showModalImage(index) {
            currentImageIndex = index;
            const modalImage = document.getElementById('modalMainImage');
            modalImage.src = images[currentImageIndex];
            updateModalUI();
        }

        // Imagen anterior
        function previousImage() {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
            const modalImage = document.getElementById('modalMainImage');
            modalImage.src = images[currentImageIndex];
            updateModalUI();
        }

        // Imagen siguiente
        function nextImage() {
            currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
            const modalImage = document.getElementById('modalMainImage');
            modalImage.src = images[currentImageIndex];
            updateModalUI();
        }

        // Actualizar UI del modal
        function updateModalUI() {
            // Actualizar número de imagen
            const currentImageNumber = document.getElementById('currentImageNumber');
            if (currentImageNumber) {
                currentImageNumber.textContent = currentImageIndex + 1;
            }
            
            // Actualizar bordes de miniaturas del modal
            document.querySelectorAll('.modal-thumbnail').forEach((btn, i) => {
                btn.classList.toggle('border-primary-500', i === currentImageIndex);
                btn.classList.toggle('border-transparent', i !== currentImageIndex);
            });
        }

        // Navegación con teclado
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (!modal.classList.contains('hidden')) {
                switch(e.key) {
                    case 'Escape':
                        closeImageModal();
                        break;
                    case 'ArrowLeft':
                        previousImage();
                        break;
                    case 'ArrowRight':
                        nextImage();
                        break;
                }
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
