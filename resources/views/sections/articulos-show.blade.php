<?php
/** @var \App\Models\Articulo $articulo **/

?>
@extends('layout.app')
@section('title', $articulo->nombre)
@section('content')
    <x-container-wrapp>
        <div>
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-4xl font-semibold text-gray-800">Artículo: {{ $articulo->codigo }}</h1>

                <a href="{{ route('articulos.index') }}" class="text-white
                bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4
                focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5
                py-2.5 text-center mb-2">
                    Volver
                </a>
            </div>
        </div>
        <div class="bg-white">
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium text-gray-900">{{$articulo->temporada}}</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium text-gray-900">{{$articulo->categoria}}</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>

                        <li class="text-sm">
                            <a href="#" aria-current="page" class="font-medium text-gray-500 hover:text-gray-600">{{$articulo->nombre}}</a>
                        </li>
                    </ol>
                </nav>

                <!-- Image gallery -->
                <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                    <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                        <img src="{{ asset('src/assets/uploads/articulos/' . $articulo->imagen) }}" alt="foto del producto {{$articulo->nombre}}" class="w-auto max-h-[100%] object-contain border-gray-100 border-4 rounded-2xl" />
                    </div>

                </div>

                <!-- Product info -->
                <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{$articulo->nombre}}</h1>
                    </div>

                    <!-- Options -->
                    <div class="mt-4 lg:row-span-3 lg:mt-0">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl tracking-tight text-gray-900">$ {{ number_format($articulo->precio, 0, ',', '.') }}</p>

                        <!-- Reviews -->
                        <div class="mt-6">
                            <h3 class="sr-only">Reviews</h3>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <!-- Active: "text-gray-900", Default: "text-gray-200" -->
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="sr-only">4 out of 5 stars</p>
                                <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">117 reviews</a>
                            </div>
                        </div>

                        <form class="mt-10">
                            <!-- Colors -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Color</h3>

                                <fieldset aria-label="Choose a color" class="mt-4">
                                    <div class="flex items-center space-x-3">
                                        <!-- Active and Checked: "ring ring-offset-1" -->
                                        <label aria-label="White" class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-400 focus:outline-none">
                                            <input type="radio" name="color-choice" value="White" class="sr-only">
                                            <span aria-hidden="true" class="h-8 w-8 rounded-full border border-black border-opacity-10 bg-white"></span>
                                        </label>
                                        <!-- Active and Checked: "ring ring-offset-1" -->
                                        <label aria-label="Gray" class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-400 focus:outline-none">
                                            <input type="radio" name="color-choice" value="Gray" class="sr-only">
                                            <span aria-hidden="true" class="h-8 w-8 rounded-full border border-black border-opacity-10 bg-gray-200"></span>
                                        </label>
                                        <!-- Active and Checked: "ring ring-offset-1" -->
                                        <label aria-label="Black" class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-900 focus:outline-none">
                                            <input type="radio" name="color-choice" value="Black" class="sr-only">
                                            <span aria-hidden="true" class="h-8 w-8 rounded-full border border-black border-opacity-10 bg-gray-900"></span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Sizes -->
                            <div class="mt-10">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">Size</h3>
                                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
                                </div>

                                <fieldset aria-label="Choose a size" class="mt-4">
                                    <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-not-allowed items-center justify-center rounded-md border bg-gray-50 px-4 py-3 text-sm font-medium uppercase text-gray-200 hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="XXS" disabled class="sr-only">
                                            <span>XXS</span>
                                            <span aria-hidden="true" class="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200">
                    <svg class="absolute inset-0 h-full w-full stroke-2 text-gray-200" viewBox="0 0 100 100" preserveAspectRatio="none" stroke="currentColor">
                      <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" />
                    </svg>
                  </span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="XS" class="sr-only">
                                            <span>XS</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="S" class="sr-only">
                                            <span>S</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="M" class="sr-only">
                                            <span>M</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="L" class="sr-only">
                                            <span>L</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="XL" class="sr-only">
                                            <span>XL</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="2XL" class="sr-only">
                                            <span>2XL</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                        <label class="group relative flex cursor-pointer items-center justify-center rounded-md border bg-white px-4 py-3 text-sm font-medium uppercase text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6">
                                            <input type="radio" name="size-choice" value="3XL" class="sr-only">
                                            <span>3XL</span>
                                            <!--
                                              Active: "border", Not Active: "border-2"
                                              Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                            <span class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <a href="{{ route('articulos.edit', ['id' => $articulo->id]) }}"  type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Editar</a>
                        </form>
                    </div>

                    <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                        <!-- Description and details -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Descripción</h3>

                            <div class="mt-4 space-y-6">
                                <p class="text-base text-gray-900">{{$articulo->descripcion}}</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-sm font-medium text-gray-900">Highlights</h3>

                            <div class="mt-4">
                                <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                    <li class="text-gray-400"><span class="text-gray-600">Hand cut and sewn locally</span></li>
                                    <li class="text-gray-400"><span class="text-gray-600">Dyed with our proprietary colors</span></li>
                                    <li class="text-gray-400"><span class="text-gray-600">Pre-washed &amp; pre-shrunk</span></li>
                                    <li class="text-gray-400"><span class="text-gray-600">Ultra-soft 100% cotton</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">Detalles</h2>

                            <div class="mt-4 space-y-6">
                                <p class="text-sm text-gray-600">The 6-Pack includes two black, two white, and two heather gray Basic Tees. Sign up for our subscription service and be the first to get new, exciting colors, like our upcoming &quot;Charcoal Gray&quot; limited release.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-container-wrapp>
@endsection