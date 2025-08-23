@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-neutral-subtle dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">Mi Cuenta</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Información de tu perfil personal</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-neutral-500 dark:text-neutral-400">Última actualización:</span>
                    <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">{{ $user->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg flex items-center gap-3">
                <i class="ri-check-circle-line text-xl text-green-600 dark:text-green-400"></i>
                <div>
                    <span class="font-medium">{{ session('success') }}</span>
                    @if(str_contains(session('success'), 'imagen'))
                        <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                            La nueva imagen se mostrará inmediatamente. Si no ves los cambios, recarga la página.
                        </p>
                    @endif
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg flex items-center gap-3">
                <i class="ri-error-warning-line text-xl text-red-600 dark:text-red-400"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <!-- Información del perfil -->
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                        <i class="ri-user-line"></i>
                        Información del Perfil
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start gap-6">
                        <!-- Imagen de perfil -->
                        <div class="relative">
                            <img src="{{ \App\Helpers\ImageHelper::getProfileImageUrl($user->profile_image) }}" 
                                 alt="{{ \App\Helpers\ImageHelper::getProfileImageAlt($user->profile_image, $user->name) }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-neutral-200 dark:border-neutral-600 shadow-lg {{ \App\Helpers\ImageHelper::getProfileImageClass($user->profile_image) }}">
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-accent-500 rounded-full border-2 border-white dark:border-neutral-800 flex items-center justify-center">
                                <i class="ri-camera-line text-sm text-white"></i>
                            </div>
                        </div>
                        
                        <!-- Información básica -->
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Nombre completo</label>
                                    <p class="text-neutral-900 dark:text-white font-medium text-lg">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Correo electrónico</label>
                                    <p class="text-neutral-900 dark:text-white font-medium text-lg">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Miembro desde</label>
                                    <p class="text-neutral-900 dark:text-white font-medium text-lg">{{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Última actualización</label>
                                    <p class="text-neutral-900 dark:text-white font-medium text-lg">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="{{ route('cuenta.edit') }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <i class="ri-edit-line"></i>
                                    Editar Perfil
                                </a>
                                <a href="{{ route('cuenta.change-password') }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-600 hover:bg-neutral-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <i class="ri-lock-line"></i>
                                    Cambiar Contraseña
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
