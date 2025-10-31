<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\CostureroController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\DolarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TemporadaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PedidoController;
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
// TIENDA ROUTES (Public - No authentication required)
// ============================================================================
// Rutas de tienda con prefijo /tienda
// Funciona tanto en localhost (localhost:8000/tienda) como en producción
// Para producción con subdominio, configurar el servidor web para redirigir shop.tudominio.com a /tienda
Route::prefix('tienda')->middleware(['shop.domain'])->group(function () {
    // Catálogo de productos
    Route::get('/', [TiendaController::class, 'index'])->name('tienda.index');
    Route::get('/producto/{articulo}', [TiendaController::class, 'show'])->name('tienda.show');
    
    // Carrito de compras (API routes)
    Route::prefix('carrito')->name('carrito.')->group(function () {
        Route::get('/', [CarritoController::class, 'index'])->name('index');
        Route::post('/agregar', [CarritoController::class, 'agregar'])->name('agregar');
        Route::put('/actualizar', [CarritoController::class, 'actualizar'])->name('actualizar');
        Route::delete('/eliminar', [CarritoController::class, 'eliminar'])->name('eliminar');
        Route::post('/limpiar', [CarritoController::class, 'limpiar'])->name('limpiar');
        Route::get('/cantidad', [CarritoController::class, 'cantidad'])->name('cantidad');
    });
    
    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/procesar', [CheckoutController::class, 'procesar'])->name('procesar');
        Route::get('/confirmacion/{numeroOrden}', [CheckoutController::class, 'confirmacion'])->name('confirmacion');
    });
});

// ============================================================================
// PROTECTED ROUTES (Authentication required)
// ============================================================================

Route::middleware('auth')->group(function () {
    
    // Dashboard/Home - Accesible para todos los usuarios autenticados
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    
    // Logout - Accesible para todos los usuarios autenticados
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // ========================================================================
    // ACCOUNT MANAGEMENT - Accesible para todos los usuarios autenticados
    // ========================================================================
    Route::prefix('cuenta')->name('cuenta.')->group(function () {
        Route::get('/', [CuentaController::class, 'index'])->name('index');
        Route::get('/edit', [CuentaController::class, 'edit'])->name('edit');
        Route::put('/update', [CuentaController::class, 'update'])->name('update');
        Route::get('/change-password', [CuentaController::class, 'changePassword'])->name('change-password');
        Route::put('/update-password', [CuentaController::class, 'updatePassword'])->name('update-password');
    });

    // ========================================================================
    // DASHBOARD STATS (AJAX) - Accesible para todos los usuarios autenticados
    // ========================================================================
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/stats/realtime', [HomeController::class, 'getRealTimeStats'])->name('stats.realtime');
    });

    // ========================================================================
    // READ-ONLY ROUTES - Accesible para todos los usuarios autenticados (solo lectura)
    // ========================================================================
    Route::middleware('auth')->group(function () {
        
        // ====================================================================
        // CORTES VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('cortes')->name('cortes.')->group(function () {
            Route::get('/', [CorteController::class, 'index'])->name('index');
            Route::get('/create', [CorteController::class, 'create'])->name('create');
            Route::get('/{corte}', [CorteController::class, 'show'])->name('show');
        });
        
        // ====================================================================
        // ARTICULOS VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('articulos')->name('articulos.')->group(function () {
            Route::get('/', [ArticuloController::class, 'index'])->name('index');
            Route::get('/create', [ArticuloController::class, 'create'])->name('create');
            Route::get('/{articulo}', [ArticuloController::class, 'show'])->name('show');
        });
        
        // ====================================================================
        // CATEGORIAS VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('categorias')->name('categorias.')->group(function () {
            Route::get('/', [CategoriaController::class, 'index'])->name('index');
            Route::get('/create', [CategoriaController::class, 'create'])->name('create');
        });
        
        // ====================================================================
        // TEMPORADAS VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('temporadas')->name('temporadas.')->group(function () {
            Route::get('/', [TemporadaController::class, 'index'])->name('index');
            Route::get('/create', [TemporadaController::class, 'create'])->name('create');
        });
        
        // ====================================================================
        // COSTUREROS VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('costureros')->name('costureros.')->group(function () {
            Route::get('/', [CostureroController::class, 'index'])->name('index');
            Route::get('/create', [CostureroController::class, 'create'])->name('create');
            Route::get('/{costurero}', [CostureroController::class, 'show'])->name('show');
            Route::get('/{costurero}/edit', [CostureroController::class, 'edit'])->name('edit');
        });
        
        // ====================================================================
        // DOLAR EXCHANGE RATES VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('dolar')->name('dolar.')->group(function () {
            Route::get('/', [DolarController::class, 'index'])->name('index');
            Route::get('/api', [DolarController::class, 'api'])->name('api');
        });
        
        // ====================================================================
        // VENTAS - Todos los usuarios autenticados pueden ver y crear
        // ====================================================================
        Route::prefix('ventas')->name('ventas.')->group(function () {
            Route::get('/', [VentaController::class, 'index'])->name('index');
            Route::get('/create', [VentaController::class, 'create'])->name('create');
            Route::post('/', [VentaController::class, 'store'])->name('store');
            Route::get('/search-articulos', [VentaController::class, 'searchArticulos'])->name('search-articulos');
            Route::get('/stats/estadisticas', [VentaController::class, 'getEstadisticas'])->name('stats.estadisticas');
            Route::get('/{venta}/edit', [VentaController::class, 'edit'])->name('edit');
            Route::put('/{venta}', [VentaController::class, 'update'])->name('update');
            Route::get('/{venta}/print', [VentaController::class, 'print'])->name('print');
            Route::get('/{venta}', [VentaController::class, 'show'])->name('show');
        });
        
        // ====================================================================
        // REPORTS VIEW - Todos pueden ver
        // ====================================================================
        Route::prefix('reportes')->name('reportes.')->group(function () {
            Route::get('/', [ReporteController::class, 'index'])->name('index');
            Route::get('/articulos', [ReporteController::class, 'articulos'])->name('articulos');
            Route::get('/cortes', [ReporteController::class, 'cortes'])->name('cortes');
            
            // Rutas AJAX para estadísticas en tiempo real
            Route::get('/stats/realtime', [ReporteController::class, 'getRealTimeStats'])->name('stats.realtime');
        });
        
        // ====================================================================
        // PEDIDOS ONLINE - Todos los usuarios autenticados pueden ver
        // ====================================================================
        Route::prefix('pedidos')->name('pedidos.')->group(function () {
            Route::get('/', [PedidoController::class, 'index'])->name('index');
            Route::get('/{pedido}', [PedidoController::class, 'show'])->name('show');
        });
    });

    // ========================================================================
    // ADMIN ONLY ROUTES - Solo para administradores (crear, editar, eliminar)
    // ========================================================================
    Route::middleware('role:administrador')->group(function () {
        
        // ====================================================================
        // CORTES MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('cortes')->name('cortes.')->group(function () {
            Route::post('/', [CorteController::class, 'store'])->name('store');
            Route::get('/{corte}/edit', [CorteController::class, 'edit'])->name('edit');
            Route::put('/{corte}', [CorteController::class, 'update'])->name('update');
            Route::delete('/{corte}', [CorteController::class, 'delete'])->name('delete');
        });
        
        // ====================================================================
        // ARTICULOS MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('articulos')->name('articulos.')->group(function () {
            Route::post('/', [ArticuloController::class, 'store'])->name('store');
            Route::get('/{articulo}/edit', [ArticuloController::class, 'edit'])->name('edit');
            Route::put('/{articulo}', [ArticuloController::class, 'update'])->name('update');
            Route::delete('/{articulo}', [ArticuloController::class, 'delete'])->name('delete');
        });
        
        // ====================================================================
        // CATEGORIAS MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('categorias')->name('categorias.')->group(function () {
            Route::post('/', [CategoriaController::class, 'store'])->name('store');
            Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
            Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
            Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
        });
        
        // ====================================================================
        // TEMPORADAS MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('temporadas')->name('temporadas.')->group(function () {
            Route::post('/', [TemporadaController::class, 'store'])->name('store');
            Route::get('/{temporada}/edit', [TemporadaController::class, 'edit'])->name('edit');
            Route::put('/{temporada}', [TemporadaController::class, 'update'])->name('update');
            Route::delete('/{temporada}', [TemporadaController::class, 'destroy'])->name('destroy');
        });
        
        // ====================================================================
        // COSTUREROS MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('costureros')->name('costureros.')->group(function () {
            Route::post('/', [CostureroController::class, 'store'])->name('store');
            Route::put('/{costurero}', [CostureroController::class, 'update'])->name('update');
            Route::delete('/{costurero}', [CostureroController::class, 'destroy'])->name('destroy');
        });
        
        // ====================================================================
        // DOLAR EXCHANGE RATES MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('dolar')->name('dolar.')->group(function () {
            Route::post('/clear-cache', [DolarController::class, 'clearCache'])->name('clear-cache');
        });
        
        // ====================================================================
        // DASHBOARD MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::post('/stats/clear-cache', [HomeController::class, 'clearStatsCache'])->name('stats.clear-cache');
        });
        
        // ====================================================================
        // REPORTS EXPORT - Solo administradores
        // ====================================================================
        Route::prefix('reportes')->name('reportes.')->group(function () {
        });
        
        // ====================================================================
        // VENTAS MANAGEMENT - Solo administradores pueden eliminar
        // ====================================================================
        Route::prefix('ventas')->name('ventas.')->group(function () {
            Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('destroy');
        });
        
        // ====================================================================
        // USER MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::patch('/{user}/role', [UserController::class, 'changeRole'])->name('change-role');
        });
        
        // ====================================================================
        // PEDIDOS ONLINE MANAGEMENT - Solo administradores
        // ====================================================================
        Route::prefix('pedidos')->name('pedidos.')->group(function () {
            Route::put('/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])->name('actualizar-estado');
            Route::put('/{pedido}/notas', [PedidoController::class, 'actualizarNotas'])->name('actualizar-notas');
        });
    });
});

// ============================================================================
// FALLBACK ROUTE
// ============================================================================

Route::fallback(function () {
    return redirect()->route('home.index');
});
