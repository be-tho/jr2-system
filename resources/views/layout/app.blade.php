<!doctype html>
<html lang="es_ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
        rel="stylesheet"
    />
    @vite('resources/css/app.css')
    <title>Jr2 | @yield('title')</title>
</head>
<body>
    @if(session('success'))
        <div class="absolute top-0 right-0">
            <div id="toast" class="flex items-center w-full mx-auto mt-2 max-w-xs p-4 mb-4 text-white bg-green-500 rounded-lg shadow" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg ">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal text-white">{{ session('success') }}.</div>
                <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center size-8"
                        data-dismiss-target="#toast"
                        aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    @elseif(session('error'))
        <div id="toast" class="flex items-center w-full mx-auto mt-2 max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow " role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ms-3 text-sm font-normal text-red-500">{{ session('error') }}.</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
<x-navbar/>
<main class="w-[calc(100%-256px)] ml-64">
    <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5">
        <button
            class="text-gray-500 focus:outline-none dark:text-gray-300"
            id="sidebar-toggle"
        >
            <i class="ri-menu-line"></i>
        </button>
        <ul class="flex items-center text-sm ml-4">
            <li class="mr2">
                <a href="#" class="text-gray-400 hover:text-gray-600 font-medium mr-2">Home</a>
            </li>
            <li class="mr2">
                <a href="#" class="text-gray-400 hover:text-gray-600 font-medium"></a>
            </li>
        </ul>
        <div class="flex items-center ml-auto gap-4">
            @auth()
                <img src="{{ asset("./src/assets/images/usuario.jpg") }}" alt="foto del usuario logeado" class="size-8  rounded-full bg-gray-900/5 object-cover shadow-lg" />
                <form action="{{ route('login.logout') }}" method="post" class="hidden m-0 lg:flex lg:flex-1 lg:justify-end">
                    @csrf
                    <button class="text-sm font-semibold leading-6 text-gray-900">({{ auth()->user()->name }}) Cerrar sesión</button>
                </form>
            @endauth
            @guest()
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="{{ route('login.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Iniciar sesión</a>
                </div>
            @endguest


        </div>
    </div>
    @yield('content')
</main>
<footer class="bg-white rounded-lg shadow dark:bg-gray-800 fixed left-0 bottom-0 right-0">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://flowbite.com/" class="hover:underline">JR2™</a>. Todos los derechos reservados.
    </span>
        <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
            <li>
                <a href="#" class="hover:underline me-4 md:me-6">Politicas de privacidad</a>
            </li>
            <li>
                <a href="#" class="hover:underline me-4 md:me-6">Licencia</a>
            </li>
            <li>
                <a href="#" class="hover:underline">Contacto</a>
            </li>
        </ul>
    </div>
</footer>
@vite('resources/js/msjalert.js')
</body>
</html>
