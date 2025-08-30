@extends('layout.app')
@section('title', 'Detalles del Usuario')
@section('content')
    <x-container-wrapp>
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Detalles del Usuario</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Información completa del usuario</p>
                </div>
                <div class="flex gap-3">
                    <x-buttons.outline href="{{ route('users.edit', $user) }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </x-buttons.outline>
                    <x-buttons.secondary href="{{ route('users.index') }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </x-buttons.secondary>
                </div>
            </div>
        </div>

        <!-- Información del usuario -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información principal -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Información Personal</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Avatar y nombre -->
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $user->name }}</h2>
                                <p class="text-neutral-600 dark:text-neutral-400">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Detalles -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">
                                    Información Básica
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">ID:</span>
                                        <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $user->id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nombre:</span>
                                        <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $user->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Email:</span>
                                        <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">
                                    Roles y Permisos
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Rol:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 ml-2">
                                            {{ $user->roles->pluck('name')->implode(', ') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Permisos:</span>
                                        <div class="mt-1 flex flex-wrap gap-1">
                                            @foreach($user->getAllPermissions() as $permission)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">
                                    Fechas
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Registrado:</span>
                                        <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Última actualización:</span>
                                        <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">
                                    Estado
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Estado:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 ml-2">
                                            Activo
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Tiempo en el sistema:</span>
                                        <span class="text-sm text-neutral-900 dark:text-white ml-2">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="space-y-6">
                <!-- Acciones rápidas -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Acciones</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <x-buttons.outline href="{{ route('users.edit', $user) }}" class="w-full">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar usuario
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
                                variant="danger"
                                icon="ri-delete-bin-line"
                                fullWidth="true"
                                itemName="usuario"
                                modalId="deleteModal{{ $user->id }}"
                            />
                        @else
                            <div class="text-center py-2">
                                <span class="text-sm text-neutral-500 dark:text-neutral-400">No puedes eliminar tu propia cuenta</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Información Adicional</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Tipo de cuenta:</span>
                            <span class="text-sm text-neutral-900 dark:text-white ml-2">Usuario regular</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Acceso:</span>
                            <span class="text-sm text-neutral-900 dark:text-white ml-2">Solo lectura</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Puede:</span>
                            <ul class="mt-1 text-sm text-neutral-600 dark:text-neutral-400 space-y-1">
                                <li>• Ver artículos</li>
                                <li>• Ver cortes</li>
                                <li>• Ver reportes</li>
                                <li>• Ver categorías</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container-wrapp>
@endsection
