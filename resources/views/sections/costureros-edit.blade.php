<?php
    /** @var \App\Models\Costurero $costurero **/
?>
@extends('layout.app')
@section('title', 'Editar Costurero')
@section('content')
    <x-container-wrapp>
        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293a1 1 0 101.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293a1 1 0 00-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm font-medium text-red-800">Por favor corrige los siguientes errores:</p>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header de la sección -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Editar Costurero</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Modifica la información del costurero</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('costureros.show', $costurero) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver Detalles
                    </a>
                    <a href="{{ route('costureros.index') }}" class="inline-flex items-center px-4 py-2 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-300 text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="max-w-2xl">
            <form method="POST" action="{{ route('costureros.update', $costurero) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Nombre Completo -->
                <div>
                    <label for="nombre_completo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nombre_completo"
                        id="nombre_completo"
                        value="{{ old('nombre_completo', $costurero->nombre_completo) }}"
                        class="block w-full p-3 text-sm text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 focus:ring-primary-500 focus:border-primary-500 @error('nombre_completo') border-red-500 @enderror"
                        placeholder="Ingresa el nombre completo del costurero"
                        required
                    />
                    @error('nombre_completo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Celular -->
                <div>
                    <label for="celular" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Número de Celular <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="tel"
                        name="celular"
                        id="celular"
                        value="{{ old('celular', $costurero->celular) }}"
                        class="block w-full p-3 text-sm text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 focus:ring-primary-500 focus:border-primary-500 @error('celular') border-red-500 @enderror"
                        placeholder="Ej: +54 9 11 1234-5678"
                        required
                    />
                    @error('celular')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div>
                    <label for="direccion" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Dirección <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="direccion"
                        id="direccion"
                        rows="4"
                        class="block w-full p-3 text-sm text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 focus:ring-primary-500 focus:border-primary-500 @error('direccion') border-red-500 @enderror"
                        placeholder="Ingresa la dirección completa del costurero"
                        required
                    >{{ old('direccion', $costurero->direccion) }}</textarea>
                    @error('direccion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Información adicional -->
                <div class="bg-neutral-50 dark:bg-neutral-800 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-2">Información del Registro</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-neutral-600 dark:text-neutral-400">ID:</span>
                            <span class="text-neutral-900 dark:text-white ml-2">{{ $costurero->id }}</span>
                        </div>
                        <div>
                            <span class="text-neutral-600 dark:text-neutral-400">Creado:</span>
                            <span class="text-neutral-900 dark:text-white ml-2">{{ $costurero->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-neutral-600 dark:text-neutral-400">Última actualización:</span>
                            <span class="text-neutral-900 dark:text-white ml-2">{{ $costurero->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <a href="{{ route('costureros.index') }}" class="px-6 py-3 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-300 text-sm font-medium rounded-lg transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Costurero
                    </button>
                </div>
            </form>
            
            <!-- Zona de Peligro con Componente de Eliminación -->
            <div class="mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Zona de Peligro</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Una vez que elimines un costurero, no hay vuelta atrás.</p>
                    </div>
                    <x-delete-modal 
                        :route="route('costureros.destroy', $costurero)"
                        title="Eliminar Costurero"
                        trigger-text="Eliminar Costurero"
                        modal-title="Confirmar eliminación"
                        modal-message="¿Estás seguro de que quieres eliminar al costurero '{{ $costurero->nombre_completo }}'?"
                        modal-description="Esta acción no se puede deshacer. Se eliminará permanentemente toda la información del costurero."
                        confirm-text="Sí, eliminar costurero"
                        cancel-text="Cancelar"
                        size="md"
                        variant="danger"
                        icon="ri-delete-bin-line"
                    />
                </div>
            </div>
        </div>
    </x-container-wrapp>
@endsection
