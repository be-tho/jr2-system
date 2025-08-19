<?php
    /** @var \App\Models\Corte $cortes */
    //    filtrar la informacion de corte por el estado, 0 es cortado, 1 es costurando y 2 es entregado
    $cortesCortado = $cortes->where('estado', 0);
    $cortesCosturando = $cortes->where('estado', 1);
    $cortesEntregado = $cortes->where('estado', 2);
?>
@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Bienvenido a JR2 System</h1>
                    <p class="text-blue-100 text-lg">Sistema de gestión integral para tu negocio</p>
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
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCortes ?? 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Cortes Totales</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalArticulos ?? 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Artículos</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCategorias ?? 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Categorías</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('cortes.create') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="px-6 py-4 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-add-line text-2xl text-white"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nuevo Corte</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Crear un nuevo corte de tela</p>
            </div>
        </a>

        <a href="{{ route('articulos.create') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="px-6 py-4 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-shirt-line text-2xl text-white"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nuevo Artículo</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Agregar artículo al inventario</p>
            </div>
        </a>

        <a href="{{ route('dolar.index') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="px-6 py-4 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-money-dollar-circle-line text-2xl text-white"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Cotización Dólar</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Ver cotización actual</p>
            </div>
        </a>

        <a href="{{ route('reportes.index') }}"  class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="px-6 py-4 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-bar-chart-line text-2xl text-white"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Reportes</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Generar reportes del sistema</p>
            </div>
        </a>
    </div>

    {{-- Sección de estadísticas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Cortes recientes --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="ri-scissors-cut-line text-blue-500 mr-2"></i>
                    Cortes Recientes
                </h3>
            </div>
            <div class="px-6 py-4">
                @if(isset($cortesRecientes) && count($cortesRecientes) > 0)
                    <div class="space-y-3">
                        @foreach($cortesRecientes as $corte)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                    <i class="ri-scissors-cut-line text-blue-600 dark:text-blue-400"></i>
                                </div>
                    <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $corte->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $corte->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('cortes.show', $corte) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="ri-scissors-cut-line text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">No hay cortes recientes</p>
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <a href="{{ route('cortes.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-blue-500 rounded-lg transition-colors duration-200 w-full">
                    Ver todos los cortes
                </a>
                    </div>
                </div>

        {{-- Artículos populares --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="ri-shirt-line text-green-500 mr-2"></i>
                    Artículos Populares
                </h3>
            </div>
            <div class="px-6 py-4">
                @if(isset($articulosPopulares) && count($articulosPopulares) > 0)
                    <div class="space-y-3">
                        @foreach($articulosPopulares as $articulo)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                    <i class="ri-shirt-line text-green-600 dark:text-green-400"></i>
                                </div>
                    <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $articulo->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Stock: {{ $articulo->stock }}</p>
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
                        <i class="ri-shirt-line text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">No hay artículos populares</p>
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <a href="{{ route('articulos.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-blue-500 rounded-lg transition-colors duration-200 w-full">
                    Ver todos los artículos
                </a>
            </div>
        </div>
    </div>

    {{-- Información del sistema --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="ri-information-line text-purple-500 mr-2"></i>
                Información del Sistema
            </h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-server-line text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Versión</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">2.0.0</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-time-line text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Última Actualización</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('d/m/Y') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-user-line text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Usuario</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->name ?? 'Invitado' }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="ri-shield-check-line text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Estado</h4>
                    <p class="text-sm text-green-600 dark:text-green-400">Activo</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
