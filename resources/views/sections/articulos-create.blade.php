@extends('layout.app')
@section('title', 'Crear artículo nuevo')
@section('content')
    <x-container-wrapp>
        <div>
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-4xl font-semibold text-gray-800">Crear artículo</h1>

                <a href="{{ route('articulos.index') }}" class="text-white
                bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4
                focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5
                py-2.5 text-center mb-2">
                    Volver
                </a>
            </div>
        </div>
        <section class="bg-white">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Nuevo Artículo</h2>
                <form action="{{ route('articulos.store')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('POST')
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="w-full">
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 ">Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Escribir el nombre del artículo"
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
                            <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 ">Código</label>
                            <input type="text"
                                   name="codigo"
                                   id="codigo"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Ingrese el código del artículo"
                                   @error('codigo')
                                   aria-describedby="error-codigo"
                                   @enderror
                                   value="{{ old('codigo') }}"
                            >
                            @error('codigo')
                            <div class="text-red-700" id="error-codigo">{{ $errors->first('codigo') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 ">Stock</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Cantidad de stock"
                                @error('stock')
                                aria-describedby="error-stock"
                                @enderror
                                value="{{ old('stock') }}"
                            >
                            @error('stock')
                            <div class="text-red-700" id="error-stock">{{ $errors->first('stock') }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="precio" class="block mb-2 text-sm font-medium text-gray-900">Precio</label>
                            <input
                                type="number"
                                name="precio"
                                id="precio"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Precio del artículo"
                                @error('precio')
                                aria-describedby="error-precio"
                                @enderror
                                value="{{ old('precio') }}"
                            >
                            @error('precio')
                            <div class="text-red-700" id="error-precio">{{ $errors->first('precio') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="temporada_id" class="block mb-2 text-sm font-medium text-gray-900">
                                Temporada
                            </label>
                            {{--@formatter:off--}}
                            <select name="temporada_id"
                                    id="temporada_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    @error('temporada_id')
                                    aria-describedby="temporada_id"
                                @enderror
                            >
                                <option value="0" selected>Seleccione</option>
                                <option value="4">Invierno 2024</option>
                                <option value="5">Primavera 2025</option>
                                <option value="6">Verano 2025</option>
                                <option value="7">Otoño 2025</option>
                            </select>
                            @error('temporada_id')
                            <div class="text-red-700" id="error-temporada_id">{{ $errors->first('temporada_id') }}</div>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="categoria_id" class="block mb-2 text-sm font-medium text-gray-900">
                                Categoria
                            </label>
                            {{--@formatter:off--}}
                            <select name="categoria_id"
                                    id="categoria_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    @error('categoria_id')
                                    aria-describedby="categoria_id"
                                @enderror
                            >
                                <option value="0" selected>Seleccione</option>
                                <option value="1">Remeras</option>
                                <option value="2">Pantalones</option>
                                <option value="3">Calzas</option>
                                <option value="4">Camperas</option>
                                <option value="1">Polleras</option>
                                <option value="2">Vestidos</option>
                                <option value="3">Buzos</option>
                                <option value="4">Shorts</option>
                                <option value="3">Sweaters</option>
                                <option value="4">Camisas</option>

                            </select>
                            @error('categoria_id')
                            <div class="text-red-700" id="error-categoria_id">{{ $errors->first('categoria_id') }}</div>
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
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                            <textarea
                                id="description"
                                name="descripcion"
                                rows="8"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Descripción del corte aquí"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                        CREAR ARTÍCULO
                    </button>
                </form>
            </div>
        </section>
    </x-container-wrapp>
@endsection
