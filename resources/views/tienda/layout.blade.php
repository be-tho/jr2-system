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

    <!-- Contenedor de Notificaciones Globales -->
    <div id="notifications-container" class="fixed top-20 right-4 z-50 space-y-3 max-w-md w-full px-4 sm:px-0"></div>

    <!-- Scripts para carrito y notificaciones -->
    <script>
        // Sistema de Notificaciones Globales
        function mostrarNotificacion(mensaje, tipo = 'success') {
            const container = document.getElementById('notifications-container');
            if (!container) return;

            const notification = document.createElement('div');
            const tipos = {
                success: {
                    bg: 'bg-green-500',
                    icon: 'ri-checkbox-circle-fill',
                    text: 'text-white'
                },
                error: {
                    bg: 'bg-red-500',
                    icon: 'ri-error-warning-fill',
                    text: 'text-white'
                },
                info: {
                    bg: 'bg-blue-500',
                    icon: 'ri-information-fill',
                    text: 'text-white'
                },
                warning: {
                    bg: 'bg-yellow-500',
                    icon: 'ri-alert-fill',
                    text: 'text-white'
                }
            };

            const config = tipos[tipo] || tipos.success;
            
            notification.className = `${config.bg} ${config.text} px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in-right transform transition-all duration-300`;
            notification.innerHTML = `
                <i class="${config.icon} text-xl"></i>
                <span class="flex-1 font-medium">${mensaje}</span>
                <button onclick="this.parentElement.remove()" class="hover:opacity-75 transition-opacity">
                    <i class="ri-close-line text-xl"></i>
                </button>
            `;

            container.appendChild(notification);

            // Auto-eliminar después de 4 segundos
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        // Actualizar contador del carrito
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

        // Actualizar carrito al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            actualizarCarrito();
        });

        // Mensajes de sesión
        @if(session('success'))
            mostrarNotificacion('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            mostrarNotificacion('{{ session('error') }}', 'error');
        @endif
    </script>

    <style>
        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .animate-slide-in-right {
            animation: slide-in-right 0.3s ease-out;
        }
    </style>

    @stack('scripts')
</body>
</html>

