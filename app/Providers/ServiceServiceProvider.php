<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\VentaService;
use App\Services\ArticuloService;
use App\Services\StockService;
use App\Repositories\ArticuloRepository;
use App\Models\Articulo;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar StockService
        $this->app->singleton(StockService::class, function ($app) {
            return new StockService();
        });

        // Registrar ArticuloService
        $this->app->singleton(ArticuloService::class, function ($app) {
            $articuloRepository = new ArticuloRepository(new Articulo());
            return new ArticuloService($articuloRepository);
        });

        // Registrar VentaService
        $this->app->singleton(VentaService::class, function ($app) {
            $stockService = $app->make(StockService::class);
            return new VentaService($stockService);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
