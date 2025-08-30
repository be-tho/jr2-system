@extends('layout.app')
@section('title', isset($corte) ? 'Editar Corte' : 'Crear Corte')
@section('content')
<x-container-wrapp>
    <div class="space-y-6">
    {{-- Header de la página --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        {{ isset($corte) ? 'Editar Corte' : 'Nuevo Corte' }}
                    </h1>
                    <p class="text-primary-100 text-lg">
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
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700">
        <div class="px-6 py-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">
                Información del Corte
            </h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                Completa todos los campos requeridos para {{ isset($corte) ? 'actualizar' : 'crear' }} el corte
            </p>
        </div>

        <form action="{{ isset($corte) ? route('cortes.update', $corte->id) : route('cortes.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @if(isset($corte))
                @method('PUT')
            @endif

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
                            value="{{ old('numero_corte', isset($corte) ? $corte->numero_corte : '') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('numero_corte') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: 001"
                            required
                        >
                    </div>
                    @error('numero_corte')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo de Tela --}}
                <div>
                    <label for="tipo_tela" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Tipo de Tela <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-scissors-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="text" 
                            id="tipo_tela" 
                            name="tipo_tela" 
                            value="{{ old('tipo_tela', isset($corte) ? $corte->tipo_tela : '') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('tipo_tela') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: Algodón, Poliéster, Lino"
                            required
                        >
                    </div>
                    @error('tipo_tela')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cantidad Total --}}
                <div>
                    <label for="cantidad_total" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Cantidad Total <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-stack-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            type="number" 
                            id="cantidad_total" 
                            name="cantidad_total" 
                            value="{{ old('cantidad_total', isset($corte) ? $corte->cantidad_total : '') }}"
                            min="1"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('cantidad_total') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Ej: 100"
                            required
                        >
                    </div>
                    @error('cantidad_total')
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
                            value="{{ old('articulos', isset($corte) ? $corte->articulos : '') }}"
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
                            value="{{ old('costureros', isset($corte) ? $corte->costureros : '') }}"
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
                            <option value="0" {{ (old('estado', isset($corte) ? $corte->estado : '') == '0') ? 'selected' : '' }}>Cortado</option>
                            <option value="1" {{ (old('estado', isset($corte) ? $corte->estado : '') == '1') ? 'selected' : '' }}>Costurando</option>
                            <option value="2" {{ (old('estado', isset($corte) ? $corte->estado : '') == '2') ? 'selected' : '' }}>Entregado</option>
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
                            value="{{ old('fecha', isset($corte) ? $corte->fecha : '') }}"
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
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        rows="3"
                        class="block w-full px-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 resize-vertical @error('descripcion') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Describe las características del corte..."
                        required
                    >{{ old('descripcion', isset($corte) ? $corte->descripcion : '') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Colores JSON --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Colores con Cantidades <span class="text-red-500">*</span>
                    </label>
                    <div id="colores-container" class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    name="colores[color][]" 
                                    placeholder="Color (ej: rojo)"
                                    class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200"
                                >
                            </div>
                            <div class="w-24">
                                <input 
                                    type="number" 
                                    name="colores[cantidad][]" 
                                    placeholder="Cantidad"
                                    min="1"
                                    class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200"
                                >
                            </div>
                            <button type="button" onclick="removeColor(this)" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addColor()" class="mt-3 inline-flex items-center px-3 py-2 border border-primary-300 dark:border-primary-600 rounded-lg text-sm font-medium text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 hover:bg-primary-100 dark:hover:bg-primary-900/30 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                        <i class="ri-add-line mr-2"></i>
                        Agregar Color
                    </button>
                    @error('colores')
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
                        @if(isset($corte) && $corte->imagen)
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('src/assets/uploads/cortes/' . $corte->imagen) }}" 
                                     alt="Imagen actual" 
                                     class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
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
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 8MB
                        </p>
                        @error('imagen')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center justify-between pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <x-buttons.secondary href="{{ route('cortes.index') }}">
                    <i class="ri-arrow-left-line mr-2"></i>
                    Cancelar
                </x-buttons.secondary>
                
                <x-buttons.primary type="submit" size="lg">
                    <i class="ri-save-line mr-2"></i>
                    {{ isset($corte) ? 'Actualizar Corte' : 'Crear Corte' }}
                </x-buttons.primary>
            </div>
        </form>
    </div>
</x-container-wrapp>

<script>
function addColor() {
    const container = document.getElementById('colores-container');
    const colorDiv = document.createElement('div');
    colorDiv.className = 'flex items-center space-x-3';
    colorDiv.innerHTML = `
        <div class="flex-1">
            <input 
                type="text" 
                name="colores[color][]" 
                placeholder="Color (ej: rojo)"
                class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200"
            >
        </div>
        <div class="w-24">
            <input 
                type="number" 
                name="colores[cantidad][]" 
                placeholder="Cantidad"
                min="1"
                class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200"
            >
        </div>
        <button type="button" onclick="removeColor(this)" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
            <i class="ri-delete-bin-line text-lg"></i>
        </button>
    `;
    container.appendChild(colorDiv);
}

function removeColor(button) {
    button.closest('div').remove();
}

// Cargar colores existentes si estamos editando
@if(isset($corte) && $corte->colores)
    document.addEventListener('DOMContentLoaded', function() {
        const colores = @json($corte->colores);
        const container = document.getElementById('colores-container');
        
        // Limpiar el primer color por defecto
        container.innerHTML = '';
        
        // Agregar cada color existente
        Object.entries(colores).forEach(([color, cantidad]) => {
            const colorDiv = document.createElement('div');
            colorDiv.className = 'flex items-center space-x-3';
            colorDiv.innerHTML = `
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="colores[color][]" 
                        value="${color}"
                        placeholder="Color (ej: rojo)"
                        class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200"
                    >
                </div>
                <div class="w-24">
                    <input 
                        type="number" 
                        name="colores[cantidad][]" 
                        value="${cantidad}"
                        placeholder="Cantidad"
                        min="1"
                        class="block w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200"
                    >
                </div>
                <button type="button" onclick="removeColor(this)" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                    <i class="ri-delete-bin-line text-lg"></i>
                </button>
            `;
            container.appendChild(colorDiv);
        });
    });
@endif
</script>
@endsection
