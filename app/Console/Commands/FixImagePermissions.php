<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixImagePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:fix-permissions {--force : Forzar corrección de permisos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar y corregir permisos de directorios de imágenes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Verificando permisos de directorios de imágenes...');
        
        $directories = [
            'public/src/assets/uploads/articulos',
            'public/src/assets/uploads/cortes',
            'public/src/assets/uploads/profile-images',
            'public/src/assets/images',
        ];
        
        $fixed = 0;
        $errors = 0;
        
        foreach ($directories as $directory) {
            $this->processDirectory($directory, $fixed, $errors);
        }
        
        $this->newLine();
        
        if ($errors === 0) {
            $this->info("✅ Proceso completado exitosamente!");
            $this->info("📁 Directorios verificados: " . count($directories));
            $this->info("🔧 Directorios corregidos: {$fixed}");
        } else {
            $this->error("❌ Se encontraron {$errors} errores durante el proceso.");
            $this->warn("💡 Intente ejecutar el comando con --force para forzar la corrección.");
        }
        
        return $errors === 0 ? 0 : 1;
    }
    
    /**
     * Procesar un directorio individual
     */
    private function processDirectory(string $directory, int &$fixed, int &$errors): void
    {
        $fullPath = public_path($directory);
        
        $this->line("📁 Verificando: {$directory}");
        
        // Crear directorio si no existe
        if (!File::exists($fullPath)) {
            try {
                File::makeDirectory($fullPath, 0755, true);
                $this->info("   ✅ Directorio creado: {$directory}");
                $fixed++;
            } catch (\Exception $e) {
                $this->error("   ❌ Error al crear directorio: {$e->getMessage()}");
                $errors++;
                return;
            }
        }
        
        // Verificar permisos de escritura
        if (!is_writable($fullPath)) {
            $this->warn("   ⚠️  Directorio no escribible: {$directory}");
            
            if ($this->option('force')) {
                try {
                    // Intentar corregir permisos
                    chmod($fullPath, 0755);
                    
                    if (!is_writable($fullPath)) {
                        chmod($fullPath, 0777);
                    }
                    
                    if (is_writable($fullPath)) {
                        $this->info("   ✅ Permisos corregidos: {$directory}");
                        $fixed++;
                    } else {
                        $this->error("   ❌ No se pudieron corregir los permisos: {$directory}");
                        $errors++;
                    }
                } catch (\Exception $e) {
                    $this->error("   ❌ Error al corregir permisos: {$e->getMessage()}");
                    $errors++;
                }
            } else {
                $this->warn("   💡 Use --force para corregir automáticamente");
                $errors++;
            }
        } else {
            $this->info("   ✅ Permisos correctos: {$directory}");
        }
        
        // Verificar permisos de archivos existentes
        $this->checkExistingFiles($fullPath, $directory, $fixed, $errors);
    }
    
    /**
     * Verificar permisos de archivos existentes
     */
    private function checkExistingFiles(string $fullPath, string $directory, int &$fixed, int &$errors): void
    {
        try {
            $files = File::files($fullPath);
            
            if (count($files) > 0) {
                $this->line("   📄 Verificando " . count($files) . " archivos...");
                
                foreach ($files as $file) {
                    if (!is_readable($file->getPathname())) {
                        $this->warn("   ⚠️  Archivo no legible: " . $file->getFilename());
                        
                        if ($this->option('force')) {
                            try {
                                chmod($file->getPathname(), 0644);
                                if (is_readable($file->getPathname())) {
                                    $this->info("   ✅ Permisos de archivo corregidos: " . $file->getFilename());
                                    $fixed++;
                                } else {
                                    $errors++;
                                }
                            } catch (\Exception $e) {
                                $this->error("   ❌ Error al corregir archivo: {$e->getMessage()}");
                                $errors++;
                            }
                        } else {
                            $errors++;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Error al verificar archivos: {$e->getMessage()}");
            $errors++;
        }
    }
}
