<?php

use App\Http\Controllers\ArticuloController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\DolarController;

Route::get('/', [HomeController::class, 'index'])->name('home.index')->middleware('auth');

//login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login/', [LoginController::class, 'login'])->name('login.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout')->middleware('auth');



//cortes
Route::get('/cortes', [CorteController::class, 'index'])->name('cortes.index')->middleware('auth');
Route::get('/cortes/create', [CorteController::class, 'create'])->name('cortes.create')->middleware('auth');
Route::post('/cortes', [CorteController::class, 'store'])->name('cortes.store')->middleware('auth');
Route::get('/corte/{id}', [CorteController::class, 'show'])->name('corte.show')->middleware('auth');
Route::get('/corte/{id}/edit', [CorteController::class, 'edit'])->name('corte.edit')->middleware('auth');
Route::put('/corte/{id}', [CorteController::class, 'update'])->name('corte.update')->middleware('auth');

//articulos
Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index')->middleware('auth');
Route::get('/articulos/create', [ArticuloController::class, 'create'])->name('articulos.create')->middleware('auth');
Route::get('/articulos/{id}', [ArticuloController::class, 'show'])->name('articulos.show')->middleware('auth');
Route::post('/articulos', [ArticuloController::class, 'store'])->name('articulos.store')->middleware('auth');
Route::get('/articulos/{id}/edit', [ArticuloController::class, 'edit'])->name('articulos.edit')->middleware('auth');
Route::put('/articulos/{id}', [ArticuloController::class, 'update'])->name('articulos.update')->middleware('auth');

//dolar
Route::get('/dolar', [DolarController::class, 'index'])->name('dolar.index')->middleware('auth');




//si no encuentra la ruta redirige a la home
Route::fallback(function () {
    return redirect()->route('home.index');
});
