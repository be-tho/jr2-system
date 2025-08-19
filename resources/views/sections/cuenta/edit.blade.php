@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Editar Perfil</h1>
                    <p class="text-gray-600 dark:text-gray-400">Actualiza tu información personal y foto de perfil</p>
                </div>
                <a href="{{ route('cuenta.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
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
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-user-line"></i>
                            Información Básica
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                       placeholder="Ingresa tu nombre completo"
                                       required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Correo electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                       placeholder="tu@email.com"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto de perfil -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-image-line"></i>
                            Foto de Perfil
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <!-- Imagen actual -->
                            <div class="relative">
                                <img src="{{ asset('./src/assets/images/' . ($user->profile_image ?? 'usuario.jpg')) }}" 
                                     alt="Foto de perfil actual" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600 shadow-lg">
                                <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-blue-500 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center">
                                    <i class="ri-camera-line text-sm text-white"></i>
                                </div>
                            </div>
                            
                            <!-- Controles de imagen -->
                            <div class="flex-1">
                                <div class="mb-4">
                                    <label for="profile_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Seleccionar nueva imagen
                                    </label>
                                    <input type="file" 
                                           id="profile_image" 
                                           name="profile_image" 
                                           accept="image/*"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                </div>
                                
                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                                    <p><i class="ri-information-line text-blue-500 mr-1"></i> Formatos soportados: JPEG, PNG, JPG, GIF, WEBP</p>
                                    <p><i class="ri-information-line text-blue-500 mr-1"></i> Tamaño máximo: 2MB</p>
                                    <p><i class="ri-information-line text-blue-500 mr-1"></i> Resolución recomendada: 400x400 píxeles</p>
                                </div>
                                
                                <!-- Vista previa de la imagen -->
                                <div id="image-preview" class="mt-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Vista previa:
                                    </label>
                                    <img id="preview-img" src="" alt="Vista previa" class="w-24 h-24 rounded-lg object-cover border border-gray-300 dark:border-gray-600">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('cuenta.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="ri-close-line"></i>
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
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
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('hidden');
        }
    });
});
</script>
@endsection
