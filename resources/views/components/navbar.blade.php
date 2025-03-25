<div>
{{--    component navbar--}}
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 ">
        <header class=" text-white p-4">
            <a href="#" class="flex items-center gap-x-4 pb-4 border-b border-b-gray-600">
                <img src="http://placehold.co/40x40" alt="" class="size-10 rounded object-cover">
                <span class="text-lg font-bold text-gray-200"> JR2</span>
            </a>
            @auth()
                <nav class="flex items-center">
                    <ul class="sidebar-menu mt-4 w-full">
                        <li class="mb-1 group {{ Route::is('home.index') ? 'active':''}}">
                            <a href="/" class="flex items-center py-2 px-4 gap-x-2 hover:bg-gray-950 hover:text-gray-200 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white">
                                <i class="ri-home-2-line"></i>
                                <span class="text-sm">Dashboard</span>
                            </a>
                        </li>
                        <li class="mb-1 group {{ Route::is('cortes.index') ? 'active' : '' }}">
                            <a href="{{ route("cortes.index") }}" class="flex items-center py-2 px-4 gap-x-2 hover:bg-gray-950 hover:text-gray-200 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white">
                                <i class="ri-stack-overflow-line"></i>
                                <span class="text-sm">Cortes</span>
                            </a>
                        </li>
                        <li class="mb-1 group {{ Route::is('articulos.index') ? 'active' : '' }}">
                            <a href="{{ route("articulos.index") }}" class="flex items-center py-2 px-4 gap-x-2 hover:bg-gray-950 hover:text-gray-200 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white">
                                <i class="ri-t-shirt-2-line"></i>
                                <span class="text-sm">Artículos</span>
                            </a>
                        </li>
                        <li class="mb-1 group">
                            <a href="#" class="flex items-center py-2 px-4 gap-x-2 hover:bg-gray-950 hover:text-gray-200 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white">
                                <i class="ri-scissors-line"></i>
                                <span class="text-sm">Costureros</span>
                            </a>
                        </li>
                        <li class="mb-1 group">
                            <a href="{{ route("dolar.index") }}" class="flex items-center py-2 px-4 gap-x-2 hover:bg-gray-950 hover:text-gray-200 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white">
                                <i class="ri-money-dollar-circle-line"></i>
                                <span class="text-sm">Dolar</span>
                            </a>
                        </li>
                        <li class="mb-1 group">
                            <a href="#" class="flex items-center py-2 px-4 gap-x-2 hover:bg-gray-950 hover:text-gray-200 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white">
                                <i class="ri-money-dollar-circle-line"></i>
                                <span class="text-sm">Cuenta</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endauth
        </header>
    </div>
</div>
