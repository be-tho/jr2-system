<?php
/** @var \App\Models\Articulo $articulo */
?>
@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Editar Artículo</h1>
                    <p class="text-primary-100 text-lg">Modifica la información del artículo existente</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="ri-edit-line text-4xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700">
        <div class="px-6 py-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">
                Información del Artículo
            </h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                Actualiza los campos que desees modificar
            </p>
        </div>

        <form action="{{ route('articulos.update', $articulo) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre del Artículo --}}
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Nombre del Artículo <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-shirt-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            value="{{ old('nombre', $articulo->nombre) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('nombre') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: Pollera tajo"
                            required
                        >
                    </div>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Código --}}
                <div>
                    <label for="codigo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Código <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-barcode-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="codigo" 
                            name="codigo" 
                            value="{{ old('codigo', $articulo->codigo) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('codigo') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Código único"
                            required
                        >
                    </div>
                    @error('codigo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-stack-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="number" 
                            id="stock" 
                            name="stock" 
                            value="{{ old('stock', $articulo->stock) }}"
                            min="0"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('stock') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Cantidad disponible"
                            required
                        >
                    </div>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio --}}
                <div>
                    <label for="precio" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Precio <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-money-dollar-circle-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="number" 
                            id="precio" 
                            name="precio" 
                            value="{{ old('precio', $articulo->precio) }}"
                            min="0"
                            step="0.01"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('precio') border-red-500 dark:border-red-400 @enderror"
                            placeholder="0.00"
                            required
                        >
                    </div>
                    @error('precio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categoría --}}
                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-folder-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <select 
                            id="categoria_id" 
                            name="categoria_id" 
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('categoria_id') border-red-500 dark:border-red-400 @enderror"
                            required
                        >
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias ?? [] as $categoria)
                                <option value="{{ $categoria->id }}" {{ (old('categoria_id', $articulo->categoria_id) == $categoria->id) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('categoria_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Temporada --}}
                <div>
                    <label for="temporada_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Temporada <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-calendar-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <select 
                            id="temporada_id" 
                            name="temporada_id" 
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('temporada_id') border-red-500 dark:border-red-400 @enderror"
                            required
                        >
                            <option value="">Selecciona una temporada</option>
                            @foreach($temporadas ?? [] as $temporada)
                                <option value="{{ $temporada->id }}" {{ (old('temporada_id', $articulo->temporada_id) == $temporada->id) ? 'selected' : '' }}>
                                    {{ $temporada->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('temporada_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Descripción
                    </label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        rows="3"
                        class="block w-full px-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 resize-vertical @error('descripcion') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Describe las características del artículo..."
                    >{{ old('descripcion', $articulo->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Imagen actual --}}
                @if($articulo->imagen && $articulo->imagen !== 'default-articulo.png')
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Imagen Actual
                        </label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('src/assets/uploads/articulos/' . $articulo->imagen) }}" 
                                 alt="Imagen actual del artículo" 
                                 class="w-24 h-24 object-cover rounded-lg border border-neutral-300 dark:border-neutral-600">
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                <p>Imagen actual: {{ $articulo->imagen }}</p>
                                <p class="text-xs text-neutral-500">Deja vacío para mantener la imagen actual</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Nueva imagen --}}
                <div class="md:col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Nueva Imagen
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-image-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="file" 
                            id="imagen" 
                            name="imagen" 
                            accept="image/*"
                            capture="environment"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('imagen') border-red-500 dark:border-red-400 @enderror"
                        >
                    </div>
                    
                    {{-- Botones de selección rápida para móviles --}}
                    <div class="mobile-camera-buttons">
                        <button type="button" onclick="selectFromCamera()" class="camera-btn">
                            <i class="ri-camera-line"></i>
                            Cámara
                        </button>
                        <button type="button" onclick="selectFromGallery()" class="gallery-btn">
                            <i class="ri-image-line"></i>
                            Galería
                        </button>
                    </div>
                    
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                        Formatos permitidos: JPG, PNG, GIF, WEBP. Tamaño máximo: 20MB
                    </p>
                    @error('imagen')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <button 
                    type="submit" 
                    class="flex-1 sm:flex-none bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-medium py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    <i class="ri-save-line mr-2"></i>
                    Actualizar Artículo
                </button>
                
                <a href="{{ route('articulos.show', $articulo) }}" 
                   class="flex-1 sm:flex-none bg-neutral-500 hover:bg-neutral-600 text-white font-medium py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 text-center">
                    <i class="ri-arrow-left-line mr-2"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones para manejo de imágenes móviles
function selectFromCamera() {
    const input = document.getElementById('imagen');
    input.setAttribute('capture', 'environment');
    input.click();
}

function selectFromGallery() {
    const input = document.getElementById('imagen');
    input.removeAttribute('capture');
    input.click();
}

// Compresión automática de imágenes en el frontend
function compressImage(file) {
    return new Promise((resolve) => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        
        img.onload = function() {
            // Calcular nuevas dimensiones manteniendo proporción
            const maxWidth = 4000;
            const maxHeight = 4000;
            let { width, height } = img;
            
            if (width > maxWidth) {
                height = (height * maxWidth) / width;
                width = maxWidth;
            }
            
            if (height > maxHeight) {
                width = (width * maxHeight) / height;
                height = maxHeight;
            }
            
            canvas.width = width;
            canvas.height = height;
            
            // Dibujar imagen redimensionada
            ctx.drawImage(img, 0, 0, width, height);
            
            // Convertir a blob con compresión
            canvas.toBlob((blob) => {
                // Crear nuevo archivo
                const compressedFile = new File([blob], file.name, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });
                resolve(compressedFile);
            }, 'image/jpeg', 0.75); // Calidad 75%
        };
        
        img.src = URL.createObjectURL(file);
    });
}

// Manejar cambio de archivo
document.getElementById('imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    // Si el archivo es muy grande, comprimir automáticamente
    if (file.size > 10 * 1024 * 1024) { // Más de 10MB
        compressImage(file).then(compressedFile => {
            // Crear un nuevo FileList con el archivo comprimido
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            e.target.files = dataTransfer.files;
            
            // Mostrar notificación
            showNotification('Imagen comprimida automáticamente para optimizar el tamaño', 'info');
        });
    }
});

function showNotification(message, type = 'info') {
    // Crear notificación temporal
    const notification = document.createElement('div');
    notification.className = `mobile-notification ${
        type === 'info' ? 'bg-blue-500' : 'bg-green-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
