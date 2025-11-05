<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Tienda - ' . config('app.name'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="h-full bg-gray-50 dark:bg-neutral-900 transition-colors duration-300">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <div class="min-h-screen flex flex-col">
        <!-- Header de la Tienda -->
        <header class="bg-white dark:bg-neutral-800 border-b border-gray-200 dark:border-neutral-700 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="{{ route('tienda.index') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center">
                            <span class="text-lg font-bold text-white">JR</span>
                        </div>
                        <span class="text-xl font-bold text-neutral-900 dark:text-white">Tienda JR2</span>
                    </a>

                    <!-- Carrito -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('checkout.index') }}" class="relative p-2 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <i class="ri-shopping-cart-line text-2xl"></i>
                            <span id="cart-count" class="absolute -top-1 -right-1 bg-primary-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700 mt-auto">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-neutral-600 dark:text-neutral-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Sistema de Notificaciones con Alpine.js -->
    @include('components.notifications-alpine')

    <!-- Modal de Confirmación -->
    <div id="confirm-modal" x-data="confirmModal()" 
         x-show="show" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         @keydown.escape.window="cerrar()">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="fixed inset-0 bg-gray-500 dark:bg-neutral-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                 @click="cerrar()"></div>

            <div x-show="show"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white dark:bg-neutral-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="ri-error-warning-line text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                            <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-neutral-500 dark:text-neutral-400" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="confirmar()"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Eliminar
                    </button>
                    <button type="button" 
                            @click="cerrar()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-neutral-300 dark:border-neutral-600 shadow-sm px-4 py-2 bg-white dark:bg-neutral-800 text-base font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sistema de confirmación - se inicializa después de que Alpine esté listo
        let pendingCallback = null;

        // Función para mostrar confirmación (disponible globalmente)
        window.mostrarConfirmacion = function(titulo, mensaje, onConfirm) {
            pendingCallback = onConfirm;
            
            // Disparar evento para mostrar el modal
            window.dispatchEvent(new CustomEvent('show-confirmation-modal', {
                detail: { title: titulo, message: mensaje }
            }));
        };

        // Escuchar confirmación desde el modal Alpine
        window.addEventListener('confirmation-accepted', function() {
            if (pendingCallback) {
                pendingCallback();
                pendingCallback = null;
            }
        });

        // Escuchar cancelación desde el modal Alpine
        window.addEventListener('confirmation-cancelled', function() {
            pendingCallback = null;
        });
        
        function mostrarNotificacion(mensaje, tipo = 'success') {
            if (window.showNotification) {
                window.showNotification(tipo, mensaje, 3000);
            } else {
                setTimeout(() => {
                    if (window.showNotification) {
                        window.showNotification(tipo, mensaje, 3000);
                    }
                }, 100);
            }
        }

        function actualizarCarrito() {
            fetch('{{ route('carrito.cantidad') }}')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cantidad || 0;
                    }
                })
                .catch(error => console.error('Error al actualizar carrito:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            actualizarCarrito();
            
            @if(session('success'))
                mostrarNotificacion('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                mostrarNotificacion('{{ session('error') }}', 'error');
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>


