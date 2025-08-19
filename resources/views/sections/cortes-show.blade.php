<?php
/** @var \App\Models\Corte $corte */
?>
@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Corte N° {{ $corte->numero_corte }}</h1>
                    <p class="text-blue-100 text-lg">{{ $corte->nombre }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    {{-- Estado del corte --}}
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        @if($corte->estado == 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                <i class="ri-scissors-cut-line mr-2"></i>
                                Cortado
                            </span>
                        @elseif($corte->estado == 1)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                <i class="ri-user-settings-line mr-2"></i>
                                Costurando
                            </span>
                        @elseif($corte->estado == 2)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                <i class="ri-check-line mr-2"></i>
                                Recibido
                            </span>
                        @endif
                    </div>
                    
                    {{-- Botón volver --}}
                    <a href="{{ route('cortes.index') }}" 
                       class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 flex items-center">
                        <i class="ri-arrow-left-line mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Información principal del corte --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Columna izquierda - Información básica --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Detalles del corte --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="ri-scissors-cut-line text-blue-500 mr-3"></i>
                        Detalles del Corte
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Número de Corte --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="ri-hashtag text-blue-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Número de Corte</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $corte->numero_corte }}</p>
                        </div>

                        {{-- Nombre --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="ri-scissors-cut-line text-blue-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nombre</span>
                            </div>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $corte->nombre }}</p>
                        </div>

                        {{-- Cantidad --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="ri-stack-line text-blue-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Cantidad</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $corte->cantidad }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">unidades</p>
                        </div>

                        {{-- Fecha --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="ri-calendar-line text-blue-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha</span>
                            </div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($corte->fecha)->locale('es')->isoFormat('dddd D \d\e MMMM \d\e Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Especificaciones técnicas --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="ri-settings-3-line text-purple-500 mr-3"></i>
                        Especificaciones Técnicas
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Colores --}}
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="ri-palette-line text-purple-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Colores</span>
                            </div>
                            <div class="space-y-2">
                                @foreach(explode(',', $corte->colores) as $color)
                                    <span class="inline-block bg-white dark:bg-gray-700 px-3 py-1 rounded-full text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        {{ trim($color) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Artículos --}}
                        <div class="bg-gradient-to-br from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="ri-shirt-line text-green-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Artículos</span>
                            </div>
                            <div class="space-y-2">
                                @foreach(explode(',', $corte->articulos) as $articulo)
                                    <span class="inline-block bg-white dark:bg-gray-700 px-3 py-1 rounded-full text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        {{ trim($articulo) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Costureros --}}
                        <div class="bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-lg p-4 md:col-span-2">
                            <div class="flex items-center mb-3">
                                <i class="ri-user-settings-line text-orange-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Costureros Asignados</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $corte->costureros) as $costurero)
                                    <span class="inline-flex items-center bg-white dark:bg-gray-700 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        <i class="ri-user-line text-orange-500 mr-2"></i>
                                        {{ trim($costurero) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Descripción --}}
            @if($corte->descripcion)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="ri-file-text-line text-indigo-500 mr-3"></i>
                        Descripción
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $corte->descripcion }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Columna derecha - Imagen y acciones --}}
        <div class="space-y-6">
            {{-- Imagen del corte --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="ri-image-line text-pink-500 mr-3"></i>
                        Imagen del Corte
                    </h2>
                </div>
                <div class="p-6">
                    <div class="relative group cursor-pointer" onclick="openImageModal()">
                        <img src="{{ \App\Helpers\ImageHelper::getCorteImageUrl($corte->imagen) }}" 
                             alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($corte->imagen, 'default-corte.svg', $corte->nombre, 'corte') }}" 
                             class="w-full h-64 object-cover rounded-lg border border-gray-200 dark:border-gray-600 transition-transform duration-300 group-hover:scale-105 {{ \App\Helpers\ImageHelper::getDefaultImageClass($corte->imagen, 'default-corte.svg') }}">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 rounded-lg flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="ri-zoom-in-line text-white text-3xl"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 text-center">
                        Click para ampliar
                    </p>
                </div>
            </div>

            {{-- Acciones rápidas --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="ri-tools-line text-green-500 mr-3"></i>
                        Acciones
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('cortes.edit', $corte) }}" 
                       class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center group">
                        <i class="ri-edit-line mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        Editar Corte
                    </a>
                    
                    <form action="{{ route('cortes.delete', $corte) }}" method="POST" class="w-full" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este corte?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center group">
                            <i class="ri-delete-bin-line mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            Eliminar Corte
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de imagen --}}
<div id="imageModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img src="{{ \App\Helpers\ImageHelper::getCorteImageUrl($corte->imagen) }}" 
             alt="{{ \App\Helpers\ImageHelper::getDefaultImageAlt($corte->imagen, 'default-corte.svg', $corte->nombre, 'corte') }}" 
             class="w-full h-auto max-h-[90vh] object-contain rounded-lg shadow-2xl {{ \App\Helpers\ImageHelper::getDefaultImageClass($corte->imagen, 'default-corte.svg') }}">
        
        {{-- Botón cerrar --}}
        <button onclick="closeImageModal()" 
                class="absolute -top-4 -right-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <i class="ri-close-line text-xl"></i>
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
@endsection
