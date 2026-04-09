@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="bg-primary-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Bienvenido a JR2 System</h1>
                    <p class="text-primary-100 text-lg">Sistema de gestión integral para tu negocio</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="ri-dashboard-3-line text-4xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $totalCortes ?? 0 }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Cortes Totales</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $totalArticulos ?? 0 }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Artículos</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $totalCategorias ?? 0 }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Categorías</div>
                </div>
            </div>
        </div>
    </div>

        {{-- Acciones rápidas --}}
    @if(auth()->user()->hasRole('administrador'))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('cortes.create') }}" class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="px-6 py-4 text-center">
                    <div class="w-16 h-16 bg-primary-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="ri-add-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Nuevo Corte</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm">Crear un nuevo corte de tela</p>
                </div>
            </a>

            <a href="{{ route('articulos.create') }}" class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="px-6 py-4 text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="ri-shirt-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Nuevo Artículo</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm">Agregar artículo al inventario</p>
                </div>
            </a>

            <a href="{{ route('dolar.index') }}" class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="px-6 py-4 text-center">
                    <div class="w-16 h-16 bg-accent-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="ri-money-dollar-circle-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Cotización Dólar</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm">Ver cotización actual</p>
                </div>
            </a>

            <a href="{{ route('reportes.index') }}"  class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="px-6 py-4 text-center">
                    <div class="w-16 h-16 bg-secondary-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="ri-bar-chart-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Reportes</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm">Generar reportes del sistema</p>
                </div>
            </a>
        </div>
    @else
        {{-- Mensaje informativo para usuarios de solo lectura --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <i class="ri-information-line text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-2">
                        Modo Solo Lectura
                    </h3>
                    <p class="text-blue-800 dark:text-blue-200 text-sm leading-relaxed">
                        Como usuario con permisos de solo lectura, puedes ver toda la información del sistema, 
                        incluyendo artículos, cortes, categorías y reportes. Para realizar cambios o crear 
                        nuevo contenido, contacta a un administrador del sistema.
                    </p>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="ri-eye-line text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <p class="text-xs text-blue-700 dark:text-blue-300">Ver Contenido</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="ri-search-line text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <p class="text-xs text-blue-700 dark:text-blue-300">Buscar y Filtrar</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="ri-bar-chart-line text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <p class="text-xs text-blue-700 dark:text-blue-300">Ver Reportes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Sección de estadísticas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Cortes recientes --}}
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white flex items-center">
                    <i class="ri-scissors-cut-line text-primary-500 mr-2"></i>
                    Cortes Recientes
                </h3>
            </div>
            <div class="px-6 py-4">
                @if(isset($cortes) && count($cortes) > 0)
                    <div class="space-y-3">
                        @foreach($cortes as $corte)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center">
                                    <i class="ri-scissors-cut-line text-primary-600 dark:text-primary-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $corte->nombre }}</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $corte->formatted_created_at }}</p>
                                </div>
                            </div>
                            <a href="{{ route('cortes.show', $corte) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 text-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="ri-scissors-cut-line text-4xl text-neutral-300 dark:text-neutral-600 mb-3"></i>
                        <p class="text-neutral-500 dark:text-neutral-400">No hay cortes recientes</p>
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700/50">
                <x-buttons.primary href="{{ route('cortes.index') }}" class="w-full">
                    Ver todos los cortes
                </x-buttons.primary>
            </div>
        </div>

        {{-- Artículos populares --}}
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white flex items-center">
                    <i class="ri-shirt-line text-green-500 mr-2"></i>
                    Artículos Populares
                </h3>
            </div>
            <div class="px-6 py-4">
                @if(isset($articulosPopulares) && count($articulosPopulares) > 0)
                    <div class="space-y-3">
                        @foreach($articulosPopulares as $articulo)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                    <i class="ri-shirt-line text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $articulo->nombre }}</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400">Stock: {{ $articulo->stock }}</p>
                                </div>
                            </div>
                            <a href="{{ route('articulos.show', $articulo) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="ri-shirt-line text-4xl text-neutral-300 dark:text-neutral-600 mb-3"></i>
                        <p class="text-neutral-500 dark:text-neutral-400">No hay artículos populares</p>
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700/50">
                <x-buttons.primary href="{{ route('articulos.index') }}" class="w-full">
                    Ver todos los artículos
                </x-buttons.primary>
            </div>
        </div>
    </div>

    {{-- Información del sistema --}}
    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white flex items-center">
                <i class="ri-information-line text-secondary-500 mr-2"></i>
                Información del Sistema
            </h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-server-line text-primary-600 dark:text-primary-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-neutral-900 dark:text-white mb-1">Versión</h4>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">2.0.0</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-time-line text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-neutral-900 dark:text-white mb-1">Última Actualización</h4>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ now()->format('d/m/Y') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-100 dark:bg-accent-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-user-line text-accent-600 dark:text-accent-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-neutral-900 dark:text-white mb-1">Usuario</h4>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ auth()->user()->name ?? 'Invitado' }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-secondary-100 dark:bg-secondary-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-shield-check-line text-secondary-600 dark:text-secondary-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-neutral-900 dark:text-white mb-1">Rol</h4>
                    @if(auth()->user()->hasRole('administrador'))
                        <p class="text-sm text-green-600 dark:text-green-400 font-medium">Administrador</p>
                    @else
                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Usuario</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
