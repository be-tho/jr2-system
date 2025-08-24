<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JR2 System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Theme Script -->
    <script>
        // Verificar tema guardado o usar preferencia del sistema
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="h-full bg-neutral-50 dark:bg-neutral-900 transition-colors duration-300">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar/Sidebar -->
        @include('components.navbar')

        <!-- Main Content -->
        <main class="flex-1 ml-0 lg:ml-64 mt-16 lg:mt-0 transition-all duration-300">
            <div class="min-h-full p-4 lg:p-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-neutral-800 border-t border-neutral-200 dark:border-neutral-700 mt-auto transition-colors duration-300 ml-0 lg:ml-64">
            <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                            <span class="text-sm font-bold text-white">JR</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">JR2 System</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Management Platform</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-neutral-500 dark:text-neutral-400">Tema:</span>
                            <button id="theme-toggle" 
                                    class="relative inline-flex h-6 w-11 items-center rounded-full bg-neutral-200 dark:bg-neutral-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                                <span class="sr-only">Cambiar tema</span>
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white dark:bg-neutral-900 transition-transform duration-300 translate-x-1 dark:translate-x-6"></span>
                                <i class="ri-sun-line absolute left-1 text-xs text-accent-500 dark:opacity-0 transition-opacity duration-300"></i>
                                <i class="ri-moon-line absolute right-1 text-xs text-primary-500 opacity-0 dark:opacity-100 transition-opacity duration-300"></i>
                            </button>
                        </div>
                        
                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                            © 2024 JR2 System. Todos los derechos reservados.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center space-x-3">
                <div class="spinner spinner-md"></div>
                <span class="text-neutral-900 dark:text-white font-medium">Cargando...</span>
            </div>
        </div>
    </div>

    <!-- Global JavaScript -->
<script>
        // Sistema de temas
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        
        themeToggle.addEventListener('click', function() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });

        // Sistema de notificaciones mejorado
        class ToastManager {
            constructor() {
                this.container = document.getElementById('toast-container');
                this.toasts = [];
            }

            show(message, type = 'info', duration = 5000) {
                const toast = this.createToast(message, type);
                this.container.appendChild(toast);
                this.toasts.push(toast);

                // Animación de entrada
                setTimeout(() => {
                    toast.classList.remove('opacity-0', 'translate-x-full');
                }, 100);

                // Auto-remover
                setTimeout(() => {
                    this.hide(toast);
                }, duration);

                return toast;
            }

            createToast(message, type) {
                const toast = document.createElement('div');
                const icons = {
                    success: 'ri-checkbox-circle-line',
                    error: 'ri-error-warning-line',
                    warning: 'ri-alert-line',
                    info: 'ri-information-line'
                };
                
                const colors = {
                    success: 'bg-success-500 dark:bg-success-600',
                    error: 'bg-danger-500 dark:bg-danger-600',
                    warning: 'bg-accent-500 dark:bg-accent-600',
                    info: 'bg-info-500 dark:bg-info-600'
                };

                toast.className = `max-w-sm w-full bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-lg p-4 opacity-0 translate-x-full transition-all duration-300 transform`;
                toast.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i class="${icons[type]} text-lg ${colors[type]} text-white rounded-full p-1"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">${message}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors duration-200" onclick="this.parentElement.parentElement.parentElement.remove()">
                                <i class="ri-close-line text-lg"></i>
                            </button>
                        </div>
                    </div>
                `;

                return toast;
            }

            hide(toast) {
                toast.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                    this.toasts = this.toasts.filter(t => t !== toast);
                }, 300);
            }

            hideAll() {
                this.toasts.forEach(toast => this.hide(toast));
            }
        }

        // Sistema de loading
        class LoadingManager {
            constructor() {
                this.overlay = document.getElementById('loading-overlay');
            }

            show() {
                this.overlay.classList.remove('hidden');
            }

            hide() {
                this.overlay.classList.add('hidden');
            }
        }

        // Instanciar managers globales
        window.toastManager = new ToastManager();
        window.loadingManager = new LoadingManager();

        // Función global para mostrar notificaciones
        window.showToast = function(message, type = 'info', duration = 5000) {
            return window.toastManager.show(message, type, duration);
        };

        // Función global para mostrar/ocultar loading
        window.showLoading = function() {
            window.loadingManager.show();
        };

        window.hideLoading = function() {
            window.loadingManager.hide();
        };

        // Interceptor para mensajes de Laravel
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar mensajes de sesión si existen
            @if(session('success'))
                window.showToast('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                window.showToast('{{ session('error') }}', 'error');
            @endif

            @if(session('warning'))
                window.showToast('{{ session('warning') }}', 'warning');
            @endif

            @if(session('info'))
                window.showToast('{{ session('info') }}', 'info');
            @endif

            // Mostrar errores de validación si existen
            @if($errors->any())
                @foreach($errors->all() as $error)
                    window.showToast('{{ $error }}', 'error');
                @endforeach
            @endif
        });

        // Mejorar la experiencia de navegación
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar indicadores de carga a los enlaces
            const links = document.querySelectorAll('a[href]:not([href^="#"]):not([href^="javascript:"])');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Solo mostrar loading para enlaces internos
                    if (this.href.startsWith(window.location.origin)) {
                        window.showLoading();
                    }
                });
            });

            // Agregar indicadores de carga a los formularios
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    window.showLoading();
                });
            });
        });
</script>

    @stack('scripts')
</body>
</html>
