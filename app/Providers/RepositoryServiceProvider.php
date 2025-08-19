<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ArticuloRepository;
use App\Repositories\CorteRepository;
use App\Repositories\StatsRepository;
use App\Models\Articulo;
use App\Models\Corte;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar repositorios
        $this->app->bind(ArticuloRepository::class, function ($app) {
            return new ArticuloRepository(new Articulo());
        });

        $this->app->bind(CorteRepository::class, function ($app) {
            return new CorteRepository(new Corte());
        });

        $this->app->bind(StatsRepository::class, function ($app) {
            return new StatsRepository();
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
