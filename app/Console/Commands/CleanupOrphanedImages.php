<?php

namespace App\Console\Commands;

use App\Helpers\ImageHelper;
use App\Models\Articulo;
use App\Models\Corte;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupOrphanedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:cleanup {--dry-run : Mostrar qué se eliminaría sin ejecutar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar imágenes huérfanas del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Iniciando limpieza de imágenes huérfanas...');
        
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('⚠️  MODO DRY-RUN: No se eliminarán archivos');
        }

        // Limpiar imágenes de artículos
        $this->cleanupArticuloImages($dryRun);
        
        // Limpiar imágenes de cortes
        $this->cleanupCorteImages($dryRun);
        
        $this->info('✅ Limpieza completada');
    }

    /**
     * Limpiar imágenes huérfanas de artículos
     */
    private function cleanupArticuloImages(bool $dryRun): void
    {
        $this->info('📦 Limpiando imágenes de artículos...');
        
        // Obtener nombres de archivos válidos de la base de datos
        $validFilenames = Articulo::whereNotNull('imagen')
            ->where('imagen', '!=', 'default-articulo.png')
            ->pluck('imagen')
            ->toArray();
        
        // Agregar imagen por defecto
        $validFilenames[] = 'default-articulo.png';
        
        $deletedCount = ImageHelper::cleanupOrphanedImages('src/assets/uploads/articulos', $validFilenames);
        
        if ($deletedCount > 0) {
            $this->info("🗑️  Se eliminaron {$deletedCount} imágenes huérfanas de artículos");
        } else {
            $this->info('✨ No hay imágenes huérfanas de artículos');
        }
    }

    /**
     * Limpiar imágenes huérfanas de cortes
     */
    private function cleanupCorteImages(bool $dryRun): void
    {
        $this->info('✂️  Limpiando imágenes de cortes...');
        
        // Obtener nombres de archivos válidos de la base de datos
        $validFilenames = Corte::whereNotNull('imagen')
            ->where('imagen', '!=', 'default-corte.jpg')
            ->pluck('imagen')
            ->toArray();
        
        // Agregar imagen por defecto
        $validFilenames[] = 'default-corte.jpg';
        
        $deletedCount = ImageHelper::cleanupOrphanedImages('src/assets/uploads/cortes', $validFilenames);
        
        if ($deletedCount > 0) {
            $this->info("🗑️  Se eliminaron {$deletedCount} imágenes huérfanas de cortes");
        } else {
            $this->info('✨ No hay imágenes huérfanas de cortes');
        }
    }
}
