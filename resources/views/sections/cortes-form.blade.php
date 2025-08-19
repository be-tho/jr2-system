@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        {{ isset($corte) ? 'Editar Corte' : 'Nuevo Corte' }}
                    </h1>
                    <p class="text-blue-100 text-lg">
                        {{ isset($corte) ? 'Modifica la información del corte' : 'Crea un nuevo corte de tela' }}
                    </p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="ri-scissors-cut-line text-4xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Información del Corte
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Completa todos los campos requeridos para {{ isset($corte) ? 'actualizar' : 'crear' }} el corte
            </p>
        </div>

        <form action="{{ isset($corte) ? route('cortes.update', $corte->id) : route('cortes.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @if(isset($corte))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre del Corte --}}
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre del Corte <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-scissors-cut-line text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            value="{{ old('nombre', $corte->nombre ?? '') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('nombre') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: Pollera tajo"
                            required
                        >
                    </div>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Descripción
                    </label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        rows="3"
                        class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 resize-vertical @error('descripcion') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Describe las características del corte..."
                    >{{ old('descripcion', $corte->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-checkbox-circle-line text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <select 
                            id="estado" 
                            name="estado" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('estado') border-red-500 dark:border-red-400 @enderror"
                            required
                        >
                            <option value="">Selecciona un estado</option>
                            <option value="cortado" {{ (old('estado', $corte->estado ?? '') == 'cortado') ? 'selected' : '' }}>Cortado</option>
                            <option value="costurando" {{ (old('estado', $corte->estado ?? '') == 'costurando') ? 'selected' : '' }}>Costurando</option>
                            <option value="entregado" {{ (old('estado', $corte->estado ?? '') == 'entregado') ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de Entrega --}}
                <div>
                    <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Fecha de Entrega
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-calendar-line text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <input 
                            type="date" 
                            id="fecha_entrega" 
                            name="fecha_entrega" 
                            value="{{ old('fecha_entrega', isset($corte) ? $corte->fecha_entrega->format('Y-m-d') : '') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('fecha_entrega') border-red-500 dark:border-red-400 @enderror"
                        >
                    </div>
                    @error('fecha_entrega')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="md:col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Imagen del Corte
                    </label>
                    <div class="space-y-4">
                        {{-- Vista previa de imagen actual --}}
                        @if(isset($corte) && $corte->imagen)
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('src/assets/uploads/cortes/' . $corte->imagen) }}" 
                                     alt="Imagen actual" 
                                     class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Imagen actual</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">{{ $corte->imagen }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Input de archivo --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-image-line text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <input 
                                type="file" 
                                id="imagen" 
                                name="imagen" 
                                accept="image/*"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('imagen') border-red-500 dark:border-red-400 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/20 dark:file:text-blue-400"
                            >
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                        </p>
                        @error('imagen')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('cortes.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-blue-500 rounded-lg transition-colors duration-200">
                    <i class="ri-arrow-left-line mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                    <i class="ri-save-line mr-2"></i>
                    {{ isset($corte) ? 'Actualizar Corte' : 'Crear Corte' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
