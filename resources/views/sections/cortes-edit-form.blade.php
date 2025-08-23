<?php
/** @var \App\Models\Corte $corte */
?>
@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Editar Corte</h1>
                    <p class="text-primary-100 text-lg">Modifica la información del corte existente</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="ri-edit-line text-4xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700">
        <div class="px-6 py-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">
                Información del Corte
            </h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                Actualiza los campos que desees modificar
            </p>
        </div>

        <form action="{{ route('cortes.update', $corte->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Número de Corte --}}
                <div>
                    <label for="numero_corte" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Número de Corte <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-hashtag text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="number" 
                            id="numero_corte" 
                            name="numero_corte" 
                            value="{{ old('numero_corte', $corte->numero_corte) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('numero_corte') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: 001"
                            required
                        >
                    </div>
                    @error('numero_corte')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nombre del Corte --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Nombre del Corte <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-scissors-cut-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            value="{{ old('nombre', $corte->nombre) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('nombre') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: Pollera tajo"
                            required
                        >
                    </div>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Colores --}}
                <div>
                    <label for="colores" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Colores <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-palette-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="colores" 
                            name="colores" 
                            value="{{ old('colores', $corte->colores) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('colores') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: Azul, Rojo, Verde"
                            required
                        >
                    </div>
                    @error('colores')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cantidad --}}
                <div>
                    <label for="cantidad" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-stack-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="number" 
                            id="cantidad" 
                            name="cantidad" 
                            value="{{ old('cantidad', $corte->cantidad) }}"
                            min="1"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('cantidad') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Cantidad a producir"
                            required
                        >
                    </div>
                    @error('cantidad')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Artículos --}}
                <div>
                    <label for="articulos" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Artículos <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-shirt-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="articulos" 
                            name="articulos" 
                            value="{{ old('articulos', $corte->articulos) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('articulos') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: Polleras, Pantalones"
                            required
                        >
                    </div>
                    @error('articulos')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Costureros --}}
                <div>
                    <label for="costureros" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Costureros <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-user-settings-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="costureros" 
                            name="costureros" 
                            value="{{ old('costureros', $corte->costureros) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('costureros') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: María, Juan"
                            required
                        >
                    </div>
                    @error('costureros')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label for="estado" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-checkbox-circle-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <select 
                            id="estado" 
                            name="estado" 
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('estado') border-red-500 dark:border-red-400 @enderror"
                            required
                        >
                            <option value="">Selecciona un estado</option>
                            <option value="0" {{ (old('estado', $corte->estado) == '0') ? 'selected' : '' }}>Cortado</option>
                            <option value="1" {{ (old('estado', $corte->estado) == '1') ? 'selected' : '' }}>Costurando</option>
                            <option value="2" {{ (old('estado', $corte->estado) == '2') ? 'selected' : '' }}>Recibido</option>
                        </select>
                    </div>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="fecha" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-calendar-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="date" 
                            id="fecha" 
                            name="fecha" 
                            value="{{ old('fecha', $corte->fecha) }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('fecha') border-red-500 dark:border-red-400 @enderror"
                            required
                        >
                    </div>
                    @error('fecha')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Descripción
                    </label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        rows="3"
                        class="block w-full px-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 resize-vertical @error('descripcion') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Describe las características del corte..."
                    >{{ old('descripcion', $corte->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="md:col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Imagen del Corte
                    </label>
                    <div class="space-y-4">
                        {{-- Vista previa de imagen actual --}}
                        @if($corte->imagen)
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('src/assets/uploads/cortes/' . $corte->imagen) }}" 
                                     alt="Imagen actual" 
                                     class="w-20 h-20 object-cover rounded-lg border border-neutral-200 dark:border-neutral-600">
                                <div>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Imagen actual</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-500">{{ $corte->imagen }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Input de archivo --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-image-line text-neutral-400 dark:text-neutral-500"></i>
                            </div>
                            <input 
                                type="file" 
                                id="imagen" 
                                name="imagen" 
                                accept="image/*"
                                class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('imagen') border-red-500 dark:border-red-400 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400"
                            >
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                        </p>
                        @error('imagen')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center justify-between pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <a href="{{ route('cortes.show', $corte) }}" 
                   class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:ring-primary-500 rounded-lg transition-colors duration-200">
                    <i class="ri-arrow-left-line mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                    <i class="ri-save-line mr-2"></i>
                    Actualizar Corte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
