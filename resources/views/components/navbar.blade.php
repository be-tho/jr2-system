{{-- Componente Navbar Refactorizado - Solo Tailwind CSS --}}
<div class="relative">
    {{-- Sidebar Principal --}}
    <div class="fixed left-0 top-0 w-64 h-full bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 shadow-2xl transform transition-all duration-300 ease-in-out z-40" 
         id="sidebar">
        
        {{-- Header del Sidebar --}}
        <header class="p-6 border-b border-gray-700/50 bg-gray-800/80 backdrop-blur-xl">
            <a href="/" class="flex items-center gap-x-3 group">
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/25 transition-all duration-300">
                        <span class="text-xl font-bold text-white">JR</span>
                    </div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-gray-900 animate-pulse"></div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors duration-300">JR2 System</span>
                    <span class="text-xs text-gray-400">Management Platform</span>
                </div>
            </a>
        </header>

        {{-- Navegación Principal --}}
        @auth()
            <nav class="flex-1 px-4 py-6">
                <div class="space-y-2">
                    {{-- Dashboard --}}
                    <a href="/" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800/80 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('home.index') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Dashboard">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('home.index') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 group-hover:bg-gray-600' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-dashboard-3-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('home.index') ? 'font-semibold' : '' }}">Dashboard</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('home.index') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Cortes --}}
                    <a href="{{ route('cortes.index') }}" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800/80 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('cortes.index') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Gestión de Cortes">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('cortes.index') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 group-hover:bg-gray-600' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-scissors-cut-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('cortes.index') ? 'font-semibold' : '' }}">Cortes</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('cortes.index') ? 'opacity-100 scale-100' : 'opacity-0 scale-100' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Artículos --}}
                    <a href="{{ route('articulos.index') }}" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800/80 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('articulos.index') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Inventario de Artículos">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('articulos.index') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 group-hover:bg-gray-600' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-shirt-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('articulos.index') ? 'font-semibold' : '' }}">Artículos</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('articulos.index') ? 'opacity-100 scale-100' : 'opacity-0 scale-100' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Costureros --}}
                    <a href="#" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800/80 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer"
                       data-tooltip="Gestión de Costureros">
                        <div class="w-10 h-10 rounded-lg bg-gray-700 group-hover:bg-gray-600 flex items-center justify-center transition-all duration-300">
                            <i class="ri-user-settings-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300">Costureros</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full opacity-0 scale-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Dólar --}}
                    <a href="{{ route('dolar.index') }}" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800/80 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('dolar.index') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Cotización del Dólar">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('dolar.index') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 group-hover:bg-gray-600' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-money-dollar-circle-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('dolar.index') ? 'font-semibold' : '' }}">Dólar</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('dolar.index') ? 'opacity-100 scale-100' : 'opacity-0 scale-100' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Cuenta --}}
                    <a href="#" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800/80 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer"
                       data-tooltip="Configuración de Cuenta">
                        <div class="w-10 h-10 rounded-lg bg-gray-700 group-hover:bg-gray-600 flex items-center justify-center transition-all duration-300">
                            <i class="ri-settings-3-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300">Cuenta</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full opacity-0 scale-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>
                </div>

                {{-- Separador --}}
                <div class="my-6 border-t border-gray-700/50"></div>

                {{-- Información del Usuario --}}
                <div class="px-2">
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/30 backdrop-blur-sm">
                        <div class="flex items-center gap-x-3">
                            <div class="relative">
                                <img src="{{ asset('./src/assets/images/usuario.jpg') }}" 
                                     alt="Usuario" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-600 shadow-lg">
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-gray-800 animate-pulse"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400">Administrador</p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        @endauth

        {{-- Footer del Sidebar --}}
        <footer class="p-4 border-t border-gray-700/50 bg-gray-800/30">
            <div class="text-center">
                <p class="text-xs text-gray-500">© 2024 JR2 System</p>
                <p class="text-xs text-gray-600 mt-1">v2.0.0</p>
            </div>
        </footer>
    </div>

    {{-- Overlay para móviles --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden hidden transition-opacity duration-300" id="sidebar-overlay"></div>

    {{-- Botón Toggle para móviles --}}
    <button class="fixed top-4 left-4 z-50 lg:hidden bg-gradient-to-r from-gray-900 to-gray-800 text-white p-2 rounded-lg shadow-lg hover:from-gray-800 hover:to-gray-700 transition-all duration-200 border border-gray-700/30 backdrop-blur-sm"
            id="mobile-toggle">
        <i class="ri-menu-line text-xl"></i>
    </button>

    {{-- Tooltip Component --}}
    <div class="fixed z-50 px-3 py-2 text-xs text-white bg-gradient-to-r from-gray-900 to-gray-800 rounded-lg shadow-xl border border-gray-700/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 font-medium" id="tooltip"></div>
</div>

{{-- JavaScript para funcionalidad del navbar --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mobileToggle = document.getElementById('mobile-toggle');
    const overlay = document.getElementById('sidebar-overlay');
    const tooltip = document.getElementById('tooltip');
    
    // Toggle del sidebar en móviles
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            if (overlay) {
                overlay.classList.toggle('hidden');
            }
        });
    }
    
    // Cerrar sidebar al hacer click en el overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        });
    }
    
    // Tooltips
    const navItems = document.querySelectorAll('[data-tooltip]');
    navItems.forEach(item => {
        item.addEventListener('mouseenter', function(e) {
            const tooltipText = this.getAttribute('data-tooltip');
            tooltip.textContent = tooltipText;
            tooltip.style.left = e.pageX + 10 + 'px';
            tooltip.style.top = e.pageY - 30 + 'px';
            tooltip.classList.remove('opacity-0');
        });
        
        item.addEventListener('mouseleave', function() {
            tooltip.classList.add('opacity-0');
        });
    });
    
    // Cerrar sidebar al hacer click en un item (móviles)
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                if (overlay) {
                    overlay.classList.add('hidden');
                }
            }
        });
    });
    
    // Detectar cambios de tamaño de ventana
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            if (overlay) {
                overlay.classList.add('hidden');
            }
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
        }
    });
    
    // Efectos de hover mejorados
    navItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });
    
    // Inicializar sidebar en móviles como oculto
    if (window.innerWidth < 1024) {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
    }
});
</script>
