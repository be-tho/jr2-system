@extends('layout.app')
@section('title', 'Editar Usuario')
@section('content')
    <x-container-wrapp>
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-800 dark:text-white">Editar Usuario</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Modificar información del usuario</p>
                </div>
                <x-buttons.secondary href="{{ route('users.index') }}">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </x-buttons.secondary>
            </div>
        </div>

        <!-- Formulario -->
        <div class="max-w-2xl">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Información del Usuario</h3>
                </div>
                
                <form method="POST" action="{{ route('users.update', $user) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                            placeholder="Ingresa el nombre completo"
                            required
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Correo electrónico <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                            placeholder="usuario@ejemplo.com"
                            required
                        />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Nueva contraseña <span class="text-gray-500">(opcional)</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror"
                            placeholder="Deja vacío para mantener la actual"
                        />
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Confirmar nueva contraseña <span class="text-gray-500">(opcional)</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Repite la nueva contraseña"
                        />
                    </div>

                    <!-- Rol -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Rol del usuario <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="role"
                            id="role"
                            class="block w-full p-3 text-sm border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('role') border-red-500 @enderror"
                            required
                        >
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Información del usuario -->
                    <div class="bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200">Información del usuario</h4>
                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    <ul class="space-y-1">
                                        <li><strong>ID:</strong> {{ $user->id }}</li>
                                        <li><strong>Rol:</strong> {{ $user->roles->pluck('name')->implode(', ') }}</li>
                                        <li><strong>Fecha de registro:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
                                        <li><strong>Última actualización:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Notas importantes</h4>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Si dejas la contraseña vacía, se mantendrá la actual</li>
                                        <li>La nueva contraseña debe tener al menos 8 caracteres</li>
                                        <li>El email debe ser único en el sistema</li>
                                        <li>Los cambios se aplicarán inmediatamente</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-3 pt-4">
                        <x-buttons.primary type="submit">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Actualizar usuario
                        </x-buttons.primary>
                        
                        <x-buttons.secondary href="{{ route('users.index') }}">
                            Cancelar
                        </x-buttons.secondary>
                    </div>
                </form>
            </div>
        </div>
    </x-container-wrapp>
@endsection
