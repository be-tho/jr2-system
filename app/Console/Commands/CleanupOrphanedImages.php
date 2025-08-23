<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class CleanupOrphanedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:cleanup-profile {--dry-run : Mostrar qué se eliminaría sin ejecutar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar imágenes de perfil huérfanas del storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 Modo de simulación - No se eliminarán archivos');
        }
        
        $this->info('🧹 Iniciando limpieza de imágenes de perfil huérfanas...');
        
        // Obtener todas las imágenes en el storage
        $storageImages = Storage::disk('public')->files('profile-images');
        $this->info('📁 Imágenes encontradas en storage: ' . count($storageImages));
        
        // Obtener imágenes referenciadas en la base de datos
        $dbImages = User::whereNotNull('profile_image')
            ->where('profile_image', '!=', 'usuario.jpg')
            ->pluck('profile_image')
            ->toArray();
        
        $this->info('💾 Imágenes referenciadas en BD: ' . count($dbImages));
        
        // Encontrar imágenes huérfanas
        $orphanedImages = [];
        foreach ($storageImages as $storageImage) {
            $filename = basename($storageImage);
            if (!in_array($filename, $dbImages) && $filename !== 'usuario.jpg') {
                $orphanedImages[] = $storageImage;
            }
        }
        
        if (empty($orphanedImages)) {
            $this->info('✅ No se encontraron imágenes huérfanas');
            return 0;
        }
        
        $this->warn('⚠️  Imágenes huérfanas encontradas: ' . count($orphanedImages));
        
        foreach ($orphanedImages as $image) {
            $this->line('  - ' . basename($image));
        }
        
        if ($isDryRun) {
            $this->info('🔍 Simulación completada. Ejecuta sin --dry-run para eliminar archivos.');
            return 0;
        }
        
        if ($this->confirm('¿Deseas eliminar estas imágenes huérfanas?')) {
            $deletedCount = 0;
            foreach ($orphanedImages as $image) {
                try {
                    Storage::disk('public')->delete($image);
                    $deletedCount++;
                    $this->line('🗑️  Eliminada: ' . basename($image));
                } catch (\Exception $e) {
                    $this->error('❌ Error al eliminar ' . basename($image) . ': ' . $e->getMessage());
                }
            }
            
            $this->info("✅ Limpieza completada. Se eliminaron {$deletedCount} imágenes.");
        } else {
            $this->info('❌ Operación cancelada por el usuario.');
        }
        
        return 0;
    }
}
