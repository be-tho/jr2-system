@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-neutral-subtle dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">Cambiar Contraseña</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Actualiza tu contraseña para mantener tu cuenta segura</p>
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

        <!-- Mensajes de éxito -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg flex items-center gap-3">
                <i class="ri-check-circle-line text-xl text-green-600 dark:text-green-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-2xl mx-auto">
            <form action="{{ route('cuenta.update-password') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Información de seguridad -->
                <div class="bg-gradient-primary-subtle-border dark:bg-gradient-primary-subtle rounded-xl p-6">
                    <div class="flex items-start gap-3">
                        <i class="ri-shield-check-line text-2xl text-primary-600 dark:text-primary-400 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-primary-900 dark:text-primary-100 mb-2">Recomendaciones de Seguridad</h3>
                            <ul class="text-sm text-primary-800 dark:text-primary-200 space-y-1">
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
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-accent-500 to-accent-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="ri-lock-password-line"></i>
                            Cambio de Contraseña
                        </h2>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Contraseña actual -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Contraseña actual <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       class="w-full px-4 py-3 pr-12 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-transparent dark:bg-neutral-700 dark:text-white transition-colors duration-200 @error('current_password') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="Ingresa tu contraseña actual"
                                       value="{{ old('current_password') }}"
                                       required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300"
                                        onclick="togglePassword('current_password')">
                                    <i class="ri-eye-line" id="current_password_icon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="current_password_error" class="mt-1 text-sm text-red-600 dark:text-red-400" style="display: none;"></div>
                        </div>
                        
                        <!-- Nueva contraseña -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Nueva contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-4 py-3 pr-12 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-transparent dark:bg-neutral-700 dark:text-white transition-colors duration-200 @error('password') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="Ingresa tu nueva contraseña"
                                       value="{{ old('password') }}"
                                       required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300"
                                        onclick="togglePassword('password')">
                                    <i class="ri-eye-line" id="password_icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="password_error" class="mt-1 text-sm text-red-600 dark:text-red-400" style="display: none;"></div>
                            
                            <!-- Indicador de fortaleza de contraseña -->
                            <div class="mt-2">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs text-neutral-600 dark:text-neutral-400">Fortaleza:</span>
                                    <div class="flex-1 h-2 bg-neutral-200 dark:bg-neutral-600 rounded-full overflow-hidden">
                                        <div id="password-strength" class="h-full transition-all duration-300 rounded-full"></div>
                                    </div>
                                    <span id="strength-text" class="text-xs font-medium"></span>
                                </div>
                                <div id="strength-requirements" class="text-xs text-neutral-600 dark:text-neutral-400 space-y-1"></div>
                            </div>
                        </div>
                        
                        <!-- Confirmar nueva contraseña -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Confirmar nueva contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-3 pr-12 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-transparent dark:bg-neutral-700 dark:text-white transition-colors duration-200 @error('password_confirmation') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="Confirma tu nueva contraseña"
                                       value="{{ old('password_confirmation') }}"
                                       required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300"
                                        onclick="togglePassword('password_confirmation')">
                                    <i class="ri-eye-line" id="password_confirmation_icon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="password_confirmation_error" class="mt-1 text-sm text-red-600 dark:text-red-400" style="display: none;"></div>
                            
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
                       class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-600 hover:bg-neutral-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="ri-close-line"></i>
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white font-medium rounded-lg transition-colors duration-200">
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
        
        let color, text, bgColor;
        if (score <= 2) {
            color = 'bg-red-500';
            text = 'Débil';
            bgColor = 'bg-red-100 dark:bg-red-900/20';
        } else if (score <= 3) {
            color = 'bg-yellow-500';
            text = 'Media';
            bgColor = 'bg-yellow-100 dark:bg-yellow-900/20';
        } else if (score <= 4) {
            color = 'bg-blue-500';
            text = 'Buena';
            bgColor = 'bg-blue-100 dark:bg-blue-900/20';
        } else {
            color = 'bg-green-500';
            text = 'Excelente';
            bgColor = 'bg-green-100 dark:bg-green-900/20';
        }
        
        strengthBar.className = `h-full transition-all duration-300 rounded-full ${color}`;
        strengthBar.style.width = `${(score / 5) * 100}%`;
        strengthText.textContent = text;
        strengthText.className = `text-xs font-medium ${score <= 2 ? 'text-red-600 dark:text-red-400' : score <= 3 ? 'text-yellow-600 dark:text-yellow-400' : score <= 4 ? 'text-blue-600 dark:text-blue-400' : 'text-green-600 dark:text-green-400'}`;
        
        // Actualizar requisitos con mejor visualización
        requirements.innerHTML = feedback.map(req => {
            const isMet = !feedback.includes(req);
            return `<div class="flex items-center gap-1 ${isMet ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                <i class="${isMet ? 'ri-check-circle-line' : 'ri-close-circle-line'}"></i> 
                ${req}
            </div>`;
        }).join('');
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
    
    // Validación en tiempo real para contraseña actual
    document.getElementById('current_password').addEventListener('input', function() {
        const currentPasswordField = this;
        const currentPasswordError = document.getElementById('current_password_error');
        
        if (currentPasswordField.value.length > 0) {
            currentPasswordField.classList.remove('border-red-500', 'focus:ring-red-500');
            currentPasswordField.classList.add('border-neutral-300', 'dark:border-neutral-600', 'focus:ring-accent-500');
            if (currentPasswordError) {
                currentPasswordError.style.display = 'none';
            }
        }
    });
    
    // Validación del formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        let hasErrors = false;
        
        // Limpiar errores previos
        ['current_password', 'password', 'password_confirmation'].forEach(clearFieldError);
        
        // Validar contraseña actual
        if (!currentPassword.trim()) {
            showFieldError('current_password', 'La contraseña actual es obligatoria');
            hasErrors = true;
        }
        
        // Validar nueva contraseña
        if (!newPassword.trim()) {
            showFieldError('password', 'La nueva contraseña es obligatoria');
            hasErrors = true;
        } else if (newPassword.length < 8) {
            showFieldError('password', 'La nueva contraseña debe tener al menos 8 caracteres');
            hasErrors = true;
        }
        
        // Validar confirmación
        if (!confirmPassword.trim()) {
            showFieldError('password_confirmation', 'Debes confirmar la nueva contraseña');
            hasErrors = true;
        } else if (newPassword !== confirmPassword) {
            showFieldError('password_confirmation', 'Las contraseñas no coinciden');
            hasErrors = true;
        }
        
        if (hasErrors) {
            e.preventDefault();
            // Scroll al primer error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }
        
        // Confirmar antes de enviar
        if (!confirm('¿Estás seguro de que quieres cambiar tu contraseña? Esta acción no se puede deshacer.')) {
            e.preventDefault();
            return false;
        }
        
        // Si no hay errores, mostrar indicador de carga
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin mr-2"></i>Actualizando...';
        }
    });
    
    // Función para mostrar errores de campo
    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + '_error') || createErrorElement(fieldId);
        
        field.classList.remove('border-neutral-300', 'dark:border-neutral-600', 'focus:ring-accent-500');
        field.classList.add('border-red-500', 'focus:ring-red-500');
        
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }
    
    // Función para crear elemento de error si no existe
    function createErrorElement(fieldId) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.id = fieldId + '_error';
        errorDiv.className = 'mt-1 text-sm text-red-600 dark:text-red-400';
        errorDiv.style.display = 'none';
        
        field.parentNode.appendChild(errorDiv);
        return errorDiv;
    }
    
    // Función para limpiar errores de campo
    function clearFieldError(fieldId) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + '_error');
        
        if (field && errorDiv) {
            field.classList.remove('border-red-500', 'focus:ring-red-500');
            field.classList.add('border-neutral-300', 'dark:border-neutral-600', 'focus:ring-accent-500');
            errorDiv.style.display = 'none';
        }
    }
    
    // Limpiar errores cuando el usuario comience a escribir
    ['current_password', 'password', 'password_confirmation'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                clearFieldError(fieldId);
            });
        }
    });
    
    // Inicializar
    updateStrengthIndicator('');
});
</script>
@endsection
