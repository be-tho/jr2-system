@extends('layout.app')
@section('title', 'Reporte de Cortes')
@section('content')
    <x-container-wrapp>
        <!-- Header con título y botones de acción -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Reporte de Cortes</h1>
                    <p class="text-lg text-gray-600">Estado y progreso de cortes con filtros avanzados</p>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('reportes.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                    

                </div>
            </div>
        </div>

        <!-- Filtros del reporte -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtros del Reporte</h3>
            
            <form method="get" action="{{ route('reportes.cortes') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filtro por estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" id="estado" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="0" {{ ($filters['estado'] ?? '') == '0' ? 'selected' : '' }}>Cortado</option>
                            <option value="1" {{ ($filters['estado'] ?? '') == '1' ? 'selected' : '' }}>Costurando</option>
                            <option value="2" {{ ($filters['estado'] ?? '') == '2' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>

                    <!-- Filtro por fecha desde -->
                    <div>
                        <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Fecha desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" 
                               class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               value="{{ $filters['fecha_desde'] ?? '' }}">
                    </div>

                    <!-- Filtro por fecha hasta -->
                    <div>
                        <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" 
                               class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               value="{{ $filters['fecha_hasta'] ?? '' }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Ordenamiento -->
                    <div>
                        <label for="order_by" class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                        <select name="order_by" id="order_by" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="fecha" {{ ($filters['order_by'] ?? 'fecha') == 'fecha' ? 'selected' : '' }}>Fecha</option>
                            <option value="numero_corte" {{ ($filters['order_by'] ?? '') == 'numero_corte' ? 'selected' : '' }}>Número de Corte</option>
                            <option value="nombre" {{ ($filters['order_by'] ?? '') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                            <option value="estado" {{ ($filters['order_by'] ?? '') == 'estado' ? 'selected' : '' }}>Estado</option>
                        </select>
                    </div>

                    <!-- Dirección del ordenamiento -->
                    <div>
                        <label for="order_direction" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                        <select name="order_direction" id="order_direction" class="block w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="desc" {{ ($filters['order_direction'] ?? 'desc') == 'desc' ? 'selected' : '' }}>Descendente</option>
                            <option value="asc" {{ ($filters['order_direction'] ?? '') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        </select>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Generar Reporte
                    </button>
                    
                    <a href="{{ route('reportes.cortes') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200 flex items-center">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Estadísticas del reporte -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total de cortes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Cortes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_cortes']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Cortes cortados -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Cortados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['cortados']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Cortes costurando -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Costurando</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['costurando']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Cortes entregados -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Entregados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['entregados']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen por estado y mes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Resumen por estado -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen por Estado</h3>
                <div class="space-y-3">
                    @foreach($porEstado as $estado => $data)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-700">{{ $data['estado'] }}</span>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">{{ number_format($data['cantidad']) }} cortes</div>
                            <div class="text-sm text-gray-600">{{ $data['porcentaje'] }}%</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Resumen por mes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen por Mes</h3>
                <div class="space-y-3">
                    @foreach($porMes as $mes => $data)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-700">{{ \Carbon\Carbon::createFromFormat('Y-m', $mes)->format('M Y') }}</span>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">{{ number_format($data['cantidad']) }} cortes</div>
                            <div class="text-sm text-gray-600">{{ number_format($data['total_articulos']) }} artículos</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tabla de cortes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Lista de Cortes</h3>
                <p class="text-sm text-gray-600">Mostrando {{ $cortes->count() }} cortes</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corte</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artículos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colores</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($cortes as $corte)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-lg object-cover mr-3" 
                                         src="{{ \App\Helpers\ImageHelper::getCorteImageUrl($corte->imagen) }}" 
                                         alt="{{ $corte->nombre }}">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">#{{ $corte->numero_corte }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $corte->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($corte->descripcion, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($corte->cantidad) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($corte->articulos, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $corte->fecha ? \Carbon\Carbon::parse($corte->fecha)->format('d/m/Y') : 'No disponible' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($corte->estado == 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Cortado
                                    </span>
                                @elseif($corte->estado == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        Costurando
                                    </span>
                                @elseif($corte->estado == 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Entregado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Desconocido
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($corte->colores, 30) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron cortes con los filtros aplicados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-container-wrapp>
@endsection
