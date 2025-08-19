@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Cambiar Contraseña</h1>
                    <p class="text-gray-600 dark:text-gray-400">Actualiza tu contraseña para mantener tu cuenta segura</p>
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

        <div class="max-w-2xl mx-auto">
            <form action="{{ route('cuenta.update-password') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Información de seguridad -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                    <div class="flex items-start gap-3">
                        <i class="ri-shield-check-line text-2xl text-blue-600 dark:text-blue-400 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Recomendaciones de Seguridad</h3>
                            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <li>• Usa al menos 8 caracteres</li>
                                <li>• Incluye mayúsculas, minúsculas y números</li>
                                <li>• Agrega símbolos especiales si es posible</li>
                                <li>• Evita usar información personal</li>
                                <li>• No reutilices contraseñas de otros sitios</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Formulario de cambio de contraseña -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-lock-password-line"></i>
                            Cambio de Contraseña
                        </h2>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Contraseña actual -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Contraseña actual <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                       placeholder="Ingresa tu contraseña actual"
                                       required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                                        onclick="togglePassword('current_password')">
                                    <i class="ri-eye-line" id="current_password_icon"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Nueva contraseña -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nueva contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                       placeholder="Ingresa tu nueva contraseña"
                                       required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                                        onclick="togglePassword('password')">
                                    <i class="ri-eye-line" id="password_icon"></i>
                                </button>
                            </div>
                            
                            <!-- Indicador de fortaleza de contraseña -->
                            <div class="mt-2">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Fortaleza:</span>
                                    <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                        <div id="password-strength" class="h-full transition-all duration-300 rounded-full"></div>
                                    </div>
                                    <span id="strength-text" class="text-xs font-medium"></span>
                                </div>
                                <div id="strength-requirements" class="text-xs text-gray-600 dark:text-gray-400 space-y-1"></div>
                            </div>
                        </div>
                        
                        <!-- Confirmar nueva contraseña -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar nueva contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                       placeholder="Confirma tu nueva contraseña"
                                       required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                                        onclick="togglePassword('password_confirmation')">
                                    <i class="ri-eye-line" id="password_confirmation_icon"></i>
                                </button>
                            </div>
                            
                            <!-- Indicador de coincidencia -->
                            <div class="mt-2">
                                <div id="password-match" class="text-xs flex items-center gap-1">
                                    <i class="ri-checkbox-circle-line text-green-500"></i>
                                    <span class="text-green-600 dark:text-green-400">Las contraseñas coinciden</span>
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
                            class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="ri-lock-unlock-line"></i>
                        Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const strengthBar = document.getElementById('password-strength');
    const strengthText = document.getElementById('strength-text');
    const requirements = document.getElementById('strength-requirements');
    const matchIndicator = document.getElementById('password-match');
    
    // Función para mostrar/ocultar contraseña
    window.togglePassword = function(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ri-eye-line');
            icon.classList.add('ri-eye-off-line');
        } else {
            input.type = 'password';
            icon.classList.remove('ri-eye-off-line');
            icon.classList.add('ri-eye-line');
        }
    };
    
    // Función para evaluar fortaleza de contraseña
    function checkPasswordStrength(password) {
        let score = 0;
        let feedback = [];
        
        if (password.length >= 8) {
            score += 1;
        } else {
            feedback.push('Al menos 8 caracteres');
        }
        
        if (/[a-z]/.test(password)) {
            score += 1;
        } else {
            feedback.push('Al menos una minúscula');
        }
        
        if (/[A-Z]/.test(password)) {
            score += 1;
        } else {
            feedback.push('Al menos una mayúscula');
        }
        
        if (/[0-9]/.test(password)) {
            score += 1;
        } else {
            feedback.push('Al menos un número');
        }
        
        if (/[^A-Za-z0-9]/.test(password)) {
            score += 1;
        } else {
            feedback.push('Al menos un símbolo especial');
        }
        
        return { score, feedback };
    }
    
    // Función para actualizar indicador de fortaleza
    function updateStrengthIndicator(password) {
        const { score, feedback } = checkPasswordStrength(password);
        
        let color, text;
        if (score <= 2) {
            color = 'bg-red-500';
            text = 'Débil';
        } else if (score <= 3) {
            color = 'bg-yellow-500';
            text = 'Media';
        } else if (score <= 4) {
            color = 'bg-blue-500';
            text = 'Buena';
        } else {
            color = 'bg-green-500';
            text = 'Excelente';
        }
        
        strengthBar.className = `h-full transition-all duration-300 rounded-full ${color}`;
        strengthBar.style.width = `${(score / 5) * 100}%`;
        strengthText.textContent = text;
        
        // Actualizar requisitos
        requirements.innerHTML = feedback.map(req => `<div class="flex items-center gap-1"><i class="ri-close-circle-line text-red-500"></i> ${req}</div>`).join('');
    }
    
    // Función para verificar coincidencia de contraseñas
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        if (confirm && password === confirm) {
            matchIndicator.innerHTML = '<i class="ri-checkbox-circle-line text-green-500"></i><span class="text-green-600 dark:text-green-400">Las contraseñas coinciden</span>';
        } else if (confirm) {
            matchIndicator.innerHTML = '<i class="ri-close-circle-line text-red-500"></i><span class="text-red-600 dark:text-red-400">Las contraseñas no coinciden</span>';
        } else {
            matchIndicator.innerHTML = '<i class="ri-checkbox-circle-line text-green-500"></i><span class="text-green-600 dark:text-green-400">Las contraseñas coinciden</span>';
        }
    }
    
    // Event listeners
    passwordInput.addEventListener('input', function() {
        updateStrengthIndicator(this.value);
        if (confirmInput.value) {
            checkPasswordMatch();
        }
    });
    
    confirmInput.addEventListener('input', checkPasswordMatch);
    
    // Inicializar
    updateStrengthIndicator('');
});
</script>
@endsection
