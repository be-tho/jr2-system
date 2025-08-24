@extends('layout.app')
@section('title', 'Editar Categoría')
@section('content')
    <x-container-wrapp>
        <!-- Header de la página -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('categorias.index') }}" 
                   class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 mr-4 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Editar Categoría</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Modifica la información de la categoría "{{ $categoria->nombre }}"</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="max-w-2xl">
            <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Información de la Categoría</h3>
                </div>
                
                <form action="{{ route('categorias.update', $categoria) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Campo Nombre -->
                    <div class="mb-6">
                        <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Nombre de la Categoría <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               value="{{ old('nombre', $categoria->nombre) }}"
                               class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white @error('nombre') border-red-300 dark:border-red-600 @enderror"
                               placeholder="Ej: Ropa de Verano, Accesorios, etc."
                               required>
                        
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        
                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                            El nombre debe ser descriptivo y fácil de entender para los usuarios.
                        </p>
                    </div>

                    <!-- Información de la categoría -->
                    <div class="mb-6 p-4 bg-neutral-50 dark:bg-neutral-700 rounded-lg">
                        <h4 class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Información del Sistema</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">ID:</span>
                                <span class="ml-2 font-medium text-neutral-900 dark:text-white">#{{ $categoria->id }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Creada:</span>
                                <span class="ml-2 font-medium text-neutral-900 dark:text-white">{{ $categoria->formatted_created_at }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Última actualización:</span>
                                <span class="ml-2 font-medium text-neutral-900 dark:text-white">{{ $categoria->formatted_updated_at }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                        <a href="{{ route('categorias.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Actualizar Categoría
                        </button>
                    </div>
                </form>
            </div>

            <!-- Advertencia -->
            <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Importante
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Al cambiar el nombre de una categoría, todos los artículos asociados se actualizarán automáticamente. Asegúrate de que el nuevo nombre sea apropiado para todos los productos de esta categoría.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container-wrapp>
@endsection
