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
   {{--<link rel="stylesheet" href="{{ asset('build/assets/app-BOC-1fP2.css') }}">--}}
    <title>Jr2 | @yield('title')</title>
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    @if(session('success'))
        <div class="absolute top-0 right-0 z-50">
            <div id="toast" class="flex items-center w-full mx-auto mt-2 max-w-xs p-4 mb-4 text-white bg-green-500 rounded-lg shadow" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg ">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal text-white">{{ session('success') }}.</div>
                <button type="button"
                        id="cerrar"
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
        <div class="absolute top-0 right-0 z-50">
            <div id="toast" class="flex items-center w-full mx-auto mt-2 max-w-xs p-4 mb-4 text-white bg-red-500 rounded-lg shadow" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-gray-700 bg-red-100 rounded-lg ">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal text-white">{{ session('error') }}.</div>
                <button type="button"
                        id="cerrar"
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
    @endif

    <x-navbar/>
    
    <main class="flex-1 w-[calc(100%-256px)] ml-64 main transition-all duration-300">
        <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5">
            <button
                class="text-gray-500 focus:outline-none dark:text-gray-300"
                id="sidebar-toggle"
            >
                <i class="ri-menu-line"></i>
            </button>

            {{--        sidebar --}}
            @auth()
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center ml-2">
                        <a href="/" class="inline-flex items-center text-sm font-medium text-gray-400 {{ Route::is('home.index') ? 'text-gray-700' : '' }} ">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route("cortes.index") }}" class="ms-1 text-sm font-medium text-gray-400 {{ Route::is('cortes.index') ? 'text-gray-700' : '' }}   md:ms-2 ">Cortes</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route("articulos.index") }}" class="ms-1 text-sm font-medium text-gray-400 {{ Route::is('articulos.index') ? 'text-gray-700' : '' }}  md:ms-2 ">Artículos</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route("dolar.index") }}" class="ms-1 text-sm font-medium text-gray-400 {{ Route::is('dolar.index') ? 'text-gray-700' : '' }}  md:ms-2 ">Dolar</a>
                        </div>
                    </li>
                </ol>
            </nav>
            @endauth
            {{--        fin sidebar--}}
            <div class="flex items-center ml-auto gap-4">
                @auth()
                    <img src="{{ asset("./src/assets/images/usuario.jpg") }}" alt="foto del usuario logeado" class="size-8  rounded-full bg-gray-900/5 object-cover shadow-lg" />
                    <form action="{{ route('login.logout') }}" method="post" class=" m-0 lg:flex lg:flex-1 lg:justify-end">
                        @csrf
                        <button class="text-sm font-semibold leading-6 text-gray-900">({{ auth()->user()->name }}) Cerrar sesión</button>
                    </form>
                @endauth
                @guest()
                    <div class=" lg:flex lg:flex-1 lg:justify-end">
                        <a href="{{ route('login.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Iniciar sesión</a>
                    </div>
                @endguest
            </div>
        </div>
        
        <div class="min-h-full pb-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-800 text-white shadow-lg mt-auto">
        <div class="w-full mx-auto max-w-screen-xl p-4 text-center md:flex md:items-center md:justify-between">
            <span class="text-sm text-white sm:text-center dark:text-gray-400">© 2024 <a href="#" class="hover:underline font-semibold">JR2™</a>. Todos los derechos reservados.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-white justify-center text-center md:text-left sm:mt-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6 transition-colors duration-200">Políticas de privacidad</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6 transition-colors duration-200">Licencia</a>
                </li>
                <li>
                    <a href="#" class="hover:underline transition-colors duration-200">Contacto</a>
                </li>
            </ul>
        </div>
    </footer>

<script>
    //cerrar el toast global
    document.addEventListener('DOMContentLoaded', function () {
        var toast = document.getElementById('toast');
        var cerrar = document.getElementById('cerrar');

        //si el toast tiene display block entonces se cierra
        if(toast && toast.display !== 'none') {
            function cerrarToast() {
                toast.style.display = 'none';
            }
            //si y solo si el toast existe
            cerrar.addEventListener('click', cerrarToast);
            setTimeout(cerrarToast, 3000);
        }
     });

    // cuando se haga click en el boton de menu, se despliega el sidebar y se oculta
    document.addEventListener('DOMContentLoaded', function () {
        var sidebarToggle = document.getElementById('sidebar-toggle');
        var sidebar = document.querySelector('.fixed.left-0.top-0.h-full');
        var main = document.querySelector('.main');

        if (sidebarToggle && sidebar && main) {
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
                main.classList.toggle('w-full');
                main.classList.toggle('ml-64');
                main.classList.toggle('transition-all');
                sidebarToggle.classList.toggle('transition-all');
                sidebar.classList.toggle('transition-all');
            });
        }
    });

    //si el dispositivo es menor a 768px entonces el sidebar se oculta
    document.addEventListener('DOMContentLoaded', function () {
        var sidebar = document.querySelector('.fixed.left-0.top-0.h-full');
        var main = document.querySelector('.main');
        var sidebarToggle = document.getElementById('sidebar-toggle');
        
        if(window.innerWidth < 768 && sidebar && main && sidebarToggle) {
            sidebar.classList.add('hidden');
            main.classList.add('w-full');
            main.classList.remove('ml-64');
            main.classList.add('transition-all');
            sidebarToggle.classList.add('transition-all');
            sidebar.classList.add('transition-all');
        }
    });
</script>
{{--<script src="{{ asset('build/assets/app-C1-XIpUa.js') }}"></script>--}}
</body>
</html>
