<?php
/** @var \App\Models\Corte $corte */
?>
@extends('layout.app')
@section('title', 'Editar corte N° ' . $corte->numero_corte)
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
        <section class="bg-white">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Actualizar el corte</h2>
                <form action="{{ route('corte.update', ['id' => $corte->id])}}" enctype="multipart/form-data" method="post">
                    @method('PUT')
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="w-full">
                            <label for="numero_corte" class="block mb-2 text-sm font-medium text-gray-900 ">Numero de Corte</label>
                            <input type="number"
                                   name="numero_corte"
                                   id="numero_corte"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Ingrese el numero de corte"
                                   @error('numero_corte')
                                   aria-describedby="error-numero_corte"
                                   @enderror
                                   value="{{ old('numero_corte', $corte->numero_corte )}}"
                            >
                            @error('numero_corte')
                            <div class="text-red-700" id="error-numero_corte">{{ $errors->first('numero_corte') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 ">Tipo de Tela</label>
                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Nombre de la tela"
                                @error('nombre')
                                aria-describedby="error-nombre"
                                @enderror
                                value="{{ old('nombre', $corte->nombre) }}"
                            >
                            @error('nombre')
                            <div class="text-red-700" id="error-nombre">{{ $errors->first('nombre') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="colores" class="block mb-2 text-sm font-medium text-gray-900 ">Colores</label>
                            <input
                                type="text"
                                name="colores"
                                id="colores"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Colores del corte"
                                @error('colores')
                                aria-describedby="error-colores"
                                @enderror
                                value="{{ old('colores', $corte->colores) }}"
                            >
                            @error('colores')
                            <div class="text-red-700" id="error-colores">{{ $errors->first('colores') }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="cantidad" class="block mb-2 text-sm font-medium text-gray-900">Cantidad de Encimadas</label>
                            <input
                                type="number"
                                name="cantidad"
                                id="cantidad"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Cantidad de encimadas del corte"
                                @error('cantidad')
                                aria-describedby="error-cantidad"
                                @enderror
                                value="{{ old('cantidad', $corte->cantidad) }}"
                            >
                            @error('cantidad')
                            <div class="text-red-700" id="error-cantidad">{{ $errors->first('cantidad') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="articulos" class="block mb-2 text-sm font-medium text-gray-900 ">Artículos</label>
                            <input
                                type="text"
                                name="articulos"
                                id="articulos"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Artículos del corte"
                                @error('articulos')
                                aria-describedby="error-articulos"
                                @enderror
                                value="{{ old('articulos', $corte->articulos) }}"
                            >
                            @error('articulos')
                            <div class="text-red-700" id="error-articulos">{{ $errors->first('articulos') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="costureros" class="block mb-2 text-sm font-medium text-gray-900">Costureros</label>
                            <input
                                type="text"
                                name="costureros"
                                id="costureros"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Costureros asignados al corte"
                                @error('costureros')
                                aria-describedby="error-costureros"
                                @enderror
                                value="{{ old('costureros', $corte->costureros) }}"
                            >
                            @error('costureros')
                            <div class="text-red-700" id="error-costureros">{{ $errors->first('costureros') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <div class="">
                                <label for="imagen" class="block form-label mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block bi bi-camera" viewBox="0 0 16 16">
                                        <path
                                            d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                    </svg>
                                    Imagen del articulo
                                </label>
                                {{--@formatter:off--}}
                                <input type="file"
                                       name="imagen"
                                       id="imagen"
                                       class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-blue-600 focus:ring-blue-800
										focus:outline-none focus:ring focus:ring-opacity-40"
                                       placeholder="Imagen del local"
                                       @error('imagen')
                                       aria-describedby="error-imagen"
                                       @enderror
                                       value="{{ old('imagen', $corte->imagen) }}"
                                >
                                @error('imagen')
                                <div class="text-red-700" id="error-imagen">{{ $errors->first('imagen') }}</div>
                                @enderror
                                {{--@formatter:on--}}
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path
                                        d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                                Estado
                            </label>
                            {{--@formatter:off--}}
                            <select name="estado"
                                    id="estado"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    @error('estado')
                                    aria-describedby="estado"
                                @enderror
                            >
                                <option value="0" {{ old('estado', $corte->estado) == 0 ? 'selected' : '' }}>Cortado</option>
                                <option value="1" {{ old('estado', $corte->estado) == 1 ? 'selected' : '' }}>Costurando</option>
                                <option value="2" {{ old('estado', $corte->estado) == 2 ? 'selected' : '' }}>Entregado</option>
                            </select>
                            @error('estado')
                            <div class="text-red-700" id="error-estado">{{ $errors->first('estado') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('fecha', $corte->fecha) }}">
                            @error('fecha')
                            <div class="text-red-700" id="error-fecha">{{ $errors->first('fecha') }}</div>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                            <textarea
                                id="description"
                                name="descripcion"
                                rows="8"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Descripción del corte aquí"
                            >{{ old('descripcion', $corte->descripcion) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="uppercase inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                        Actualizar
                    </button>
                </form>
            </div>
        </section>
    </x-container-wrapp>
@endsection
