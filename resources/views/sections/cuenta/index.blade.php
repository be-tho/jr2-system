@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Mi Cuenta</h1>
                    <p class="text-gray-600 dark:text-gray-400">Gestiona tu perfil y configuración personal</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Última actualización:</span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $user->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg flex items-center gap-3">
                <i class="ri-check-circle-line text-xl text-green-600 dark:text-green-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg flex items-center gap-3">
                <i class="ri-error-warning-line text-xl text-red-600 dark:text-red-400"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información del perfil -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-user-line"></i>
                            Información del Perfil
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <!-- Imagen de perfil -->
                            <div class="relative">
                                <img src="{{ asset('./src/assets/images/' . ($user->profile_image ?? 'usuario.jpg')) }}" 
                                     alt="Foto de perfil" 
                                     class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600 shadow-lg">
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center">
                                    <i class="ri-camera-line text-xs text-white"></i>
                                </div>
                            </div>
                            
                            <!-- Información básica -->
                            <div class="flex-1">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre completo</label>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Miembro desde</label>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Última actualización</label>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex flex-wrap gap-3">
                                    <a href="{{ route('cuenta.edit') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                        <i class="ri-edit-line"></i>
                                        Editar Perfil
                                    </a>
                                    <a href="{{ route('cuenta.change-password') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                                        <i class="ri-lock-line"></i>
                                        Cambiar Contraseña
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración de cuenta -->
                <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-settings-3-line"></i>
                            Configuración de Cuenta
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <i class="ri-notification-3-line text-xl text-blue-600 dark:text-blue-400"></i>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Notificaciones por email</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Recibir notificaciones importantes</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-3">
                                        {{ $user->email_notifications ? 'Activado' : 'Desactivado' }}
                                    </span>
                                    <div class="w-12 h-6 bg-gray-200 dark:bg-gray-600 rounded-full relative">
                                        <div class="w-5 h-5 bg-white rounded-full shadow transform transition-transform duration-200 {{ $user->email_notifications ? 'translate-x-6' : 'translate-x-0' }}"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <i class="ri-moon-line text-xl text-purple-600 dark:text-purple-400"></i>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Modo oscuro</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Interfaz en tema oscuro</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-3">
                                        {{ $user->dark_mode ? 'Activado' : 'Desactivado' }}
                                    </span>
                                    <div class="w-12 h-6 bg-gray-200 dark:bg-gray-600 rounded-full relative">
                                        <div class="w-5 h-5 bg-white rounded-full shadow transform transition-transform duration-200 {{ $user->dark_mode ? 'translate-x-6' : 'translate-x-0' }}"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <i class="ri-translate-2 text-xl text-green-600 dark:text-green-400"></i>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Idioma</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Idioma de la interfaz</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $user->language === 'es' ? 'Español' : 'English' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('cuenta.settings') }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="ri-settings-line"></i>
                                Gestionar Configuración
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="space-y-6">
                <!-- Estadísticas rápidas -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-4 py-3">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="ri-bar-chart-line"></i>
                            Actividad Reciente
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Sesiones activas</span>
                                <span class="font-medium text-gray-900 dark:text-white">1</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Último login</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ now()->format('d/m H:i') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Estado</span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-xs rounded-full">
                                    <i class="ri-checkbox-circle-line"></i>
                                    Activo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 px-4 py-3">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="ri-flashlight-line"></i>
                            Acciones Rápidas
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <a href="{{ route('cuenta.edit') }}" 
                               class="flex items-center gap-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                <i class="ri-user-settings-line text-lg text-blue-600 dark:text-blue-400"></i>
                                <span class="text-sm font-medium">Editar perfil</span>
                            </a>
                            <a href="{{ route('cuenta.change-password') }}" 
                               class="flex items-center gap-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                <i class="ri-lock-password-line text-lg text-green-600 dark:text-green-400"></i>
                                <span class="text-sm font-medium">Cambiar contraseña</span>
                            </a>
                            <a href="{{ route('cuenta.settings') }}" 
                               class="flex items-center gap-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                <i class="ri-settings-4-line text-lg text-purple-600 dark:text-purple-400"></i>
                                <span class="text-sm font-medium">Configuración</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Información del sistema -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-4 py-3">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="ri-information-line"></i>
                            Información del Sistema
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Versión</span>
                                <span class="font-medium text-gray-900 dark:text-white">v2.0.0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Laravel</span>
                                <span class="font-medium text-gray-900 dark:text-white">10.x</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">PHP</span>
                                <span class="font-medium text-gray-900 dark:text-white">8.1+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
