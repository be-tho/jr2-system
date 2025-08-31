<?php
    /** @var \App\Models\Costurero $costurero **/
?>
@extends('layout.app')
@section('title', 'Detalles del Costurero')
@section('content')
    <x-container-wrapp>
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

        <!-- Header de la sección -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $costurero->nombre_completo }}</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Detalles del costurero</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('costureros.edit', $costurero) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
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

        <!-- Información principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información del costurero -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-6">Información Personal</h2>
                        
                        <div class="space-y-6">
                            <!-- Nombre Completo -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Nombre Completo</h3>
                                    <p class="mt-1 text-lg text-neutral-900 dark:text-white">{{ $costurero->nombre_completo }}</p>
                                </div>
                            </div>

                            <!-- Celular -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Número de Celular</h3>
                                    <p class="mt-1 text-lg text-neutral-900 dark:text-white">
                                        <a href="tel:{{ $costurero->celular }}" class="text-primary-600 hover:text-primary-700 transition-colors duration-200">
                                            {{ $costurero->celular }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Dirección</h3>
                                    <p class="mt-1 text-lg text-neutral-900 dark:text-white whitespace-pre-line">{{ $costurero->direccion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="space-y-6">
                <!-- Información del registro -->
                <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Información del Registro</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">ID del Costurero</span>
                                <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $costurero->id }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Fecha de Registro</span>
                                <p class="text-sm text-neutral-900 dark:text-white">{{ $costurero->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Última Actualización</span>
                                <p class="text-sm text-neutral-900 dark:text-white">{{ $costurero->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Acciones Rápidas</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('costureros.edit', $costurero) }}" class="w-full flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar Costurero
                            </a>
                            
                            <a href="tel:{{ $costurero->celular }}" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Llamar
                            </a>
                            
                            <x-delete-modal 
                                :route="route('costureros.destroy', $costurero)"
                                title="Eliminar"
                                trigger-text="Eliminar"
                                modal-title="Confirmar eliminación"
                                modal-message="¿Estás seguro de que quieres eliminar al costurero '{{ $costurero->nombre_completo }}'?"
                                modal-description="Esta acción no se puede deshacer. Se eliminará permanentemente toda la información del costurero."
                                confirm-text="Sí, eliminar costurero"
                                cancel-text="Cancelar"
                                size="md"
                                variant="danger"
                                icon="ri-delete-bin-line"
                                :full-width="true"
                                trigger-class="w-full flex items-center justify-center"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación entre costureros -->
        <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    <span class="font-medium">ID:</span> {{ $costurero->id }}
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('costureros.index') }}" class="text-sm text-primary-600 hover:text-primary-700 transition-colors duration-200">
                        ← Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </x-container-wrapp>
@endsection
