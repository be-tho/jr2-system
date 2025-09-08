{{-- Componente Navbar Optimizado - Diseño Compacto y Colapsable --}}
<div class="relative">
    {{-- Sidebar Principal --}}
    <div class="fixed left-0 top-0 h-full bg-white dark:bg-neutral-900 shadow-xl transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out z-40 border-r border-neutral-200 dark:border-neutral-700" 
         id="sidebar" data-expanded="true">
        
        {{-- Header del Sidebar - Compacto --}}
        <header class="p-4 border-b border-neutral-200 dark:border-neutral-700 bg-primary-50 dark:bg-primary-950/20">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-x-2 group">
                    <div class="relative">
                        <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-primary-500/25 transition-all duration-300">
                            <span class="text-lg font-bold text-white">JR</span>
                        </div>
                        <div class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-accent-400 rounded-full border-2 border-white dark:border-neutral-900 animate-pulse"></div>
                    </div>
                    <div class="flex flex-col sidebar-text" data-text="true">
                        <span class="text-lg font-bold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">JR2 System</span>
                        <span class="text-xs text-neutral-600 dark:text-neutral-400">Management Platform</span>
                    </div>
                </a>
                
                {{-- Botón para colapsar/expandir sidebar --}}
                <button id="sidebar-toggle" class="hidden lg:flex p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors duration-200" 
                        data-tooltip="Colapsar sidebar">
                    <i class="ri-sidebar-fold-line text-lg text-neutral-600 dark:text-neutral-400"></i>
                </button>
            </div>
            
            {{-- Búsqueda rápida --}}
            <div class="mt-3 sidebar-search" data-search="true">
                <div class="relative">
                    <input type="text" 
                           id="nav-search" 
                           placeholder="Buscar..." 
                           class="w-full px-3 py-2 pl-9 text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                           autocomplete="off">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400 text-sm"></i>
                    <button id="clear-search" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 hidden">
                        <i class="ri-close-line text-sm"></i>
                    </button>
                </div>
                <div id="search-results" class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-lg z-50 hidden max-h-60 overflow-y-auto">
                    <!-- Resultados de búsqueda se llenan dinámicamente -->
                </div>
            </div>
        </header>

        {{-- Navegación Principal --}}
        @auth()
        <nav class="flex-1 overflow-hidden">
            {{-- Vista Desktop --}}
            <div class="hidden lg:block px-3 py-4 h-full overflow-y-auto">
                <div class="space-y-1">
                    {{-- Dashboard --}}
                    <a href="/" 
                       class="nav-item flex items-center gap-x-2 px-3 py-2.5 rounded-lg text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-all duration-200 relative group cursor-pointer {{ Route::is('home.index') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500' : '' }}"
                       data-tooltip="Dashboard">
                        <div class="w-8 h-8 rounded-lg {{ Route::is('home.index') ? 'bg-primary-500' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-200">
                            <i class="ri-dashboard-3-line text-sm {{ Route::is('home.index') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                        </div>
                        <span class="nav-text text-sm font-medium {{ Route::is('home.index') ? 'font-semibold' : '' }}">Dashboard</span>
                    </a>

                    {{-- Sección Producción Colapsable --}}
                    <div class="nav-section" data-section="produccion">
                        <button class="nav-section-toggle w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleNavSection('produccion')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center">
                                    <i class="ri-scissors-cut-line text-sm text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="nav-text text-sm font-medium text-neutral-900 dark:text-white">Producción</span>
                            </div>
                            <i class="nav-arrow ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="produccion-arrow"></i>
                        </button>
                        <div class="nav-section-items ml-4 mt-1 space-y-1 hidden" id="produccion-items">
                            <a href="{{ route('cortes.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('cortes.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Gestión de Cortes">
                                <i class="ri-scissors-cut-line text-sm"></i>
                                <span class="nav-text">Cortes</span>
                            </a>
                            <a href="{{ route('costureros.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('costureros.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Gestión de Costureros">
                                <i class="ri-user-settings-line text-sm"></i>
                                <span class="nav-text">Costureros</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sección Inventario Colapsable --}}
                    <div class="nav-section" data-section="inventario">
                        <button class="nav-section-toggle w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleNavSection('inventario')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/20 flex items-center justify-center">
                                    <i class="ri-shirt-line text-sm text-green-600 dark:text-green-400"></i>
                                </div>
                                <span class="nav-text text-sm font-medium text-neutral-900 dark:text-white">Inventario</span>
                            </div>
                            <i class="nav-arrow ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="inventario-arrow"></i>
                        </button>
                        <div class="nav-section-items ml-4 mt-1 space-y-1 hidden" id="inventario-items">
                            <a href="{{ route('articulos.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('articulos.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Inventario de Artículos">
                                <i class="ri-shirt-line text-sm"></i>
                                <span class="nav-text">Artículos</span>
                            </a>
                            <a href="{{ route('categorias.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('categorias.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Gestión de Categorías">
                                <i class="ri-price-tag-3-line text-sm"></i>
                                <span class="nav-text">Categorías</span>
                            </a>
                            <a href="{{ route('temporadas.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('temporadas.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Gestión de Temporadas">
                                <i class="ri-calendar-line text-sm"></i>
                                <span class="nav-text">Temporadas</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sección Análisis Colapsable --}}
                    <div class="nav-section" data-section="analisis">
                        <button class="nav-section-toggle w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleNavSection('analisis')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center">
                                    <i class="ri-bar-chart-2-line text-sm text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <span class="nav-text text-sm font-medium text-neutral-900 dark:text-white">Análisis</span>
                            </div>
                            <i class="nav-arrow ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="analisis-arrow"></i>
                        </button>
                        <div class="nav-section-items ml-4 mt-1 space-y-1 hidden" id="analisis-items">
                            <a href="{{ route('dolar.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('dolar.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Cotización del Dólar">
                                <i class="ri-money-dollar-circle-line text-sm"></i>
                                <span class="nav-text">Dólar</span>
                            </a>
                            <a href="{{ route('reportes.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('reportes.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Reportes y Estadísticas">
                                <i class="ri-bar-chart-2-line text-sm"></i>
                                <span class="nav-text">Reportes</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sección Administración Colapsable --}}
                    @if(auth()->user()->hasRole('administrador'))
                    <div class="nav-section" data-section="administracion">
                        <button class="nav-section-toggle w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleNavSection('administracion')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                                    <i class="ri-settings-3-line text-sm text-red-600 dark:text-red-400"></i>
                                </div>
                                <span class="nav-text text-sm font-medium text-neutral-900 dark:text-white">Administración</span>
                            </div>
                            <i class="nav-arrow ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="administracion-arrow"></i>
                        </button>
                        <div class="nav-section-items ml-4 mt-1 space-y-1 hidden" id="administracion-items">
                            <a href="{{ route('users.index') }}" 
                               class="nav-item flex items-center gap-x-2 px-3 py-2 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-colors duration-200 {{ Route::is('users.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}"
                               data-tooltip="Gestión de Usuarios">
                                <i class="ri-team-line text-sm"></i>
                                <span class="nav-text">Usuarios</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Cuenta --}}
                    <a href="{{ route('cuenta.index') }}" 
                       class="nav-item flex items-center gap-x-2 px-3 py-2.5 rounded-lg text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/20 transition-all duration-200 group cursor-pointer {{ Route::is('cuenta.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 border-r-2 border-primary-500' : '' }}"
                       data-tooltip="Mi Cuenta">
                        <div class="w-8 h-8 rounded-lg {{ Route::is('cuenta.*') ? 'bg-primary-500' : 'bg-neutral-100 dark:bg-neutral-800 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/20' }} flex items-center justify-center transition-all duration-200">
                            <i class="ri-user-line text-sm {{ Route::is('cuenta.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}"></i>
                        </div>
                        <span class="nav-text text-sm font-medium {{ Route::is('cuenta.*') ? 'font-semibold' : '' }}">Cuenta</span>
                    </a>
                </div>
            </div>

            {{-- Vista Móvil Compacta --}}
            <div class="lg:hidden px-2 py-3 h-full overflow-y-auto" style="max-height: calc(100vh - 140px);">
                <div class="space-y-1">
                    {{-- Dashboard Móvil --}}
                    <a href="/" 
                       class="flex items-center gap-x-2 px-2 py-2 rounded-lg text-neutral-700 dark:text-neutral-300 transition-all duration-200 {{ Route::is('home.index') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <div class="w-7 h-7 rounded-lg {{ Route::is('home.index') ? 'bg-primary-500' : 'bg-neutral-100 dark:bg-neutral-800' }} flex items-center justify-center">
                            <i class="ri-dashboard-3-line text-xs {{ Route::is('home.index') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400' }}"></i>
                        </div>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>

                    {{-- Sección Producción Colapsable --}}
                    <div class="mobile-section" data-section="produccion">
                        <button class="w-full flex items-center justify-between px-2 py-2 text-left rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleMobileSection('produccion')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center">
                                    <i class="ri-scissors-cut-line text-xs text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-900 dark:text-white">Producción</span>
                            </div>
                            <i class="ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="produccion-arrow"></i>
                        </button>
                        <div class="ml-4 mt-1 space-y-1 hidden" id="produccion-items">
                            <a href="{{ route('cortes.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('cortes.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-scissors-cut-line text-xs"></i>
                                <span>Cortes</span>
                            </a>
                            <a href="{{ route('costureros.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('costureros.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-user-settings-line text-xs"></i>
                                <span>Costureros</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sección Inventario Colapsable --}}
                    <div class="mobile-section" data-section="inventario">
                        <button class="w-full flex items-center justify-between px-2 py-2 text-left rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleMobileSection('inventario')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-7 h-7 rounded-lg bg-green-100 dark:bg-green-900/20 flex items-center justify-center">
                                    <i class="ri-shirt-line text-xs text-green-600 dark:text-green-400"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-900 dark:text-white">Inventario</span>
                            </div>
                            <i class="ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="inventario-arrow"></i>
                        </button>
                        <div class="ml-4 mt-1 space-y-1 hidden" id="inventario-items">
                            <a href="{{ route('articulos.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('articulos.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-shirt-line text-xs"></i>
                                <span>Artículos</span>
                            </a>
                            <a href="{{ route('categorias.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('categorias.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-price-tag-3-line text-xs"></i>
                                <span>Categorías</span>
                            </a>
                            <a href="{{ route('temporadas.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('temporadas.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-calendar-line text-xs"></i>
                                <span>Temporadas</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sección Análisis Colapsable --}}
                    <div class="mobile-section" data-section="analisis">
                        <button class="w-full flex items-center justify-between px-2 py-2 text-left rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleMobileSection('analisis')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-7 h-7 rounded-lg bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center">
                                    <i class="ri-bar-chart-2-line text-xs text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-900 dark:text-white">Análisis</span>
                            </div>
                            <i class="ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="analisis-arrow"></i>
                        </button>
                        <div class="ml-4 mt-1 space-y-1 hidden" id="analisis-items">
                            <a href="{{ route('dolar.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('dolar.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-money-dollar-circle-line text-xs"></i>
                                <span>Dólar</span>
                            </a>
                            <a href="{{ route('reportes.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('reportes.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-bar-chart-2-line text-xs"></i>
                                <span>Reportes</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sección Administración Móvil --}}
                    @if(auth()->user()->hasRole('administrador'))
                    <div class="mobile-section" data-section="administracion">
                        <button class="w-full flex items-center justify-between px-2 py-2 text-left rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200" 
                                onclick="toggleMobileSection('administracion')">
                            <div class="flex items-center gap-x-2">
                                <div class="w-7 h-7 rounded-lg bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                                    <i class="ri-settings-3-line text-xs text-red-600 dark:text-red-400"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-900 dark:text-white">Administración</span>
                            </div>
                            <i class="ri-arrow-down-s-line text-neutral-500 dark:text-neutral-400 transform transition-transform duration-200" 
                               id="administracion-arrow"></i>
                        </button>
                        <div class="ml-4 mt-1 space-y-1 hidden" id="administracion-items">
                            <a href="{{ route('users.index') }}" 
                               class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 {{ Route::is('users.*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/20' : '' }}">
                                <i class="ri-team-line text-xs"></i>
                                <span>Usuarios</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Cuenta Móvil --}}
                    <a href="{{ route('cuenta.index') }}" 
                       class="flex items-center gap-x-2 px-2 py-2 rounded-lg text-neutral-700 dark:text-neutral-300 transition-all duration-200 {{ Route::is('cuenta.*') ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <div class="w-7 h-7 rounded-lg {{ Route::is('cuenta.*') ? 'bg-primary-500' : 'bg-neutral-100 dark:bg-neutral-800' }} flex items-center justify-center">
                            <i class="ri-user-line text-xs {{ Route::is('cuenta.*') ? 'text-white' : 'text-neutral-600 dark:text-neutral-400' }}"></i>
                        </div>
                        <span class="text-sm font-medium">Mi Cuenta</span>
                    </a>
                </div>
            </div>

            {{-- Separador --}}
            <div class="my-4 border-t border-neutral-200 dark:border-neutral-700"></div>

            {{-- Información del Usuario --}}
            <div class="px-2">
                <div class="bg-neutral-50 dark:bg-neutral-800/50 rounded-lg p-2.5 border border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-x-2">
                        <div class="relative">
                            <img id="navbar-profile-image"
                                 src="{{ \App\Helpers\ImageHelper::getProfileImageUrl(auth()->user()?->profile_image) }}" 
                                 alt="{{ \App\Helpers\ImageHelper::getProfileImageAlt(auth()->user()?->profile_image, auth()->user()?->name ?? 'Usuario') }}" 
                                 class="w-8 h-8 rounded-full object-cover border-2 border-neutral-300 dark:border-neutral-600 {{ \App\Helpers\ImageHelper::getProfileImageClass(auth()->user()?->profile_image) }}">
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-accent-400 rounded-full border-2 border-white dark:border-neutral-800 animate-pulse"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('cuenta.index') }}" class="block hover:opacity-80 transition-opacity duration-200">
                                <p class="text-xs font-medium text-neutral-900 dark:text-white truncate">{{ auth()->user()?->name ?? 'Usuario' }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Administrador</p>
                            </a>
                        </div>
                        <div class="flex-shrink-0">
                            <form action="{{ route('logout') }}" method="post" class="m-0">
                                @csrf
                                <button type="submit" 
                                        class="text-neutral-400 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-200 p-1 rounded hover:bg-neutral-100 dark:hover:bg-neutral-700"
                                        data-tooltip="Cerrar sesión">
                                    <i class="ri-logout-box-r-line text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        {{-- Footer del Sidebar --}}
        <footer class="p-3 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800/30">
            <div class="text-center">
                <p class="text-xs text-neutral-500 dark:text-neutral-400">© 2024 JR2 System</p>
                <p class="text-xs text-neutral-600 dark:text-neutral-500">v2.0.0</p>
            </div>
        </footer>
    </div>

    {{-- Overlay para móviles --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden hidden transition-opacity duration-300" id="sidebar-overlay"></div>

    {{-- Barra superior móvil --}}
    <div class="fixed top-0 left-0 right-0 h-16 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-700 z-50 lg:hidden" id="mobile-header">
        <div class="flex items-center justify-between h-full px-4">
            {{-- Logo y botón toggle --}}
            <div class="flex items-center gap-3">
                <button class="p-2 -ml-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors duration-200"
            id="mobile-toggle"
                        aria-label="Abrir menú">
                    <i class="ri-menu-line text-xl text-neutral-700 dark:text-neutral-300"></i>
    </button>
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                        <span class="text-sm font-bold text-white">JR</span>
                    </div>
                    <span class="font-semibold text-neutral-900 dark:text-white">JR2 System</span>
                </a>
            </div>
            
            {{-- Acciones rápidas móvil --}}
            <div class="flex items-center gap-2">
                {{-- Perfil usuario móvil --}}
                <a href="{{ route('cuenta.index') }}" class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <img src="{{ \App\Helpers\ImageHelper::getProfileImageUrl(auth()->user()?->profile_image) }}" 
                         alt="{{ \App\Helpers\ImageHelper::getProfileImageAlt(auth()->user()?->profile_image, auth()->user()?->name ?? 'Usuario') }}" 
                         class="w-6 h-6 rounded-full object-cover {{ \App\Helpers\ImageHelper::getProfileImageClass(auth()->user()?->profile_image) }}">
                </a>
                
                {{-- Logout móvil --}}
                <form action="{{ route('logout') }}" method="post" class="m-0">
                    @csrf
                    <button type="submit" 
                            class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/20 text-neutral-600 dark:text-neutral-400 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200">
                        <i class="ri-logout-box-r-line text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tooltip Component --}}
    <div class="fixed z-50 px-3 py-2 text-xs text-white bg-neutral-900 dark:bg-neutral-800 rounded-lg shadow-xl border border-neutral-700/50 dark:border-neutral-600/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 font-medium" id="tooltip"></div>
</div>

{{-- JavaScript optimizado para funcionalidad del navbar --}}
<script>
class NavbarManager {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.mobileToggle = document.getElementById('mobile-toggle');
        this.sidebarToggle = document.getElementById('sidebar-toggle');
        this.overlay = document.getElementById('sidebar-overlay');
        this.tooltip = document.getElementById('tooltip');
        this.mobileHeader = document.getElementById('mobile-header');
        this.isOpen = false;
        this.isCollapsed = false;
        this.touchStartX = 0;
        this.touchEndX = 0;
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupResponsive();
        this.setupTooltips();
        this.setupHoverEffects();
        this.setupTouchGestures();
        this.setupMobileOptimizations();
        this.setupCollapsibleSections();
        
        // Forzar cierre del sidebar en móviles al cargar la página
        this.forceMobileSidebarClosed();
    }

    setupEventListeners() {
        // Toggle del sidebar en móviles
        if (this.mobileToggle) {
            this.mobileToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleSidebar();
                this.addRippleEffect(this.mobileToggle, e);
            });
        }
        
        // Toggle del sidebar colapsable en desktop
        if (this.sidebarToggle) {
            this.sidebarToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleSidebarCollapse();
                this.addRippleEffect(this.sidebarToggle, e);
            });
        }
        
        // Funcionalidad de búsqueda
        this.setupSearchFunctionality();
        
        // Cerrar sidebar al hacer click en el overlay
        if (this.overlay) {
            this.overlay.addEventListener('click', () => this.closeSidebar());
        }
        
        // Cerrar sidebar al hacer click en un item (móviles)
        const navItems = document.querySelectorAll('[data-tooltip]');
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    setTimeout(() => this.closeSidebar(), 150);
                }
            });
        });
        
        // Cerrar sidebar cuando se navegue a una nueva página
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && link.href && link.href !== window.location.href && window.innerWidth < 1024) {
                setTimeout(() => this.closeSidebar(), 100);
            }
        });

        // Manejar tecla Escape para cerrar
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeSidebar();
            }
        });
        
        // Cerrar sidebar cuando se use el botón atrás del navegador
        window.addEventListener('popstate', () => {
            if (window.innerWidth < 1024 && this.isOpen) {
                this.closeSidebar();
            }
        });
    }

    setupSearchFunctionality() {
        const searchInput = document.getElementById('nav-search');
        const clearButton = document.getElementById('clear-search');
        const searchResults = document.getElementById('search-results');
        
        if (!searchInput || !clearButton || !searchResults) return;
        
        // Datos de navegación para búsqueda
        this.navItems = [
            { name: 'Dashboard', url: '/', icon: 'ri-dashboard-3-line', section: 'Principal' },
            { name: 'Cortes', url: '{{ route("cortes.index") }}', icon: 'ri-scissors-cut-line', section: 'Producción' },
            { name: 'Costureros', url: '{{ route("costureros.index") }}', icon: 'ri-user-settings-line', section: 'Producción' },
            { name: 'Artículos', url: '{{ route("articulos.index") }}', icon: 'ri-shirt-line', section: 'Inventario' },
            { name: 'Categorías', url: '{{ route("categorias.index") }}', icon: 'ri-price-tag-3-line', section: 'Inventario' },
            { name: 'Temporadas', url: '{{ route("temporadas.index") }}', icon: 'ri-calendar-line', section: 'Inventario' },
            { name: 'Dólar', url: '{{ route("dolar.index") }}', icon: 'ri-money-dollar-circle-line', section: 'Análisis' },
            { name: 'Reportes', url: '{{ route("reportes.index") }}', icon: 'ri-bar-chart-2-line', section: 'Análisis' },
            @if(auth()->user()->hasRole('administrador'))
            { name: 'Usuarios', url: '{{ route("users.index") }}', icon: 'ri-team-line', section: 'Administración' },
            @endif
            { name: 'Mi Cuenta', url: '{{ route("cuenta.index") }}', icon: 'ri-user-line', section: 'Usuario' }
        ];
        
        let searchTimeout;
        
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim().toLowerCase();
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (query.length > 0) {
                    this.performSearch(query);
                    clearButton.classList.remove('hidden');
                    searchResults.classList.remove('hidden');
                } else {
                    this.clearSearch();
                }
            }, 150);
        });
        
        clearButton.addEventListener('click', () => {
            this.clearSearch();
        });
        
        // Cerrar resultados al hacer click fuera
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
        
        // Navegación con teclado
        searchInput.addEventListener('keydown', (e) => {
            const results = searchResults.querySelectorAll('.search-result-item');
            const activeResult = searchResults.querySelector('.search-result-item.active');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (activeResult) {
                    activeResult.classList.remove('active');
                    const next = activeResult.nextElementSibling;
                    if (next) {
                        next.classList.add('active');
                    } else {
                        results[0]?.classList.add('active');
                    }
                } else {
                    results[0]?.classList.add('active');
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (activeResult) {
                    activeResult.classList.remove('active');
                    const prev = activeResult.previousElementSibling;
                    if (prev) {
                        prev.classList.add('active');
                    } else {
                        results[results.length - 1]?.classList.add('active');
                    }
                } else {
                    results[results.length - 1]?.classList.add('active');
                }
            } else if (e.key === 'Enter') {
                e.preventDefault();
                const activeItem = searchResults.querySelector('.search-result-item.active');
                if (activeItem) {
                    const link = activeItem.querySelector('a');
                    if (link) {
                        window.location.href = link.href;
                    }
                }
            } else if (e.key === 'Escape') {
                this.clearSearch();
                searchInput.blur();
            }
        });
    }

    performSearch(query) {
        const searchResults = document.getElementById('search-results');
        const filteredItems = this.navItems.filter(item => 
            item.name.toLowerCase().includes(query) || 
            item.section.toLowerCase().includes(query)
        );
        
        if (filteredItems.length === 0) {
            searchResults.innerHTML = `
                <div class="p-3 text-center text-neutral-500 dark:text-neutral-400">
                    <i class="ri-search-line text-2xl mb-2"></i>
                    <p class="text-sm">No se encontraron resultados</p>
                </div>
            `;
            return;
        }
        
        const resultsHTML = filteredItems.map(item => `
            <div class="search-result-item p-2 hover:bg-neutral-50 dark:hover:bg-neutral-700 cursor-pointer transition-colors duration-200">
                <a href="${item.url}" class="flex items-center gap-x-3 text-sm">
                    <div class="w-8 h-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center">
                        <i class="${item.icon} text-neutral-600 dark:text-neutral-400"></i>
                    </div>
                    <div>
                        <div class="font-medium text-neutral-900 dark:text-white">${item.name}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400">${item.section}</div>
                    </div>
                </a>
            </div>
        `).join('');
        
        searchResults.innerHTML = resultsHTML;
    }

    clearSearch() {
        const searchInput = document.getElementById('nav-search');
        const clearButton = document.getElementById('clear-search');
        const searchResults = document.getElementById('search-results');
        
        if (searchInput) searchInput.value = '';
        if (clearButton) clearButton.classList.add('hidden');
        if (searchResults) searchResults.classList.add('hidden');
    }

    setupCollapsibleSections() {
        // Auto-expandir sección si contiene ruta activa
        const sections = ['produccion', 'inventario', 'analisis', 'administracion'];
        sections.forEach(section => {
            const items = document.getElementById(`${section}-items`);
            if (items) {
                const activeItem = items.querySelector('.text-primary-600, .bg-primary-50');
                if (activeItem) {
                    this.expandNavSection(section);
                }
            }
        });
    }

    toggleSidebarCollapse() {
        this.isCollapsed = !this.isCollapsed;
        
        if (this.isCollapsed) {
            this.sidebar.classList.add('collapsed');
            this.sidebar.setAttribute('data-expanded', 'false');
            this.updateSidebarToggleIcon();
            this.hideNavTexts();
        } else {
            this.sidebar.classList.remove('collapsed');
            this.sidebar.setAttribute('data-expanded', 'true');
            this.updateSidebarToggleIcon();
            this.showNavTexts();
        }
        
        // Guardar preferencia en localStorage
        localStorage.setItem('sidebarCollapsed', this.isCollapsed);
    }

    updateSidebarToggleIcon() {
        if (this.sidebarToggle) {
            const icon = this.sidebarToggle.querySelector('i');
            if (icon) {
                if (this.isCollapsed) {
                    icon.className = 'ri-sidebar-unfold-line text-lg text-neutral-600 dark:text-neutral-400';
                    this.sidebarToggle.setAttribute('data-tooltip', 'Expandir sidebar');
                } else {
                    icon.className = 'ri-sidebar-fold-line text-lg text-neutral-600 dark:text-neutral-400';
                    this.sidebarToggle.setAttribute('data-tooltip', 'Colapsar sidebar');
                }
            }
        }
    }

    hideNavTexts() {
        const navTexts = document.querySelectorAll('.nav-text');
        navTexts.forEach(text => {
            text.style.opacity = '0';
            text.style.transform = 'translateX(-10px)';
        });
        
        // Ocultar secciones colapsables
        const navSections = document.querySelectorAll('.nav-section');
        navSections.forEach(section => {
            const items = section.querySelector('.nav-section-items');
            if (items) {
                items.classList.add('hidden');
            }
        });
    }

    showNavTexts() {
        const navTexts = document.querySelectorAll('.nav-text');
        navTexts.forEach(text => {
            text.style.opacity = '1';
            text.style.transform = 'translateX(0)';
        });
    }

    expandNavSection(sectionName) {
        const items = document.getElementById(`${sectionName}-items`);
        const arrow = document.getElementById(`${sectionName}-arrow`);
        
        if (items && arrow) {
            items.classList.remove('hidden');
            arrow.style.transform = 'rotate(180deg)';
        }
    }

    setupResponsive() {
        // Detectar cambios de tamaño de ventana
        const resizeObserver = new ResizeObserver(() => {
            this.handleResize();
        });
        
        if (this.sidebar) {
            resizeObserver.observe(this.sidebar);
        }
        
        // Inicializar sidebar correctamente según el tamaño de pantalla
        this.handleResize();
        
        // Agregar listener para cambios de orientación en móviles
        window.addEventListener('orientationchange', () => {
            setTimeout(() => this.handleResize(), 100);
        });
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
            item.addEventListener('focus', () => {
                item.style.outline = '2px solid var(--color-primary-500)';
                item.style.outlineOffset = '2px';
            });
            item.addEventListener('blur', () => {
                item.style.outline = 'none';
            });
        });
    }

    toggleSidebar() {
        if (this.isOpen) {
            this.closeSidebar();
        } else {
            this.openSidebar();
        }
        
        this.updateToggleIcon();
    }

    updateToggleIcon() {
        if (this.mobileToggle) {
            const icon = this.mobileToggle.querySelector('i');
            if (icon) {
                if (this.isOpen) {
                    icon.className = 'ri-close-line text-xl text-neutral-700 dark:text-neutral-300';
                    this.mobileToggle.classList.add('active');
                } else {
                    icon.className = 'ri-menu-line text-xl text-neutral-700 dark:text-neutral-300';
                    this.mobileToggle.classList.remove('active');
                }
            }
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
        
        this.updateToggleIcon();
    }

    handleResize() {
        if (window.innerWidth >= 1024) {
            // En desktop, siempre mostrar el sidebar
            this.closeSidebar();
            if (this.sidebar) {
                this.sidebar.classList.remove('-translate-x-full');
                this.sidebar.classList.add('translate-x-0');
            }
            
            // Restaurar estado colapsado si estaba guardado
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                this.isCollapsed = true;
                this.sidebar.classList.add('collapsed');
                this.sidebar.setAttribute('data-expanded', 'false');
                this.updateSidebarToggleIcon();
                this.hideNavTexts();
            }
        } else {
            // En móvil, asegurar que esté cerrado por defecto
            this.isOpen = false;
            if (this.sidebar) {
                this.sidebar.classList.add('-translate-x-full');
                this.sidebar.classList.remove('translate-x-0', 'collapsed');
                this.sidebar.setAttribute('data-expanded', 'true');
            }
            if (this.overlay) {
                this.overlay.classList.add('hidden');
            }
            this.showNavTexts();
        }
    }

    setupTouchGestures() {
        if (window.innerWidth < 1024) {
            document.addEventListener('touchstart', (e) => this.handleTouchStart(e), { passive: true });
            document.addEventListener('touchend', (e) => this.handleTouchEnd(e), { passive: true });
        }
    }

    setupMobileOptimizations() {
        if ('ontouchstart' in window) {
            this.sidebar?.style.setProperty('transform', 'translateZ(0)');
            document.body.style.setProperty('overscroll-behavior-x', 'none');
        }

        if (window.innerWidth < 1024) {
            this.disableTooltipsOnMobile();
        }

        this.setupMobileCollapsibleSections();
    }

    setupMobileCollapsibleSections() {
        const sections = ['produccion', 'inventario', 'analisis', 'administracion'];
        sections.forEach(section => {
            const items = document.getElementById(`${section}-items`);
            if (items) {
                const activeItem = items.querySelector('.text-primary-600, .bg-primary-50');
                if (activeItem) {
                    this.expandMobileSection(section);
                }
            }
        });
    }

    expandMobileSection(sectionName) {
        const items = document.getElementById(`${sectionName}-items`);
        const arrow = document.getElementById(`${sectionName}-arrow`);
        
        if (items && arrow) {
            items.classList.remove('hidden');
            arrow.style.transform = 'rotate(180deg)';
        }
    }

    handleTouchStart(e) {
        this.touchStartX = e.touches[0].clientX;
    }

    handleTouchEnd(e) {
        this.touchEndX = e.changedTouches[0].clientX;
        this.handleSwipeGesture();
    }

    handleSwipeGesture() {
        const swipeThreshold = 50;
        const swipeDistance = this.touchEndX - this.touchStartX;

        if (swipeDistance > swipeThreshold && this.touchStartX < 20 && !this.isOpen) {
            this.openSidebar();
        }
        
        if (swipeDistance < -swipeThreshold && this.isOpen) {
            this.closeSidebar();
        }
    }

    disableTooltipsOnMobile() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.removeAttribute('data-tooltip');
        });
    }

    addRippleEffect(button, event) {
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(99, 102, 241, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.3s ease-out;
            pointer-events: none;
        `;
        
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 300);
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

    updateProfileImage(newImageUrl, newImageAlt = null) {
        const profileImage = document.getElementById('navbar-profile-image');
        if (profileImage) {
            profileImage.src = newImageUrl;
            if (newImageAlt) {
                profileImage.alt = newImageAlt;
            }
            
            profileImage.style.opacity = '0.7';
            setTimeout(() => {
                profileImage.style.opacity = '1';
            }, 200);
        }
    }
    
    updateProfileImageFromHelper(profileImage, userName) {
        if (typeof window.ImageHelper !== 'undefined') {
            const newUrl = window.ImageHelper.getProfileImageUrl(profileImage);
            const newAlt = window.ImageHelper.getProfileImageAlt(profileImage, userName);
            this.updateProfileImage(newUrl, newAlt);
        }
    }
    
    forceMobileSidebarClosed() {
        if (window.innerWidth < 1024) {
            this.isOpen = false;
            if (this.sidebar) {
                this.sidebar.classList.add('-translate-x-full');
                this.sidebar.classList.remove('translate-x-0');
            }
            if (this.overlay) {
                this.overlay.classList.add('hidden');
            }
            this.updateToggleIcon();
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.navbarManager = new NavbarManager();
});

// Hacer disponible globalmente para otras páginas
window.NavbarManager = NavbarManager;

// Función global para alternar secciones de navegación
window.toggleNavSection = function(sectionName) {
    const items = document.getElementById(`${sectionName}-items`);
    const arrow = document.getElementById(`${sectionName}-arrow`);
    
    if (items && arrow) {
        const isHidden = items.classList.contains('hidden');
        
        if (isHidden) {
            // Expandir
            items.classList.remove('hidden');
            arrow.style.transform = 'rotate(180deg)';
            
            // Agregar pequeña animación
            items.style.opacity = '0';
            items.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                items.style.opacity = '1';
                items.style.transform = 'translateY(0)';
                items.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
            }, 10);
        } else {
            // Colapsar
            items.style.opacity = '0';
            items.style.transform = 'translateY(-10px)';
            arrow.style.transform = 'rotate(0deg)';
            
            setTimeout(() => {
                items.classList.add('hidden');
                items.style.opacity = '';
                items.style.transform = '';
                items.style.transition = '';
            }, 200);
        }
    }
};

// Función global para alternar secciones móviles (mantener compatibilidad)
window.toggleMobileSection = window.toggleNavSection;
</script>

{{-- Estilos CSS adicionales para optimizaciones móviles y sidebar colapsable --}}
<style>
@keyframes ripple {
    to {
        transform: scale(2);
        opacity: 0;
    }
}

/* Sidebar colapsable */
#sidebar {
    width: 256px; /* 64 * 4 = 256px */
    transition: width 0.3s ease-in-out;
}

#sidebar.collapsed {
    width: 80px; /* Solo iconos */
}

#sidebar.collapsed .sidebar-text {
    opacity: 0;
    transform: translateX(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

#sidebar.collapsed .nav-text {
    opacity: 0;
    transform: translateX(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

#sidebar.collapsed .nav-section-toggle {
    justify-content: center;
}

#sidebar.collapsed .nav-section-toggle .nav-arrow {
    display: none;
}

#sidebar.collapsed .nav-section-items {
    display: none !important;
}

/* Tooltips para sidebar colapsado */
#sidebar.collapsed .nav-item:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    margin-left: 8px;
    pointer-events: none;
}

#sidebar.collapsed .nav-section-toggle:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    margin-left: 8px;
    pointer-events: none;
}

/* Optimizaciones para dispositivos móviles */
@media (max-width: 1024px) {
    /* Asegurar que el sidebar esté oculto por defecto en móvil */
    #sidebar {
        transform: translateX(-100%) !important;
        width: 256px !important;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    }
    
    /* Solo mostrar cuando esté activo */
    #sidebar.translate-x-0 {
        transform: translateX(0) !important;
    }
    
    /* Prevenir zoom accidental en inputs */
    input, select, textarea {
        font-size: 16px !important;
    }
    
    /* Optimizar transiciones en móvil */
    .transition-all {
        transition-duration: 200ms !important;
    }
    
    /* Mejorar area de toque para elementos pequeños */
    button, a {
        min-height: 44px;
        min-width: 44px;
    }
    
    /* Secciones colapsables móviles */
    .mobile-section button {
        min-height: 40px;
    }
    
    /* Área de scroll optimizada para móvil */
    .lg\\:hidden.overflow-y-auto {
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-y: contain;
    }
    
    /* Padding adicional para evitar corte en pantallas pequeñas */
    .mobile-section:last-child {
        padding-bottom: 20px;
    }
}

/* Animación suave para cambio de icono del toggle */
#mobile-toggle i {
    transition: transform 0.3s ease;
}

#mobile-toggle.active i {
    transform: rotate(90deg);
}

/* Mejorar contraste en modo oscuro para móvil */
@media (prefers-color-scheme: dark) and (max-width: 1024px) {
    #mobile-header {
        background: rgba(23, 23, 23, 0.95);
        backdrop-filter: blur(10px);
    }
}

/* Animaciones de entrada más suaves para móvil */
@media (max-width: 1024px) {
    #sidebar {
        will-change: transform;
    }
    
    #sidebar-overlay {
        will-change: opacity;
    }
}

/* Mejoras para el layout principal cuando el sidebar está colapsado */
@media (min-width: 1024px) {
    main {
        transition: margin-left 0.3s ease-in-out;
    }
    
    #sidebar.collapsed ~ main {
        margin-left: 80px !important;
    }
    
    #sidebar:not(.collapsed) ~ main {
        margin-left: 256px !important;
    }
    
    footer {
        transition: margin-left 0.3s ease-in-out;
    }
    
    #sidebar.collapsed ~ footer {
        margin-left: 80px !important;
    }
    
    #sidebar:not(.collapsed) ~ footer {
        margin-left: 256px !important;
    }
}

/* Animaciones suaves para elementos del navbar */
.nav-item, .nav-section-toggle {
    transition: all 0.2s ease;
}

.nav-item:hover, .nav-section-toggle:hover {
    transform: translateX(2px);
}

/* Mejoras visuales para secciones colapsables */
.nav-section-items {
    transition: all 0.3s ease;
}

.nav-arrow {
    transition: transform 0.3s ease;
}

/* Efectos de hover mejorados */
.nav-item:hover .nav-text,
.nav-section-toggle:hover .nav-text {
    color: var(--color-primary-600);
}

/* Responsive mejorado para pantallas medianas */
@media (min-width: 1024px) and (max-width: 1280px) {
    #sidebar {
        width: 240px;
    }
    
    #sidebar.collapsed {
        width: 72px;
    }
}

/* Estilos para funcionalidad de búsqueda */
.sidebar-search {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

#sidebar.collapsed .sidebar-search {
    opacity: 0;
    transform: translateX(-10px);
    pointer-events: none;
}

#nav-search:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
}

.search-result-item.active {
    background-color: rgba(99, 102, 241, 0.1);
}

.search-result-item:hover {
    background-color: rgba(99, 102, 241, 0.05);
}

/* Mejoras para el scroll de resultados de búsqueda */
#search-results::-webkit-scrollbar {
    width: 4px;
}

#search-results::-webkit-scrollbar-track {
    background: transparent;
}

#search-results::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 2px;
}

#search-results::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
}

/* Animación para mostrar/ocultar búsqueda */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#search-results:not(.hidden) {
    animation: slideDown 0.2s ease-out;
}

/* Mejoras de accesibilidad */
#nav-search::placeholder {
    color: rgba(107, 114, 128, 0.6);
}

#nav-search:focus::placeholder {
    color: rgba(107, 114, 128, 0.4);
}

/* Responsive para búsqueda en móvil */
@media (max-width: 1024px) {
    .sidebar-search {
        display: none;
    }
}
</style>
