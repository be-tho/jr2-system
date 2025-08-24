<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\DolarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TemporadaController;
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
    // CATEGORIAS MANAGEMENT
    // ========================================================================
    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('index');
        Route::get('/create', [CategoriaController::class, 'create'])->name('create');
        Route::post('/', [CategoriaController::class, 'store'])->name('store');
        Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
        Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
        Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
    });
    
    // ========================================================================
    // TEMPORADAS MANAGEMENT
    // ========================================================================
    Route::prefix('temporadas')->name('temporadas.')->group(function () {
        Route::get('/', [TemporadaController::class, 'index'])->name('index');
        Route::get('/create', [TemporadaController::class, 'create'])->name('create');
        Route::post('/', [TemporadaController::class, 'store'])->name('store');
        Route::get('/{temporada}/edit', [TemporadaController::class, 'edit'])->name('edit');
        Route::put('/{temporada}', [TemporadaController::class, 'update'])->name('update');
        Route::delete('/{temporada}', [TemporadaController::class, 'destroy'])->name('destroy');
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
        
        // Rutas AJAX para estadísticas en tiempo real
        Route::get('/stats/realtime', [ReporteController::class, 'getRealTimeStats'])->name('stats.realtime');
        Route::post('/export/articulos/pdf', [ReporteController::class, 'exportArticulosPDF'])->name('export.articulos.pdf');
        Route::post('/export/cortes/pdf', [ReporteController::class, 'exportCortesPDF'])->name('export.cortes.pdf');
    });

    // ========================================================================
    // ACCOUNT MANAGEMENT
    // ========================================================================
    Route::prefix('cuenta')->name('cuenta.')->group(function () {
        Route::get('/', [CuentaController::class, 'index'])->name('index');
        Route::get('/edit', [CuentaController::class, 'edit'])->name('edit');
        Route::put('/update', [CuentaController::class, 'update'])->name('update');
        Route::get('/change-password', [CuentaController::class, 'changePassword'])->name('change-password');
        Route::put('/update-password', [CuentaController::class, 'updatePassword'])->name('update-password');

    });

    // ========================================================================
    // DASHBOARD STATS (AJAX)
    // ========================================================================
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/stats/realtime', [HomeController::class, 'getRealTimeStats'])->name('stats.realtime');
        Route::post('/stats/clear-cache', [HomeController::class, 'clearStatsCache'])->name('stats.clear-cache');
    });
});

// ============================================================================
// FALLBACK ROUTE
// ============================================================================

Route::fallback(function () {
    return redirect()->route('home.index');
});
