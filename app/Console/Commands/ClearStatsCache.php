<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\StatsRepository;

class ClearStatsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar caché de estadísticas del sistema';

    /**
     * Execute the console command.
     */
    public function handle(StatsRepository $statsRepository)
    {
        $this->info('Limpiando caché de estadísticas...');
        
        try {
            $statsRepository->clearStatsCache();
            $this->info('✅ Caché de estadísticas limpiado correctamente');
        } catch (\Exception $e) {
            $this->error('❌ Error al limpiar caché: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
