{{-- Componente Navbar Refactorizado - Solo Tailwind CSS --}}
<div class="relative">
    {{-- Sidebar Principal --}}
    <div class="fixed left-0 top-0 w-64 h-full bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 shadow-2xl transform transition-all duration-300 ease-in-out z-40" 
         id="sidebar">
        
        {{-- Header del Sidebar --}}
        <header class="p-6 border-b border-gray-700/50 dark:border-gray-600/30 bg-gray-800/80 dark:bg-gray-900/80 backdrop-blur-xl">
            <a href="/" class="flex items-center gap-x-3 group">
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/25 transition-all duration-300">
                        <span class="text-xl font-bold text-white">JR</span>
                    </div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-gray-900 dark:border-gray-950 animate-pulse"></div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors duration-300">JR2 System</span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Management Platform</span>
                </div>
            </a>
        </header>

        {{-- Navegación Principal --}}
            @auth()
            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <div class="space-y-2">
                    {{-- Dashboard --}}
                    <a href="/" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 dark:text-gray-400 hover:text-white hover:bg-gray-800/80 dark:hover:bg-gray-800/60 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('home.index') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Dashboard">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('home.index') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 dark:bg-gray-600 group-hover:bg-gray-600 dark:group-hover:bg-gray-500' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-dashboard-3-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('home.index') ? 'font-semibold' : '' }}">Dashboard</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('home.index') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Cortes --}}
                    <a href="{{ route('cortes.index') }}" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 dark:text-gray-400 hover:text-white hover:bg-gray-800/80 dark:hover:bg-gray-800/60 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('cortes.*') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Gestión de Cortes">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('cortes.*') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 dark:bg-gray-600 group-hover:bg-gray-600 dark:group-hover:bg-gray-500' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-scissors-cut-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('cortes.*') ? 'font-semibold' : '' }}">Cortes</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('cortes.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Artículos --}}
                    <a href="{{ route('articulos.index') }}" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 dark:text-gray-400 hover:text-white hover:bg-gray-800/80 dark:hover:bg-gray-800/60 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('articulos.*') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Inventario de Artículos">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('articulos.*') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 dark:bg-gray-600 group-hover:bg-gray-600 dark:group-hover:bg-gray-500' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-shirt-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('articulos.*') ? 'font-semibold' : '' }}">Artículos</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('articulos.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Costureros --}}
                    <a href="#" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 dark:text-gray-400 hover:text-white hover:bg-gray-800/80 dark:hover:bg-gray-800/60 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer"
                       data-tooltip="Gestión de Costureros">
                        <div class="w-10 h-10 rounded-lg bg-gray-700 dark:bg-gray-600 group-hover:bg-gray-600 dark:group-hover:bg-gray-500 flex items-center justify-center transition-all duration-300">
                            <i class="ri-user-settings-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300">Costureros</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full opacity-0 scale-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Dólar --}}
                    <a href="{{ route('dolar.index') }}" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 dark:text-gray-400 hover:text-white hover:bg-gray-800/80 dark:hover:bg-gray-800/60 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('dolar.*') ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-white border-r-2 border-blue-500 shadow-lg shadow-blue-500/30' : '' }}"
                       data-tooltip="Cotización del Dólar">
                        <div class="w-10 h-10 rounded-lg {{ Route::is('dolar.*') ? 'bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/40' : 'bg-gray-700 dark:bg-gray-600 group-hover:bg-gray-600 dark:group-hover:bg-gray-500' }} flex items-center justify-center transition-all duration-300">
                            <i class="ri-money-dollar-circle-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300 {{ Route::is('dolar.*') ? 'font-semibold' : '' }}">Dólar</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full {{ Route::is('dolar.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>

                    {{-- Cuenta --}}
                    <a href="#" 
                       class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-gray-300 dark:text-gray-400 hover:text-white hover:bg-gray-800/80 dark:hover:bg-gray-800/60 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer"
                       data-tooltip="Configuración de Cuenta">
                        <div class="w-10 h-10 rounded-lg bg-gray-700 dark:bg-gray-600 group-hover:bg-gray-600 dark:group-hover:bg-gray-500 flex items-center justify-center transition-all duration-300">
                            <i class="ri-settings-3-line text-lg"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300">Cuenta</span>
                        <div class="absolute right-2 w-2 h-2 bg-blue-500 rounded-full opacity-0 scale-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                    </a>
                </div>

                {{-- Separador --}}
                <div class="my-6 border-t border-gray-700/50 dark:border-gray-600/30"></div>

                {{-- Información del Usuario --}}
                <div class="px-2">
                    <div class="bg-gray-800/50 dark:bg-gray-700/50 rounded-lg p-3 border border-gray-700/30 dark:border-gray-600/30 backdrop-blur-sm">
                        <div class="flex items-center gap-x-3">
                            <div class="relative">
                                <img src="{{ asset('./src/assets/images/usuario.jpg') }}" 
                                     alt="Usuario" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-600 dark:border-gray-500 shadow-lg">
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-gray-800 dark:border-gray-700 animate-pulse"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Administrador</p>
                            </div>
                            <div class="flex-shrink-0">
                                <form action="{{ route('logout') }}" method="post" class="m-0">
                                    @csrf
                                    <button type="submit" 
                                            class="text-gray-400 hover:text-red-400 dark:hover:text-red-300 transition-colors duration-200 p-1 rounded hover:bg-gray-700/50 dark:hover:bg-gray-600/50"
                                            data-tooltip="Cerrar sesión">
                                        <i class="ri-logout-box-r-line text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </nav>
            @endauth

        {{-- Footer del Sidebar --}}
        <footer class="p-4 border-t border-gray-700/50 dark:border-gray-600/30 bg-gray-800/30 dark:bg-gray-900/30">
            <div class="text-center">
                <p class="text-xs text-gray-500 dark:text-gray-600">© 2024 JR2 System</p>
                <p class="text-xs text-gray-600 dark:text-gray-700 mt-1">v2.0.0</p>
            </div>
        </footer>
    </div>

    {{-- Overlay para móviles --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden hidden transition-opacity duration-300" id="sidebar-overlay"></div>

    {{-- Botón Toggle para móviles --}}
    <button class="fixed top-4 left-4 z-50 lg:hidden bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-700 text-white p-2 rounded-lg shadow-lg hover:from-gray-800 hover:to-gray-700 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200 border border-gray-700/30 dark:border-gray-600/30 backdrop-blur-sm"
            id="mobile-toggle"
            aria-label="Toggle sidebar">
        <i class="ri-menu-line text-xl"></i>
    </button>

    {{-- Tooltip Component --}}
    <div class="fixed z-50 px-3 py-2 text-xs text-white bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-700 rounded-lg shadow-xl border border-gray-700/50 dark:border-gray-600/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 font-medium" id="tooltip"></div>
</div>

{{-- JavaScript optimizado para funcionalidad del navbar --}}
<script>
class NavbarManager {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.mobileToggle = document.getElementById('mobile-toggle');
        this.overlay = document.getElementById('sidebar-overlay');
        this.tooltip = document.getElementById('tooltip');
        this.isOpen = false;
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupResponsive();
        this.setupTooltips();
        this.setupHoverEffects();
    }

    setupEventListeners() {
        // Toggle del sidebar en móviles
        if (this.mobileToggle) {
            this.mobileToggle.addEventListener('click', () => this.toggleSidebar());
        }
        
        // Cerrar sidebar al hacer click en el overlay
        if (this.overlay) {
            this.overlay.addEventListener('click', () => this.closeSidebar());
        }
        
        // Cerrar sidebar al hacer click en un item (móviles)
        const navItems = document.querySelectorAll('[data-tooltip]');
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    this.closeSidebar();
                }
            });
        });
    }

    setupResponsive() {
        // Detectar cambios de tamaño de ventana
        const resizeObserver = new ResizeObserver(() => {
            this.handleResize();
        });
        
        if (this.sidebar) {
            resizeObserver.observe(this.sidebar);
        }
        
        // Inicializar sidebar en móviles como oculto
        this.handleResize();
    }

    setupTooltips() {
        const navItems = document.querySelectorAll('[data-tooltip]');
        
        navItems.forEach(item => {
            item.addEventListener('mouseenter', (e) => this.showTooltip(e, item));
            item.addEventListener('mouseleave', () => this.hideTooltip());
        });
    }

    setupHoverEffects() {
        const navItems = document.querySelectorAll('[data-tooltip]');
        
        navItems.forEach(item => {
            item.addEventListener('mouseenter', () => this.addHoverEffect(item));
            item.addEventListener('mouseleave', () => this.removeHoverEffect(item));
        });
    }

    toggleSidebar() {
        if (this.isOpen) {
            this.closeSidebar();
        } else {
            this.openSidebar();
        }
    }

    openSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.remove('-translate-x-full');
            this.sidebar.classList.add('translate-x-0');
        }
        if (this.overlay) {
            this.overlay.classList.remove('hidden');
        }
        this.isOpen = true;
    }

    closeSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.add('-translate-x-full');
            this.sidebar.classList.remove('translate-x-0');
        }
        if (this.overlay) {
            this.overlay.classList.add('hidden');
        }
        this.isOpen = false;
    }

    handleResize() {
        if (window.innerWidth >= 1024) {
            this.closeSidebar();
            if (this.sidebar) {
                this.sidebar.classList.remove('-translate-x-full');
                this.sidebar.classList.add('translate-x-0');
            }
        } else {
            if (this.sidebar) {
                this.sidebar.classList.add('-translate-x-full');
                this.sidebar.classList.remove('translate-x-0');
            }
        }
    }

    showTooltip(event, item) {
        if (!this.tooltip) return;
        
        const tooltipText = item.getAttribute('data-tooltip');
        this.tooltip.textContent = tooltipText;
        this.tooltip.style.left = event.pageX + 10 + 'px';
        this.tooltip.style.top = event.pageY - 30 + 'px';
        this.tooltip.classList.remove('opacity-0');
    }

    hideTooltip() {
        if (this.tooltip) {
            this.tooltip.classList.add('opacity-0');
        }
    }

    addHoverEffect(item) {
        item.style.transform = 'translateX(8px) scale(1.02)';
    }

    removeHoverEffect(item) {
        item.style.transform = 'translateX(0) scale(1)';
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new NavbarManager();
});
</script>
