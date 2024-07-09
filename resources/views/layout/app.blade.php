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
<x-navbar/>
<main class="w-[calc(100%-256px)] ml-64">
    <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5">
        <button class="text-gray-500 focus:outline-none dark:text-gray-300">
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
                <img src="http://placehold.co/40x40" alt="" class="size-10 rounded object-cover">
            <a href="#">
                <span class="text-md font-normal text-gray-600">Cerrar sesion</span>
            </a>

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
</body>
</html>
