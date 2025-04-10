@extends('layout.app')
@section('title', 'Dolar')
@section('content')
    <x-container-wrapp>
        <div>
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-4xl font-semibold text-gray-800">Dolar</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-900 rounded-md border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-white">Dolar Oficial</h2>
                    <p class="text-2xl font-bold text-white">${{ $dolarOficial }}</p>
                </div>
                <div class="bg-blue-900 rounded-md border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-white">Dolar Blue</h2>
                    <p class="text-2xl font-bold text-white">${{ $dolarBlue }}</p>
                </div>
                <div class="bg-blue-900 rounded-md border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-white">Dolar Intermedio</h2>
                    <p class="text-2xl font-bold text-white">${{ $dolarIntermedio }}</p>
                </div>
            </div>
        </div>
    </x-container-wrapp>
@endsection
