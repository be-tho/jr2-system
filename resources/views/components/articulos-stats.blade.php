@props(['articulos'])

@php
    $totalArticulos = $articulos->count();
    $enStock = $articulos->where('stock', '>', 10)->count();
    $stockBajo = $articulos->where('stock', '>', 0)->where('stock', '<=', 10)->count();
    $sinStock = $articulos->where('stock', 0)->count();
    
    $porcentajeEnStock = $totalArticulos > 0 ? round(($enStock / $totalArticulos) * 100) : 0;
    $porcentajeStockBajo = $totalArticulos > 0 ? round(($stockBajo / $totalArticulos) * 100) : 0;
    $porcentajeSinStock = $totalArticulos > 0 ? round(($sinStock / $totalArticulos) * 100) : 0;
    
    $valorTotal = $articulos->sum('precio');
@endphp

<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
    <!-- Total de artículos -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Artículos</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalArticulos }}</p>
            </div>
        </div>
    </div>

    <!-- En stock -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">En Stock</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $enStock }}</p>
                <p class="text-sm text-green-600 dark:text-green-400">{{ $porcentajeEnStock }}%</p>
            </div>
        </div>
    </div>

    <!-- Stock bajo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Stock Bajo</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stockBajo }}</p>
                <p class="text-sm text-yellow-600 dark:text-yellow-400">{{ $porcentajeStockBajo }}%</p>
            </div>
        </div>
    </div>

    <!-- Sin stock -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sin Stock</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $sinStock }}</p>
                <p class="text-sm text-red-600 dark:text-red-400">{{ $porcentajeSinStock }}%</p>
            </div>
        </div>
    </div>

    <!-- Valor total -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Valor Total</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($valorTotal, 0, ',', '.') }}</p>
                <p class="text-sm text-purple-600 dark:text-purple-400">Inventario</p>
            </div>
        </div>
    </div>
</div>
