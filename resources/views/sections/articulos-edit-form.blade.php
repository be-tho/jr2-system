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

                {{-- Galería de imágenes actuales --}}
                @if($articulo->hasMultipleImages() || ($articulo->imagen && $articulo->imagen !== 'default-articulo.svg'))
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Imágenes Actuales
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($articulo->imagen && $articulo->imagen !== 'default-articulo.svg')
                                <div class="space-y-2">
                                    <h4 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Imagen Principal</h4>
                                    <div class="relative">
                                        <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen) }}" 
                                             alt="Imagen principal actual" 
                                             class="w-full h-32 object-cover rounded-lg border border-neutral-300 dark:border-neutral-600">
                                        <div class="absolute top-2 right-2 bg-primary-500 text-white text-xs px-2 py-1 rounded-full">
                                            Principal
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($articulo->imagen_2)
                                <div class="space-y-2">
                                    <h4 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Segunda Imagen</h4>
                                    <div class="relative">
                                        <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen_2) }}" 
                                             alt="Segunda imagen actual" 
                                             class="w-full h-32 object-cover rounded-lg border border-neutral-300 dark:border-neutral-600">
                                        <div class="absolute top-2 right-2 bg-secondary-500 text-white text-xs px-2 py-1 rounded-full">
                                            2
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($articulo->imagen_3)
                                <div class="space-y-2">
                                    <h4 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Tercera Imagen</h4>
                                    <div class="relative">
                                        <img src="{{ \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->imagen_3) }}" 
                                             alt="Tercera imagen actual" 
                                             class="w-full h-32 object-cover rounded-lg border border-neutral-300 dark:border-neutral-600">
                                        <div class="absolute top-2 right-2 bg-accent-500 text-white text-xs px-2 py-1 rounded-full">
                                            3
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">
                            <i class="ri-information-line"></i> Deja vacío un campo de imagen para mantener la imagen actual
                        </p>
                    </div>
                @endif

                {{-- Galería de nuevas imágenes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Actualizar Galería de Imágenes
                    </label>
                    <div class="space-y-4">
                        {{-- Nueva imagen principal --}}
                        <div>
                            <label for="imagen" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">
                                Nueva Imagen Principal <span class="text-neutral-400">(Opcional)</span>
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
                                    class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('imagen') border-red-500 dark:border-red-400 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400"
                                >
                            </div>
                            @error('imagen')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nueva segunda imagen --}}
                        <div>
                            <label for="imagen_2" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">
                                Nueva Segunda Imagen <span class="text-neutral-400">(Opcional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-image-line text-neutral-400 dark:text-neutral-500"></i>
                                </div>
                                <input 
                                    type="file" 
                                    id="imagen_2" 
                                    name="imagen_2" 
                                    accept="image/*"
                                    class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('imagen_2') border-red-500 dark:border-red-400 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400"
                                >
                            </div>
                            @error('imagen_2')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nueva tercera imagen --}}
                        <div>
                            <label for="imagen_3" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">
                                Nueva Tercera Imagen <span class="text-neutral-400">(Opcional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-image-line text-neutral-400 dark:text-neutral-500"></i>
                                </div>
                                <input 
                                    type="file" 
                                    id="imagen_3" 
                                    name="imagen_3" 
                                    accept="image/*"
                                    class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('imagen_3') border-red-500 dark:border-red-400 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400"
                                >
                            </div>
                            @error('imagen_3')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Información sobre las imágenes --}}
                        <div class="bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="ri-information-line text-primary-600 dark:text-primary-400 text-lg mr-3 mt-0.5"></i>
                                <div class="text-sm text-primary-800 dark:text-primary-200">
                                    <p class="font-medium mb-2">Información sobre la actualización de imágenes:</p>
                                    <ul class="space-y-1 text-xs">
                                        <li>• <strong>Mantener imágenes:</strong> Deja vacío un campo para mantener la imagen actual</li>
                                        <li>• <strong>Reemplazar imágenes:</strong> Selecciona una nueva imagen para reemplazar la actual</li>
                                        <li>• <strong>Formatos soportados:</strong> JPG, PNG, GIF, WEBP, HEIC (iPhone)</li>
                                        <li>• <strong>Tamaño máximo:</strong> 50MB por imagen (se optimizarán automáticamente)</li>
                                        <li>• <strong>Total máximo:</strong> 3 imágenes por artículo</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Vista previa de nuevas imágenes --}}
                        <div id="imagePreviews" class="grid grid-cols-1 md:grid-cols-3 gap-4 hidden">
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nueva Imagen Principal</h4>
                                <div class="relative">
                                    <img id="preview1" src="" alt="Vista previa 1" class="w-full h-32 object-cover rounded-lg border border-neutral-200 dark:border-neutral-700">
                                    <button onclick="removeImage(1)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nueva Segunda Imagen</h4>
                                <div class="relative">
                                    <img id="preview2" src="" alt="Vista previa 2" class="w-full h-32 object-cover rounded-lg border border-neutral-200 dark:border-neutral-700">
                                    <button onclick="removeImage(2)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nueva Tercera Imagen</h4>
                                <div class="relative">
                                    <img id="preview3" src="" alt="Vista previa 3" class="w-full h-32 object-cover rounded-lg border border-neutral-200 dark:border-neutral-700">
                                    <button onclick="removeImage(3)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const imageInputs = {
        1: document.getElementById('imagen'),
        2: document.getElementById('imagen_2'),
        3: document.getElementById('imagen_3')
    };
    
    const previewImages = {
        1: document.getElementById('preview1'),
        2: document.getElementById('preview2'),
        3: document.getElementById('preview3')
    };
    
    const imagePreviews = document.getElementById('imagePreviews');
    
    // Detectar si es dispositivo móvil
    const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        console.log('Dispositivo móvil detectado - Optimizando experiencia de edición de artículos');
    }
    
    // Función para manejar cada input de imagen
    Object.keys(imageInputs).forEach(key => {
        const input = imageInputs[key];
        const preview = previewImages[key];
        
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tipo de archivo
                const validTypes = [
                    'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 
                    'image/webp', 'image/heic', 'image/heif'
                ];
                
                if (!validTypes.includes(file.type)) {
                    alert('Por favor selecciona un archivo de imagen válido (JPEG, PNG, GIF, WEBP, HEIC)');
                    this.value = '';
                    return;
                }
                
                // Validar tamaño (50MB máximo)
                const maxSize = 50 * 1024 * 1024; // 50MB en bytes
                if (file.size > maxSize) {
                    alert('La imagen no puede ser mayor a 50MB');
                    this.value = '';
                    return;
                }
                
                // Mostrar información del archivo
                console.log(`Nueva imagen ${key} seleccionada:`, {
                    nombre: file.name,
                    tipo: file.type,
                    tamaño: (file.size / 1024 / 1024).toFixed(2) + ' MB'
                });
                
                // Crear vista previa
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    showImagePreviews();
                };
                reader.readAsDataURL(file);
                
                // Mostrar mensaje de optimización para móviles
                if (isMobile) {
                    showMobileOptimizationMessage();
                }
            }
        });
    });
    
    // Función para mostrar las vistas previas
    function showImagePreviews() {
        const hasImages = Object.values(imageInputs).some(input => input.files.length > 0);
        if (hasImages) {
            imagePreviews.classList.remove('hidden');
        } else {
            imagePreviews.classList.add('hidden');
        }
    }
    
    // Función para remover imagen
    window.removeImage = function(imageNumber) {
        const input = imageInputs[imageNumber];
        const preview = previewImages[imageNumber];
        
        input.value = '';
        preview.src = '';
        
        showImagePreviews();
    };
    
    // Función para mostrar mensaje de optimización móvil
    function showMobileOptimizationMessage() {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'fixed top-4 right-4 bg-primary-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <i class="ri-information-line mr-2"></i>
                <span>Nueva imagen de artículo detectada desde móvil - Se optimizará automáticamente</span>
            </div>
        `;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
    
    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        // Validación adicional de tamaño para todas las imágenes
        Object.keys(imageInputs).forEach(key => {
            const file = imageInputs[key].files[0];
            if (file) {
                const maxSize = 50 * 1024 * 1024;
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert(`La nueva imagen ${key} es demasiado grande. Por favor selecciona una imagen más pequeña.`);
                    return false;
                }
            }
        });
    });
});

// Detectar orientación del dispositivo móvil
window.addEventListener('orientationchange', function() {
    console.log('Orientación cambiada:', window.orientation);
});

// Detectar cambios en el tamaño de la ventana (útil para tablets)
window.addEventListener('resize', function() {
    const width = window.innerWidth;
    const height = window.innerHeight;
    
    if (width < 768) {
        console.log('Dispositivo móvil detectado por tamaño de pantalla');
    }
});
</script>
@endsection
