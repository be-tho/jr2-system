@extends('layout.app')
@section('title', 'Home')
@section('content')
    <x-container-wrapp>
        <section class="pt-14">
            <div class="flex flex-col items-center px-6 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Iniciar sesión
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="{{ route('login.login') }}" method="POST">
                            @csrf
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg
                                    focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
                                    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="email@gmail.com"
                                >
                                @if($errors->has('email'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    autocomplete="current-password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600
                                    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                    dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="********"
                                >
                                @if($errors->has('password'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Iniciar</button>
                            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                Olvidaste la password? <a href="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Recordar</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </x-container-wrapp>
@endsection
