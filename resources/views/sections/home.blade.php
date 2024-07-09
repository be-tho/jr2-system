@extends('layout.app')
@section('title', 'Home')
@section('content')
    <x-container-wrapp>
        <div class="flex mb-2">
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
        </div>
        <div class="grid grid-col-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">Cortes activos</div>
                        <div class="font-normal text-gray-400">5</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">Cortes entregados</div>
                        <div class="font-normal text-gray-400">3</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">Cortes terminados</div>
                        <div class="font-normal text-gray-400">10</div>
                    </div>
                </div>
            </div>
        </div>

    </x-container-wrapp>
@endsection
