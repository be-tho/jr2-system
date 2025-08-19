@extends('layout.app')
@section('title', 'Cotización del Dólar')
@section('content')
    <x-container-wrapp>
        <!-- Header con título y botón de actualización -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Cotización del Dólar</h1>
                    <p class="text-lg text-gray-600">Información actualizada de las diferentes cotizaciones del dólar en Argentina</p>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="refreshRates()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Actualizar
                    </button>
                    
                    <button onclick="window.print()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Imprimir
                    </button>
                </div>
            </div>
        </div>

        <!-- Mensajes de notificación -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293a1 1 0 101.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293a1 1 0 00-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Grid principal de cotizaciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Dólar Oficial -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-white">Dólar Oficial</h2>
                                <p class="text-sm text-blue-100">Banco Central</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Oficial
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-4xl font-bold text-white mb-2">${{ number_format($dolarOficial, 2, ',', '.') }}</p>
                        <p class="text-sm text-blue-100">Peso Argentino</p>
                    </div>
                </div>
                
                <div class="bg-blue-800 px-6 py-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-blue-200">Última actualización:</span>
                        <span class="text-white font-medium">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Dólar Blue -->
            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg border border-green-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-white">Dólar Blue</h2>
                                <p class="text-sm text-green-100">Mercado Paralelo</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"></path>
                                </svg>
                                Informal
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-4xl font-bold text-white mb-2">${{ number_format($dolarBlue, 2, ',', '.') }}</p>
                        <p class="text-sm text-green-100">Peso Argentino</p>
                    </div>
                </div>
                
                <div class="bg-green-800 px-6 py-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-green-200">Diferencia con oficial:</span>
                        @php
                            $diferenciaBlue = $dolarBlue - $dolarOficial;
                            $porcentajeBlue = $dolarOficial > 0 ? (($diferenciaBlue / $dolarOficial) * 100) : 0;
                        @endphp
                        <span class="text-white font-medium">+{{ number_format($porcentajeBlue, 1) }}%</span>
                    </div>
                </div>
            </div>

            <!-- Dólar Intermedio -->
            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl shadow-lg border border-purple-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-white">Dólar Intermedio</h2>
                                <p class="text-sm text-purple-100">Mercado Financiero</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Financiero
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-4xl font-bold text-white mb-2">${{ number_format($dolarIntermedio, 2, ',', '.') }}</p>
                        <p class="text-sm text-purple-100">Peso Argentino</p>
                    </div>
                </div>
                
                <div class="bg-purple-800 px-6 py-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-purple-200">Diferencia con oficial:</span>
                        @php
                            $diferenciaIntermedio = $dolarIntermedio - $dolarOficial;
                            $porcentajeIntermedio = $dolarOficial > 0 ? (($diferenciaIntermedio / $dolarOficial) * 100) : 0;
                        @endphp
                        <span class="text-white font-medium">+{{ number_format($porcentajeIntermedio, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de estadísticas y comparaciones -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Comparación de cotizaciones -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Comparación de Cotizaciones
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700">Brecha Blue vs Oficial:</span>
                        <span class="font-semibold text-green-600">+{{ number_format($diferenciaBlue, 2, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700">Brecha Intermedio vs Oficial:</span>
                        <span class="font-semibold text-purple-600">+{{ number_format($diferenciaIntermedio, 2, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700">Diferencia Blue vs Intermedio:</span>
                        @php
                            $diferenciaBlueIntermedio = $dolarBlue - $dolarIntermedio;
                        @endphp
                        <span class="font-semibold {{ $diferenciaBlueIntermedio >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $diferenciaBlueIntermedio >= 0 ? '+' : '' }}{{ number_format($diferenciaBlueIntermedio, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Información del Mercado
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Datos actualizados en tiempo real</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Cotizaciones del Banco Central</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Mercado paralelo y financiero</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Cálculo automático de brechas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer informativo -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="text-center">
                <h4 class="text-lg font-semibold text-blue-900 mb-2">¿Necesitas más información?</h4>
                <p class="text-blue-700 mb-4">
                    Las cotizaciones se actualizan automáticamente. Para obtener información más detallada, 
                    consulta directamente con tu entidad financiera.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="https://www.bcra.gob.ar/" target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Banco Central
                    </a>
                    
                    <a href="https://www.ambito.com/contenidos/dolar.html" target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Más Cotizaciones
                    </a>
                </div>
            </div>
        </div>

        <script>
        function refreshRates() {
            // Mostrar indicador de carga
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = `
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Actualizando...
            `;
            button.disabled = true;
            
            // Recargar la página después de un breve delay
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
        </script>
    </x-container-wrapp>
@endsection
