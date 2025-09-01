@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-neutral-subtle dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">Editar Perfil</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Actualiza tu información personal y foto de perfil</p>
                </div>
                <a href="{{ route('cuenta.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="ri-arrow-left-line"></i>
                    Volver a Mi Cuenta
                </a>
            </div>
        </div>

        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                <div class="flex items-center gap-3 mb-2">
                    <i class="ri-error-warning-line text-xl text-red-600 dark:text-red-400"></i>
                    <span class="font-medium">Por favor corrige los siguientes errores:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('cuenta.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Información básica -->
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-user-line"></i>
                            Información Básica
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    Nombre completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white transition-colors duration-200"
                                       placeholder="Ingresa tu nombre completo"
                                       required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    Correo electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white transition-colors duration-200"
                                       placeholder="tu@email.com"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto de perfil -->
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-accent-500 to-accent-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-image-line"></i>
                            Foto de Perfil
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <!-- Imagen actual -->
                            <div class="relative">
                                <img src="{{ \App\Helpers\ImageHelper::getProfileImageUrl($user->profile_image) }}" 
                                     alt="{{ \App\Helpers\ImageHelper::getProfileImageAlt($user->profile_image, $user->name) }}" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-neutral-200 dark:border-neutral-600 shadow-lg {{ \App\Helpers\ImageHelper::getProfileImageClass($user->profile_image) }}">
                                <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-primary-500 rounded-full border-2 border-white dark:border-neutral-800 flex items-center justify-center">
                                    <i class="ri-camera-line text-sm text-white"></i>
                                </div>
                            </div>
                            
                            <!-- Controles de imagen -->
                            <div class="flex-1">
                                <div class="mb-4">
                                    <label for="profile_image" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        Seleccionar nueva imagen
                                    </label>
                                    <input type="file" 
                                           id="profile_image" 
                                           name="profile_image" 
                                           accept="image/*"
                                           class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-white transition-colors duration-200">
                                </div>
                                
                                <div class="text-sm text-neutral-600 dark:text-neutral-400 space-y-2">
                                    <p><i class="ri-information-line text-primary-500 mr-1"></i> Formatos soportados: JPEG, PNG, JPG, GIF, WEBP, HEIC, HEIF</p>
                                    <p><i class="ri-information-line text-primary-500 mr-1"></i> Tamaño máximo: 2MB</p>
                                    <p><i class="ri-information-line text-primary-500 mr-1"></i> Resolución recomendada: 400x400 píxeles</p>
                                </div>
                                
                                <!-- Vista previa de la imagen -->
                                <div id="image-preview" class="mt-4 hidden">
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        Vista previa:
                                    </label>
                                    <img id="preview-img" src="" alt="Vista previa" class="w-24 h-24 rounded-lg object-cover border border-neutral-300 dark:border-neutral-600">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('cuenta.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-600 hover:bg-neutral-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="ri-close-line"></i>
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="ri-save-line"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('profile_image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    // Configuración de validación (debe coincidir con el backend)
    const config = {
        maxSize: 2 * 1024 * 1024, // 2MB en bytes
        validTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/heic', 'image/heif'],
        minDimensions: { width: 50, height: 50 },
        maxDimensions: { width: 8000, height: 8000 }
    };
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validar tipo de archivo
            if (!config.validTypes.includes(file.type)) {
                showError('Por favor selecciona un archivo de imagen válido (JPEG, PNG, JPG, GIF, WEBP, HEIC)');
                this.value = '';
                imagePreview.classList.add('hidden');
                return;
            }
            
            // Validar tamaño
            if (file.size > config.maxSize) {
                showError('La imagen no puede ser mayor a 2MB');
                this.value = '';
                imagePreview.classList.add('hidden');
                return;
            }
            
            // Validar dimensiones si es posible
            validateImageDimensions(file);
            
            // Mostrar vista previa
            showImagePreview(file);
            
            // Mostrar información del archivo
            console.log('Archivo seleccionado:', {
                nombre: file.name,
                tipo: file.type,
                tamaño: (file.size / 1024 / 1024).toFixed(2) + ' MB'
            });
        } else {
            imagePreview.classList.add('hidden');
        }
    });
    
    // Función para validar dimensiones de la imagen
    function validateImageDimensions(file) {
        const img = new Image();
        const url = URL.createObjectURL(file);
        
        img.onload = function() {
            URL.revokeObjectURL(url);
            
            if (img.width < config.minDimensions.width || img.height < config.minDimensions.height) {
                showError(`La imagen debe tener al menos ${config.minDimensions.width}x${config.minDimensions.height} píxeles`);
                imageInput.value = '';
                imagePreview.classList.add('hidden');
                return;
            }
            
            if (img.width > config.maxDimensions.width || img.height > config.maxDimensions.height) {
                showError(`La imagen no debe superar ${config.maxDimensions.width}x${config.maxDimensions.height} píxeles`);
                imageInput.value = '';
                imagePreview.classList.add('hidden');
                return;
            }
        };
        
        img.onerror = function() {
            URL.revokeObjectURL(url);
            console.warn('No se pudieron validar las dimensiones de la imagen');
        };
        
        img.src = url;
    }
    
    // Función para mostrar vista previa de la imagen
    function showImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
    
    // Función para mostrar errores
    function showError(message) {
        // Crear o actualizar mensaje de error
        let errorDiv = document.getElementById('image-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = 'image-error';
            errorDiv.className = 'mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
            imageInput.parentNode.appendChild(errorDiv);
        }
        
        errorDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293a1 1 0 101.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293a1 1 0 00-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-red-800 dark:text-red-200">${message}</p>
            </div>
        `;
        
        // Ocultar mensaje de error después de 5 segundos
        setTimeout(() => {
            if (errorDiv) {
                errorDiv.remove();
            }
        }, 5000);
    }
    
    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const imageFile = imageInput.files[0];
        
        if (imageFile) {
            // Validaciones adicionales antes de enviar
            if (!config.validTypes.includes(imageFile.type)) {
                e.preventDefault();
                showError('Por favor selecciona un archivo de imagen válido');
                return false;
            }
            
            if (imageFile.size > config.maxSize) {
                e.preventDefault();
                showError('La imagen no puede ser mayor a 2MB');
                return false;
            }
        }
        
        // Mostrar indicador de carga
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin mr-2"></i>Guardando...';
        }
    });
    
    // Limpiar mensaje de error cuando se cambia la imagen
    imageInput.addEventListener('input', function() {
        const errorDiv = document.getElementById('image-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    });
});
</script>
@endsection
