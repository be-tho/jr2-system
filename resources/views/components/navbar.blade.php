{{-- Componente Navbar Refactorizado - Diseño Minimalista con Fucsia --}}
<div class="relative">
    {{-- Sidebar Principal --}}
    <div class="fixed left-0 top-0 w-64 h-full bg-white dark:bg-neutral-900 shadow-xl transform transition-all duration-300 ease-in-out z-40 border-r border-neutral-200 dark:border-neutral-700" 
         id="sidebar">
        
        {{-- Header del Sidebar --}}
        <header class="p-6 border-b border-neutral-200 dark:border-neutral-700 bg-primary-50 dark:bg-primary-950/20">
            <a href="/" class="flex items-center gap-x-3 group">
                <div class="relative">
                    <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-primary-500/25 transition-all duration-300">
                        <span class="text-xl font-bold text-white">JR</span>
                    </div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-accent-400 rounded-full border-2 border-white dark:border-neutral-900 animate-pulse"></div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">JR2 System</span>
                    <span class="text-xs text-neutral-600 dark:text-neutral-400">Management Platform</span>
                </div>
            </a>
        </header>

        {{-- Navegación Principal --}}
        @auth()
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <div class="space-y-2">
                {{-- Dashboard --}}
                <a href="/" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('home.index') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Dashboard">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('home.index') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-dashboard-3-line text-lg {{ Route::is('home.index') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('home.index') ? 'font-semibold' : '' }}">Dashboard</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('home.index') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Cortes --}}
                <a href="{{ route('cortes.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('cortes.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Gestión de Cortes">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('cortes.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-scissors-cut-line text-lg {{ Route::is('cortes.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('cortes.*') ? 'font-semibold' : '' }}">Cortes</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('cortes.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Artículos --}}
                <a href="{{ route('articulos.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('articulos.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Inventario de Artículos">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('articulos.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-shirt-line text-lg {{ Route::is('articulos.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('articulos.*') ? 'font-semibold' : '' }}">Artículos</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('articulos.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Categorías --}}
                <a href="{{ route('categorias.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('categorias.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Gestión de Categorías">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('categorias.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-price-tag-3-line text-lg {{ Route::is('categorias.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('categorias.*') ? 'font-semibold' : '' }}">Categorías</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('categorias.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Temporadas --}}
                <a href="{{ route('temporadas.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('temporadas.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Gestión de Temporadas">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('temporadas.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-calendar-line text-lg {{ Route::is('temporadas.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('temporadas.*') ? 'font-semibold' : '' }}">Temporadas</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('temporadas.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Costureros --}}
                <a href="#" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer"
                   data-tooltip="Gestión de Costureros">
                    <div class="w-10 h-10 rounded-lg bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20 flex items-center justify-center transition-all duration-300">
                        <i class="ri-user-settings-line text-lg text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300">Costureros</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full opacity-0 scale-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Dólar --}}
                <a href="{{ route('dolar.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('dolar.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Cotización del Dólar">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('dolar.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-money-dollar-circle-line text-lg {{ Route::is('dolar.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('dolar.*') ? 'font-semibold' : '' }}">Dólar</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('dolar.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Reportes --}}
                <a href="{{ route('reportes.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('reportes.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Reportes y Estadísticas">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('reportes.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-bar-chart-2-line text-lg {{ Route::is('reportes.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('reportes.*') ? 'font-semibold' : '' }}">Reportes</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('reportes.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>

                {{-- Cuenta --}}
                <a href="{{ route('cuenta.index') }}" 
                   class="flex items-center gap-x-3 px-3 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 hover:translate-x-2 transition-all duration-300 relative overflow-hidden group cursor-pointer {{ Route::is('cuenta.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500 shadow-sm' : '' }}"
                   data-tooltip="Mi Cuenta">
                    <div class="w-10 h-10 rounded-lg {{ Route::is('cuenta.*') ? 'bg-primary-500 shadow-lg shadow-primary-500/20' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-300">
                        <i class="ri-user-line text-lg {{ Route::is('cuenta.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 {{ Route::is('cuenta.*') ? 'font-semibold' : '' }}">Cuenta</span>
                    <div class="absolute right-2 w-2 h-2 bg-primary-500 rounded-full {{ Route::is('cuenta.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }} transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
                </a>
            </div>

            {{-- Separador --}}
            <div class="my-6 border-t border-neutral-200 dark:border-neutral-700"></div>

            {{-- Información del Usuario --}}
            <div class="px-2">
                <div class="bg-neutral-50 dark:bg-neutral-800/50 rounded-lg p-3 border border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-x-3">
                        <div class="relative">
                            <img id="navbar-profile-image"
                                 src="{{ \App\Helpers\ImageHelper::getProfileImageUrl(auth()->user()->profile_image) }}" 
                                 alt="{{ \App\Helpers\ImageHelper::getProfileImageAlt(auth()->user()->profile_image, auth()->user()->name) }}" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-neutral-300 dark:border-neutral-600 shadow-lg {{ \App\Helpers\ImageHelper::getProfileImageClass(auth()->user()->profile_image) }}">
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-accent-400 rounded-full border-2 border-white dark:border-neutral-800 animate-pulse"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('cuenta.index') }}" class="block hover:opacity-80 transition-opacity duration-200">
                                <p class="text-sm font-medium text-neutral-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Administrador</p>
                            </a>
                        </div>
                        <div class="flex-shrink-0">
                            <form action="{{ route('logout') }}" method="post" class="m-0">
                                @csrf
                                <button type="submit" 
                                        class="text-neutral-400 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-200 p-1 rounded hover:bg-neutral-100 dark:hover:bg-neutral-700"
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
        <footer class="p-4 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800/30">
            <div class="text-center">
                <p class="text-xs text-neutral-500 dark:text-neutral-400">© 2024 JR2 System</p>
                <p class="text-xs text-neutral-600 dark:text-neutral-500 mt-1">v2.0.0</p>
            </div>
        </footer>
    </div>

    {{-- Overlay para móviles --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden hidden transition-opacity duration-300" id="sidebar-overlay"></div>

    {{-- Botón Toggle para móviles --}}
    <button class="fixed top-4 left-4 z-50 lg:hidden bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white p-2 rounded-lg shadow-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-all duration-200 border border-neutral-200 dark:border-neutral-700"
            id="mobile-toggle"
            aria-label="Toggle sidebar">
        <i class="ri-menu-line text-xl"></i>
    </button>

    {{-- Tooltip Component --}}
    <div class="fixed z-50 px-3 py-2 text-xs text-white bg-neutral-900 dark:bg-neutral-800 rounded-lg shadow-xl border border-neutral-700/50 dark:border-neutral-600/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 font-medium" id="tooltip"></div>
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
    
    // Función para actualizar la imagen de perfil
    updateProfileImage(newImageUrl, newImageAlt = null) {
        const profileImage = document.getElementById('navbar-profile-image');
        if (profileImage) {
            profileImage.src = newImageUrl;
            if (newImageAlt) {
                profileImage.alt = newImageAlt;
            }
            
            // Agregar efecto de transición
            profileImage.style.opacity = '0.7';
            setTimeout(() => {
                profileImage.style.opacity = '1';
            }, 200);
        }
    }
    
    // Función para actualizar la imagen desde el helper
    updateProfileImageFromHelper(profileImage, userName) {
        if (typeof window.ImageHelper !== 'undefined') {
            const newUrl = window.ImageHelper.getProfileImageUrl(profileImage);
            const newAlt = window.ImageHelper.getProfileImageAlt(profileImage, userName);
            this.updateProfileImage(newUrl, newAlt);
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.navbarManager = new NavbarManager();
});

// Hacer disponible globalmente para otras páginas
window.NavbarManager = NavbarManager;
</script>
