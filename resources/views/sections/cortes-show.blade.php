<?php
/** @var \App\Models\Corte $corte */
?>
@extends('layout.app')
@section('title', 'Corte N° ' . $corte->numero_corte)
@section('content')
    <x-container-wrapp>
        <div>
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-4xl font-bold text-gray-800">Corte N° {{ $corte->numero_corte }}</h1>

                <a href="#" class="text-white
                bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4
                focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5
                py-2.5 text-center mb-2">
                    Editar corte
                </a>
            </div>
        </div>
        <div>

        </div>

    </x-container-wrapp>
@endsection
