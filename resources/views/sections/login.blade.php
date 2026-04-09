@extends('layout.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-neutral-subtle dark:bg-neutral-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        {{-- Header del formulario --}}
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg">
                <span class="text-3xl font-bold text-white">JR</span>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-neutral-900 dark:text-white">
                Iniciar Sesión
            </h2>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                Accede a tu cuenta de JR2 System
            </p>
        </div>

        {{-- Formulario --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 p-8">
            <form class="space-y-6" action="{{ route('login.login') }}" method="POST">
                @csrf
                
                {{-- Campo Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-mail-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            value="{{ old('email') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('email') border-red-500 dark:border-red-400 @enderror"
                            placeholder="tu@email.com"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-lock-line text-neutral-400 dark:text-neutral-500"></i>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-primary-400 dark:focus:border-primary-400 transition-colors duration-200 @error('password') border-red-500 dark:border-red-400 @enderror"
                            placeholder="••••••••"
                        >
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opciones adicionales --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember_me" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 dark:border-neutral-600 rounded dark:bg-neutral-700"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-neutral-700 dark:text-neutral-300">
                            Recordarme
                        </label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 transition-colors duration-200">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                {{-- Botón de envío --}}
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="ri-login-box-line text-primary-300 group-hover:text-primary-200 transition-colors duration-200"></i>
                        </span>
                        Iniciar Sesión
                    </button>
                </div>
            </form>

            {{-- Separador --}}
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-neutral-300 dark:border-neutral-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400">
                            ¿Necesitas ayuda?
                        </span>
                    </div>
                </div>
            </div>

            {{-- Enlaces de ayuda --}}
            <div class="mt-6 text-center space-y-2">
                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                    ¿Problemas para acceder?
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 transition-colors duration-200">
                        <i class="ri-customer-service-line mr-1"></i>
                        Soporte
                    </a>
                    <a href="#" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 transition-colors duration-200">
                        <i class="ri-question-line mr-1"></i>
                        Ayuda
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer del formulario --}}
        <div class="text-center">
            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                © 2024 JR2 System. Todos los derechos reservados.
            </p>
            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                Sistema de gestión integral v2.0.0
            </p>
        </div>
    </div>
</div>
@endsection
