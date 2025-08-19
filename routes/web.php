<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\DolarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make sure to create
| a great user experience for your web routes.
|
*/

// ============================================================================
// PUBLIC ROUTES (No authentication required)
// ============================================================================

Route::middleware('guest')->group(function () {
    // Authentication routes
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'login'])->name('login.login');
});

// ============================================================================
// PROTECTED ROUTES (Authentication required)
// ============================================================================

Route::middleware('auth')->group(function () {
    
    // Dashboard/Home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // ========================================================================
    // CORTES MANAGEMENT
    // ========================================================================
    Route::prefix('cortes')->name('cortes.')->group(function () {
        Route::get('/', [CorteController::class, 'index'])->name('index');
        Route::get('/create', [CorteController::class, 'create'])->name('create');
        Route::post('/', [CorteController::class, 'store'])->name('store');
        Route::get('/{corte}', [CorteController::class, 'show'])->name('show');
        Route::get('/{corte}/edit', [CorteController::class, 'edit'])->name('edit');
        Route::put('/{corte}', [CorteController::class, 'update'])->name('update');
        Route::delete('/{corte}', [CorteController::class, 'delete'])->name('delete');
    });
    
    // ========================================================================
    // ARTICULOS MANAGEMENT
    // ========================================================================
    Route::prefix('articulos')->name('articulos.')->group(function () {
        Route::get('/', [ArticuloController::class, 'index'])->name('index');
        Route::get('/create', [ArticuloController::class, 'create'])->name('create');
        Route::post('/', [ArticuloController::class, 'store'])->name('store');
        Route::get('/{articulo}', [ArticuloController::class, 'show'])->name('show');
        Route::get('/{articulo}/edit', [ArticuloController::class, 'edit'])->name('edit');
        Route::put('/{articulo}', [ArticuloController::class, 'update'])->name('update');
        Route::delete('/{articulo}', [ArticuloController::class, 'delete'])->name('delete');
    });
    
    // ========================================================================
    // DOLAR EXCHANGE RATES
    // ========================================================================
    Route::prefix('dolar')->name('dolar.')->group(function () {
        Route::get('/', [DolarController::class, 'index'])->name('index');
        Route::get('/api', [DolarController::class, 'api'])->name('api');
        Route::post('/clear-cache', [DolarController::class, 'clearCache'])->name('clear-cache');
    });
    
    // ========================================================================
    // REPORTS
    // ========================================================================
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/articulos', [ReporteController::class, 'articulos'])->name('articulos');
        Route::get('/cortes', [ReporteController::class, 'cortes'])->name('cortes');
        
    });
});

// ============================================================================
// FALLBACK ROUTE
// ============================================================================

Route::fallback(function () {
    return redirect()->route('home.index');
});
