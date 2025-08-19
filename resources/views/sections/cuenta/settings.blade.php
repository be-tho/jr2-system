@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Configuración de Cuenta</h1>
                    <p class="text-gray-600 dark:text-gray-400">Personaliza tu experiencia en el sistema</p>
                </div>
                <a href="{{ route('cuenta.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="ri-arrow-left-line"></i>
                    Volver a Mi Cuenta
                </a>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg flex items-center gap-3">
                <i class="ri-check-circle-line text-xl text-green-600 dark:text-green-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('cuenta.update-settings') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Configuración de notificaciones -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-notification-3-line"></i>
                            Configuración de Notificaciones
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <i class="ri-mail-line text-xl text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Notificaciones por email</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Recibir notificaciones importantes por correo electrónico</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="email_notifications" 
                                           value="1" 
                                           class="sr-only peer"
                                           {{ $user->email_notifications ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <i class="ri-notification-4-line text-xl text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Notificaciones del sistema</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Alertas y mensajes del sistema en tiempo real</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer"
                                           checked
                                           disabled>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración de interfaz -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-palette-line"></i>
                            Configuración de Interfaz
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <i class="ri-moon-line text-xl text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Modo oscuro</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Cambiar a tema oscuro para mejor experiencia visual</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="dark_mode" 
                                           value="1" 
                                           class="sr-only peer"
                                           {{ $user->dark_mode ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                        <i class="ri-translate-2 text-xl text-orange-600 dark:text-orange-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Idioma</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Selecciona el idioma de la interfaz</p>
                                    </div>
                                </div>
                                <select name="language" 
                                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                    <option value="es" {{ $user->language === 'es' ? 'selected' : '' }}>Español</option>
                                    <option value="en" {{ $user->language === 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración de privacidad -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-shield-user-line"></i>
                            Configuración de Privacidad
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                        <i class="ri-eye-off-line text-xl text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Perfil público</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Permitir que otros usuarios vean tu perfil</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer"
                                           checked
                                           disabled>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                                        <i class="ri-history-line text-xl text-yellow-600 dark:text-yellow-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Historial de actividad</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Guardar historial de acciones en el sistema</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer"
                                           checked
                                           disabled>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-yellow-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                    <div class="flex items-start gap-3">
                        <i class="ri-information-line text-2xl text-blue-600 dark:text-blue-400 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Información Importante</h3>
                            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <li>• Los cambios se aplican inmediatamente</li>
                                <li>• Algunas configuraciones requieren recargar la página</li>
                                <li>• Las preferencias se guardan en tu dispositivo</li>
                                <li>• Puedes cambiar estas configuraciones en cualquier momento</li>
                            </ul>
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
                            class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="ri-save-line"></i>
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Efectos visuales para los switches
    const switches = document.querySelectorAll('input[type="checkbox"]');
    
    switches.forEach(switchInput => {
        switchInput.addEventListener('change', function() {
            const switchContainer = this.closest('.flex.items-center.justify-between');
            if (this.checked) {
                switchContainer.classList.add('ring-2', 'ring-blue-200', 'dark:ring-blue-800');
                setTimeout(() => {
                    switchContainer.classList.remove('ring-2', 'ring-blue-200', 'dark:ring-blue-800');
                }, 300);
            }
        });
    });
    
    // Efecto para el select
    const languageSelect = document.querySelector('select[name="language"]');
    if (languageSelect) {
        languageSelect.addEventListener('change', function() {
            const selectContainer = this.closest('.flex.items-center.justify-between');
            selectContainer.classList.add('ring-2', 'ring-purple-200', 'dark:ring-purple-800');
            setTimeout(() => {
                selectContainer.classList.remove('ring-2', 'ring-purple-200', 'dark:ring-purple-800');
            }, 300);
        });
    }
});
</script>
@endsection
