@extends('layout.app')
@section('title', 'Crear Artículo')
@section('content')
<x-container-wrapp>
    <div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Nuevo Artículo</h1>
                    <p class="text-primary-100 text-lg">Agrega un nuevo artículo al inventario</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="ri-shirt-line text-4xl text-white"></i>
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
                Completa todos los campos requeridos para crear el artículo
            </p>
        </div>

        <form action="{{ route('articulos.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

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
                            value="{{ old('nombre') }}"
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
                            value="{{ old('codigo') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('codigo') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Código único"
                            required
                        >
                    </div>
                    @error('codigo')
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
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                            <i class="ri-calendar-event-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <select 
                            id="temporada_id" 
                            name="temporada_id" 
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('temporada_id') border-red-500 dark:border-red-400 @enderror"
                            required
                        >
                            <option value="">Selecciona una temporada</option>
                            @foreach($temporadas as $temporada)
                                <option value="{{ $temporada->id }}" {{ old('temporada_id') == $temporada->id ? 'selected' : '' }}>
                                    {{ $temporada->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('temporada_id')
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
                            value="{{ old('precio') }}"
                            step="0.01"
                            min="0"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('precio') border-red-500 dark:border-red-400 @enderror"
                            placeholder="0.00"
                            required
                        >
                    </div>
                    @error('precio')
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
                            <i class="ri-store-2-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="number" 
                            id="stock" 
                            name="stock" 
                            value="{{ old('stock') }}"
                            min="0"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('stock') border-red-500 dark:border-red-400 @enderror"
                            placeholder="0"
                            required
                        >
                    </div>
                    @error('stock')
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
                    >{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="md:col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Imagen del Artículo
                    </label>
                    <div class="space-y-4">
                        {{-- Input de archivo --}}
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
                        <div class="space-y-2">
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                <strong>Formatos soportados:</strong> JPG, PNG, GIF, WEBP, HEIC (iPhone)
                            </p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                <strong>Tamaño máximo:</strong> 50MB (se optimizará automáticamente)
                            </p>
                            <p class="text-xs text-primary-600 dark:text-primary-400">
                                <i class="ri-information-line"></i> Las imágenes se optimizarán automáticamente para mejor rendimiento
                            </p>
                        </div>
                        @error('imagen')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center justify-between pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('articulos.index') }}" class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <i class="ri-arrow-left-line mr-2"></i>
                        Cancelar
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <i class="ri-save-line mr-2"></i>
                        Crear Artículo
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-container-wrapp>

{{-- Modal de vista previa de imagen --}}
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-neutral-800 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Vista Previa de Imagen</h3>
                <button onclick="closeImagePreview()" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>
            <div class="p-4">
                <div class="relative">
                    <img id="previewImage" src="" alt="Vista previa" class="w-full h-auto max-h-[60vh] object-contain rounded-lg">
                    <div id="imageInfo" class="mt-4 text-sm text-neutral-600 dark:text-neutral-400 space-y-1">
                        <p><strong>Nombre:</strong> <span id="fileName"></span></p>
                        <p><strong>Tamaño:</strong> <span id="fileSize"></span></p>
                        <p><strong>Dimensiones:</strong> <span id="fileDimensions"></span></p>
                        <p><strong>Tipo:</strong> <span id="fileType"></span></p>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end p-4 border-t border-neutral-200 dark:border-neutral-700">
                <button onclick="closeImagePreview()" class="px-4 py-2 bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-600 transition-colors duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imagen');
    const previewModal = document.getElementById('imagePreviewModal');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileDimensions = document.getElementById('fileDimensions');
    const fileType = document.getElementById('fileType');
    
    // Detectar si es dispositivo móvil
    const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        console.log('Dispositivo móvil detectado - Optimizando experiencia de subida de artículos');
    }
    
    imageInput.addEventListener('change', function(e) {
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
            console.log('Archivo seleccionado:', {
                nombre: file.name,
                tipo: file.type,
                tamaño: (file.size / 1024 / 1024).toFixed(2) + ' MB'
            });
            
            // Crear vista previa
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    // Actualizar información en el modal
                    fileName.textContent = file.name;
                    fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                    fileDimensions.textContent = this.width + ' x ' + this.height + ' píxeles';
                    fileType.textContent = file.type;
                    
                    // Mostrar imagen en el modal
                    previewImage.src = e.target.result;
                    previewModal.classList.remove('hidden');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            // Mostrar mensaje de optimización para móviles
            if (isMobile) {
                showMobileOptimizationMessage();
            }
        }
    });
    
    // Función para mostrar mensaje de optimización móvil
    function showMobileOptimizationMessage() {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'fixed top-4 right-4 bg-primary-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <i class="ri-information-line mr-2"></i>
                <span>Imagen de artículo detectada desde móvil - Se optimizará automáticamente</span>
            </div>
        `;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
    
    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const file = imageInput.files[0];
        
        if (file) {
            // Validación adicional antes de enviar
            const maxSize = 50 * 1024 * 1024;
            if (file.size > maxSize) {
                e.preventDefault();
                alert('La imagen es demasiado grande. Por favor selecciona una imagen más pequeña.');
                return false;
            }
        }
    });
});

// Funciones para el modal
function closeImagePreview() {
    document.getElementById('imagePreviewModal').classList.add('hidden');
}

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
