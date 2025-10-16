<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Telescope\Telescope;

class TelescopePrune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telescope:prune {--hours=24 : The number of hours to retain Telescope data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune Telescope entries older than the specified number of hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = $this->option('hours');
        
        $this->info("Limpiando entradas de Telescope más antiguas de {$hours} horas...");
        
        Telescope::store()->prune(now()->subHours($hours));
        
        $this->info('Limpieza de Telescope completada exitosamente.');
        
        return Command::SUCCESS;
    }
}
