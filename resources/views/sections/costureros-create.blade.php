<?php
    /** @var \App\Models\Costurero $costurero **/
?>
@extends('layout.app')
@section('title', 'Nuevo Costurero')
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
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Nuevo Costurero</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Registra un nuevo costurero en el sistema</p>
                </div>
                <a href="{{ route('costureros.index') }}" class="inline-flex items-center px-4 py-2 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-300 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
            </div>
        </div>

        <!-- Formulario -->
        <div class="max-w-2xl">
            <form method="POST" action="{{ route('costureros.store') }}" class="space-y-6">
                @csrf
                
                <!-- Nombre Completo -->
                <div>
                    <label for="nombre_completo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nombre_completo"
                        id="nombre_completo"
                        value="{{ old('nombre_completo') }}"
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
                        value="{{ old('celular') }}"
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
                    >{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                        Crear Costurero
                    </button>
                </div>
            </form>
        </div>
    </x-container-wrapp>
@endsection
