<?php
    /** @var \App\Models\Corte $cortes */
?>
@extends('layout.app')
@section('title', 'Cortes')
@section('content')
    <x-container-wrapp>
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-4xl font-bold text-gray-800">Cortes</h1>

            <a href="{{ route('cortes.create') }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2">
                Crear un corte nuevo
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        N° Corte
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Tela
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Encimadas
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Artículos
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Fecha de corte
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Estado
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Acciones</a>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach( $cortes as $corte)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $corte->numero_corte }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $corte->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $corte->cantidad }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $corte->articulos }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $corte->fecha }}
                        </td>
                        <td class="px-6 py-4">
                            @if($corte->estado == 0)
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    Cortado
                                </span>
                            @endif
                            @if($corte->estado == 1)
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    Costurando
                                </span>
                                @endif
                                @if($corte->estado == 2)
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    Entregado
                                </span>
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('corte.show', ['id' => $corte->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-1.5">
                                <i class="ri-pencil-line"></i>
                                Ver
                            </a>
                            <a href="{{ route('corte.edit', ['id' => $corte->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-1.5">
                                <i class="ri-eye-line"></i>
                                Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </x-container-wrapp>
@endsection
