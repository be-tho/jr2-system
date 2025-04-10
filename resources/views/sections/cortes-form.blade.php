@extends('layout.app')
@section('title', 'Formulario de Cortes')
@section('content')
    <x-container-wrapp>
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-4xl font-bold text-gray-800">Crear un corte nuevo</h1>
            <a href="{{ route('cortes.index') }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                Volver
            </a>
        </div>
        <section class="bg-white">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Nuevo Corte</h2>
                <form action="{{ route('cortes.store')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('POST')
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="w-full">
                            <label for="numero_corte" class="block mb-2 text-sm font-medium text-gray-900 ">Numero de Corte</label>
                            <input type="number"
                                   name="numero_corte"
                                   id="numero_corte"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Ingrese el numero de corte"
                                   placeholder="Ingrese el numero de corte"
                                   @error('numero_corte')
                                   aria-describedby="error-numero_corte"
                                   @enderror
                                   value="{{ old('numero_corte') }}"
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
                                value="{{ old('nombre') }}"
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
                                value="{{ old('colores') }}"
                            >
                            @error('colores')
                            <div class="text-red-700" id="error-colores">{{ $errors->first('colores') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
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
                                value="{{ old('cantidad') }}"
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
                                value="{{ old('articulos') }}"
                            >
                            @error('articulos')
                            <div class="text-red-700" id="error-articulos">{{ $errors->first('articulos') }}</div>
                            @enderror
                        </div>
                        <div>
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
                                value="{{ old('costureros') }}"
                            >
                            @error('costureros')
                            <div class="text-red-700" id="error-costureros">{{ $errors->first('costureros') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="fecha_entrega" class="block mb-2 text-sm font-medium text-gray-900 ">Subir Imagen</label>
                            <label for="imagen" class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="size-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Haga clic para cargar</span> o arrastrar y soltar</p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input
                                    name="imagen"
                                    id="imagen"
                                    type="file"
                                    class="hidden"
                                    @error('imagen')
                                    aria-describedby="error-imagen"
                                    @enderror
                                    value="{{ old('imagen') }}"
                                />
                            </label>
                            @error('imagen')
                            <div class="text-red-700" id="error-opening_time">{{ $errors->first('imagen') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                            <textarea
                                id="description"
                                name="descripcion"
                                rows="8"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Descripción del corte aquí"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                        CREAR CORTE
                    </button>
                </form>
            </div>
        </section>
    </x-container-wrapp>
@endsection
