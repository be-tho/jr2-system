<?php
    /** @var \App\Models\User $users **/
?>
@extends('layout.app')
@section('title', 'Gestión de Usuarios')
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

        <!-- Header con título y botón crear -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Gestión de Usuarios</h1>
            <x-buttons.primary href="{{ route('users.create') }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Crear nuevo usuario
            </x-buttons.primary>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Usuarios</p>
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $users->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Activos</p>
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $users->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Último Registro</p>
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $users->first() ? $users->first()->created_at->diffForHumans() : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        @if($users->count() > 0)
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Fecha de Registro
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($users as $user)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors duration-150">
                                <!-- Información del usuario -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                ID: {{ $user->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">{{ $user->email }}</div>
                                </td>

                                <!-- Rol -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->id === auth()->id())
                                        <!-- Mostrar rol actual sin opción de cambio para el usuario actual -->
                                        @if($user->hasRole('administrador'))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Administrador
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                                Usuario
                                            </span>
                                        @endif
                                    @else
                                        <!-- Dropdown para cambiar rol -->
                                        <form method="POST" action="{{ route('users.change-role', $user) }}" class="inline-block" onchange="this.submit()">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border-0 cursor-pointer transition-all duration-200 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $user->hasRole('administrador') ? 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300 focus:ring-red-500 hover:bg-red-200 dark:hover:bg-red-800/30' : 'bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 focus:ring-blue-500 hover:bg-blue-200 dark:hover:bg-blue-800/30' }}">
                                                <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }} class="bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                                                    👤 Usuario
                                                </option>
                                                <option value="administrador" {{ $user->hasRole('administrador') ? 'selected' : '' }} class="bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                                                    👑 Administrador
                                                </option>
                                            </select>
                                        </form>
                                    @endif
                                </td>

                                <!-- Fecha de registro -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ $user->created_at->format('H:i') }}
                                    </div>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <x-buttons.primary href="{{ route('users.show', $user) }}" size="sm">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </x-buttons.primary>
                                        
                                        <x-buttons.outline href="{{ route('users.edit', $user) }}" size="sm">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </x-buttons.outline>
                                        
                                        @if($user->id !== auth()->id())
                                            <x-delete-modal 
                                                :route="route('users.destroy', $user)"
                                                triggerText="Eliminar Usuario"
                                                modalTitle="Eliminar Usuario"
                                                modalMessage="¿Estás seguro de que quieres eliminar este usuario?"
                                                modalDescription="Esta acción eliminará permanentemente el usuario y no se puede deshacer."
                                                confirmText="Sí, eliminar usuario"
                                                cancelText="Cancelar"
                                                size="sm"
                                                variant="danger"
                                                icon="ri-delete-bin-line"
                                                fullWidth="false"
                                                itemName="usuario"
                                                modalId="deleteModal{{ $user->id }}"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if($users->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <!-- Mensaje cuando no hay usuarios -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No hay usuarios registrados</h3>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Comienza creando el primer usuario del sistema.
                </p>
                <div class="mt-6">
                    <x-buttons.primary href="{{ route('users.create') }}">
                        Crear primer usuario
                    </x-buttons.primary>
                </div>
            </div>
        @endif
    </x-container-wrapp>

    <script>
        // Agregar indicador de carga cuando se cambie el rol
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelects = document.querySelectorAll('select[name="role"]');
            
            roleSelects.forEach(select => {
                select.addEventListener('change', function() {
                    // Agregar clase de loading
                    this.style.opacity = '0.6';
                    this.style.pointerEvents = 'none';
                    
                    // Crear indicador de carga
                    const loadingText = document.createElement('span');
                    loadingText.textContent = 'Cambiando...';
                    loadingText.className = 'text-xs text-gray-500 ml-2';
                    loadingText.id = 'loading-' + this.name;
                    
                    this.parentNode.appendChild(loadingText);
                });
            });
        });
    </script>
@endsection
