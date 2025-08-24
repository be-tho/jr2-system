@extends('layout.app')
@section('title', 'Nueva Temporada')
@section('content')
    <x-container-wrapp>
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('temporadas.index') }}" 
                   class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 mr-4 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Nueva Temporada</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Crea una nueva temporada para organizar tus productos por época del año</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="max-w-2xl">
            <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Información de la Temporada</h3>
                </div>
                
                <form action="{{ route('temporadas.store') }}" method="POST" class="p-6">
                    @csrf
                    
                    <!-- Campo Nombre -->
                    <div class="mb-6">
                        <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Nombre de la Temporada <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               value="{{ old('nombre') }}"
                               class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white @error('nombre') border-red-300 dark:border-red-600 @enderror"
                               placeholder="Ej: Primavera/Verano 2024, Otoño/Invierno 2024, etc."
                               required>
                        
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        
                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                            El nombre debe ser descriptivo y fácil de entender para los usuarios.
                        </p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                        <a href="{{ route('temporadas.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Temporada
                        </button>
                    </div>
                </form>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Consejos para crear temporadas efectivas
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Usa nombres estándar de la industria (Primavera/Verano, Otoño/Invierno)</li>
                                <li>Incluye el año para mejor organización</li>
                                <li>Considera las temporadas específicas de tu mercado</li>
                                <li>Mantén consistencia en el formato de nomenclatura</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container-wrapp>
@endsection
