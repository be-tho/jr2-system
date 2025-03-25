<?php
/** @var \App\Models\Corte $corte */
?>
@extends('layout.app')
@section('title', 'Corte N° ' . $corte->numero_corte)
@section('content')
    <x-container-wrapp>
        <div>
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-4xl font-semibold text-gray-800">Corte N° {{ $corte->numero_corte }}</h1>

                <a href="{{ route('cortes.index') }}" class="text-white
                bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4
                focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5
                py-2.5 text-center mb-2">
                    Volver
                </a>
            </div>
        </div>
        <div class="grid grid-cols gap-5">
            <div class="bg-white shadow-md rounded-lg p-5">
                <h2 class="text-xl font-bold text-gray-800 mb-5">Información del corte</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <p class="text-gray-500">Número de corte</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->numero_corte }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Fecha de corte</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->fecha }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tipo de tela</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Encimadas</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->cantidad }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Colores</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->colores }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Estado del corte</p>
                        @if($corte->estado == 0)
                            <p class="text-red-500 font-semibold">Cortado</p>
                        @endif
                        @if($corte->estado == 1)
                            <p class="text-yellow-500 font-semibold">Costurado</p>
                        @endif
                        @if($corte->estado == 2)
                            <p class="text-green-500 font-semibold">Entregado</p>
                        @endif
                    </div>
{{--                    articulos --}}
                    <div>
                        <p class="text-gray-500">Artículos</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->articulos }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Descripción</p>
                        <p class="text-gray-800 font-semibold">{{ $corte->descripcion }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-2">Imagen del corte</p>
                        <a href="#modal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <i class="ri-image-line"></i>
                            <span class="ml-2">Ver imagen</span>
                        </a>
                    </div>
{{--                    modal en el medio --}}
                    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <img src="{{ asset('src/assets/uploads/cortes/' . $corte->imagen) }}" alt="imagen del corte" class="w-auto max-h-[100%] object-contain border-gray-100 border-4 rounded-2xl" />
                    </div>
                </div>
            </div>
        </div>

    </x-container-wrapp>
    <script>
        const modal = document.getElementById('modal');
        const btn = document.querySelector('a[href="#modal"]');
        const span = document.createElement('span');
        span.innerHTML = '&times;';
        span.classList.add('absolute', 'top-0', 'right-0',  'text-3xl', 'text-white', 'cursor-pointer', 'p-2', 'bg-black', 'bg-opacity-50');
        modal.appendChild(span);
        btn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
        span.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
@endsection
