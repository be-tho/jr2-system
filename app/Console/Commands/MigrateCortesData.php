<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\MigrateCortesDataSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class MigrateCortesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortes:migrate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar datos de cortes a la nueva estructura refactorizada';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando migración de datos de cortes...');
        
        try {
            // Verificar si la tabla existe
            if (!Schema::hasTable('cortes')) {
                $this->error('La tabla cortes no existe.');
                return 1;
            }

            // Verificar si ya se ejecutó la migración completa
            if (Schema::hasColumn('cortes', 'tipo_tela') && 
                Schema::hasColumn('cortes', 'descripcion') && 
                !Schema::hasColumn('cortes', 'nombre')) {
                $this->info('La migración de cortes ya se ejecutó completamente.');
                return 0;
            }

            $this->info('Ejecutando migración de limpieza...');
            
            // Ejecutar la migración de limpieza
            $exitCode = Artisan::call('migrate', [
                '--path' => 'database/migrations/2024_12_20_010000_cleanup_cortes_table.php',
                '--force' => true
            ]);

            if ($exitCode !== 0) {
                $this->error('Error al ejecutar la migración de limpieza.');
                return 1;
            }

            $this->info('Migración de limpieza completada.');
            $this->info('Migrando datos de cortes...');
            
            $seeder = new MigrateCortesDataSeeder();
            $seeder->run();
            
            $this->info('Migración de datos de cortes completada exitosamente.');
            
        } catch (\Exception $e) {
            $this->error('Error durante la migración: ' . $e->getMessage());
            $this->error('Trace: ' . $e->getTraceAsString());
            return 1;
        }
        
        return 0;
    }
}
