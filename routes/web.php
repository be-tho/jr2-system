<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CorteController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

//login
Route::controller(LoginController::class)->prefix('/login')->group(function () {
    Route::get('', 'index')->name('login.index')->middleware('guest');
    Route::post('', 'login')->name('login.login');
    Route::post('logout', 'logout')->name('login.logout');
});

//cortes
Route::get('/cortes', [CorteController::class, 'index'])->name('cortes.index');
Route::get('/cortes/create', [CorteController::class, 'create'])->name('cortes.create');
