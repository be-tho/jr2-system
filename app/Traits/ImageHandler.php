<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ImageHandler
{
    /**
     * Procesar y guardar una imagen con optimización para móviles
     *
     * @param \Illuminate\Http\UploadedFile|null $image
     * @param string $directory
     * @param array $options
     * @return string|null
     */
    protected function processAndSaveImage($image, string $directory, array $options = [])
    {
        if (!$image || !$image->isValid()) {
            return null;
        }

        try {
            $defaultOptions = [
                'width' => 450,
                'height' => 600,
                'quality' => 80,
                'format' => 'jpeg',
                'maintain_aspect_ratio' => true,
                'filename_prefix' => time() . '_',
                'mobile_optimize' => true,
                'target_file_size' => 2048, // 2MB objetivo
            ];

            $options = array_merge($defaultOptions, $options);

            // Crear directorio si no existe
            $fullPath = public_path($directory);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            // Generar nombre único para la imagen
            $filename = $options['filename_prefix'] . $this->sanitizeFilename($image->getClientOriginalName());
            $filepath = $fullPath . '/' . $filename;

            // Detectar si es un dispositivo móvil
            $isMobile = $this->isMobileDevice();
            
            // Procesar imagen con optimización móvil
            if ($isMobile && $options['mobile_optimize']) {
                $filename = $this->processMobileImage($image, $directory, $options);
            } else {
                $filename = $this->processStandardImage($image, $directory, $options);
            }

            Log::info('Imagen procesada y guardada exitosamente', [
                'original_name' => $image->getClientOriginalName(),
                'saved_filename' => $filename,
                'original_size' => $image->getSize(),
                'mime_type' => $image->getMimeType(),
                'is_mobile' => $isMobile,
                'mobile_optimized' => $isMobile && $options['mobile_optimize']
            ]);

            return $filename;

        } catch (\Exception $e) {
            Log::error('Error al procesar imagen', [
                'error' => $e->getMessage(),
                'file' => $image->getClientOriginalName(),
                'directory' => $directory
            ]);
            
            throw new \Exception('Error al procesar la imagen: ' . $e->getMessage());
        }
    }

    /**
     * Procesar imagen específicamente para dispositivos móviles
     */
    protected function processMobileImage($image, string $directory, array $options): string
    {
        $config = config('images.mobile');
        $originalSize = $image->getSize();
        $targetSize = $config['target_file_size'] * 1024; // Convertir a bytes
        
        // Determinar calidad inicial basada en el tamaño original
        $quality = $this->calculateOptimalQuality($originalSize, $targetSize);
        
        // Verificar permisos del directorio antes de procesar
        $fullPath = public_path($directory);
        if (!is_dir($fullPath)) {
            if (!mkdir($fullPath, 0755, true)) {
                throw new \Exception("No se pudo crear el directorio: $fullPath");
            }
        }
        
        if (!is_writable($fullPath)) {
            // Intentar cambiar permisos
            if (!chmod($fullPath, 0755)) {
                throw new \Exception("El directorio no es escribible y no se pudieron cambiar los permisos: $fullPath");
            }
        }
        
        // Procesar imagen con Intervention Image
        $manager = new ImageManager(new Driver());
        
        // Manejar formatos HEIC/HEIF
        $tempPath = $this->convertHeicToJpeg($image);
        $img = $manager->read($tempPath);
        
        // Aplicar redimensionamiento inteligente
        $img = $this->applySmartResize($img, $options);
        
        // Intentar guardar con diferentes calidades hasta alcanzar el tamaño objetivo
        $filename = $this->saveWithTargetSize($img, $directory, $options, $targetSize, $quality);
        
        // Limpiar archivo temporal si existe
        if ($tempPath !== $image->getRealPath()) {
            @unlink($tempPath);
        }
        
        return $filename;
    }

    /**
     * Procesar imagen estándar (no móvil)
     */
    protected function processStandardImage($image, string $directory, array $options): string
    {
        $fullPath = public_path($directory);
        $filename = $options['filename_prefix'] . $this->sanitizeFilename($image->getClientOriginalName());
        $filepath = $fullPath . '/' . $filename;

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image->getRealPath());

        // Redimensionar manteniendo proporción
        if ($options['maintain_aspect_ratio']) {
            $img = $img->resize($options['width'], $options['height'], function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $img = $img->resize($options['width'], $options['height']);
        }

        // Guardar imagen
        $this->saveImage($img, $filepath, $options);

        return $filename;
    }

    /**
     * Convertir imagen HEIC/HEIF a JPEG si es necesario
     */
    protected function convertHeicToJpeg($image): string
    {
        $mimeType = strtolower($image->getMimeType());
        
        if (in_array($mimeType, ['image/heic', 'image/heif'])) {
            // Crear archivo temporal
            $tempPath = tempnam(sys_get_temp_dir(), 'heic_convert_');
            
            // Intentar convertir usando ImageMagick si está disponible
            if (extension_loaded('imagick')) {
                $imagick = new \Imagick($image->getRealPath());
                $imagick->setImageFormat('jpeg');
                $imagick->writeImage($tempPath);
                $imagick->clear();
                $imagick->destroy();
                return $tempPath;
            }
            
            // Fallback: usar GD (puede no funcionar para HEIC)
            $imageData = file_get_contents($image->getRealPath());
            file_put_contents($tempPath, $imageData);
            return $tempPath;
        }
        
        return $image->getRealPath();
    }

    /**
     * Aplicar redimensionamiento inteligente
     */
    protected function applySmartResize($img, array $options): \Intervention\Image\Image
    {
        $config = config('images.mobile');
        $strategy = $config['resize_strategy'];
        
        switch ($strategy) {
            case 'smart':
                // Redimensionar solo si la imagen es muy grande
                $currentWidth = $img->width();
                $currentHeight = $img->height();
                
                if ($currentWidth > 2000 || $currentHeight > 2000) {
                    $img = $img->resize(2000, 2000, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                break;
                
            case 'force':
                $img = $img->resize($options['width'], $options['height'], function ($constraint) {
                    $constraint->aspectRatio();
                });
                break;
                
            case 'maintain':
            default:
                // Mantener dimensiones originales
                break;
        }
        
        return $img;
    }

    /**
     * Guardar imagen con tamaño objetivo
     */
    protected function saveWithTargetSize($img, string $directory, array $options, int $targetSize, int $initialQuality): string
    {
        $fullPath = public_path($directory);
        
        // Verificar permisos del directorio
        if (!is_dir($fullPath)) {
            if (!mkdir($fullPath, 0755, true)) {
                throw new \Exception("No se pudo crear el directorio: $fullPath");
            }
        }
        
        if (!is_writable($fullPath)) {
            if (!chmod($fullPath, 0755)) {
                throw new \Exception("El directorio no es escribible: $fullPath");
            }
        }
        
        $filename = $options['filename_prefix'] . uniqid() . '.webp';
        $filepath = $fullPath . '/' . $filename;
        
        $quality = $initialQuality;
        $maxAttempts = 5;
        $attempt = 0;
        
        do {
            $attempt++;
            
            try {
                // Guardar con calidad actual
                $img->toWebp($quality)->save($filepath);
                
                $fileSize = filesize($filepath);
                
                // Si el tamaño es aceptable, terminar
                if ($fileSize <= $targetSize) {
                    break;
                }
                
                // Reducir calidad para el siguiente intento
                $quality = max(30, $quality - 15);
                
                // Si ya intentamos demasiado, usar JPEG como fallback
                if ($attempt >= $maxAttempts) {
                    $filename = $options['filename_prefix'] . uniqid() . '.jpg';
                    $filepath = $fullPath . '/' . $filename;
                    $img->toJpeg($quality)->save($filepath);
                    break;
                }
                
            } catch (\Exception $e) {
                // Si hay error al guardar WebP, intentar con JPEG
                if ($attempt >= $maxAttempts) {
                    $filename = $options['filename_prefix'] . uniqid() . '.jpg';
                    $filepath = $fullPath . '/' . $filename;
                    $img->toJpeg($quality)->save($filepath);
                    break;
                }
                
                // Reducir calidad y continuar
                $quality = max(30, $quality - 15);
            }
            
        } while ($attempt < $maxAttempts);
        
        return $filename;
    }

    /**
     * Calcular calidad óptima basada en el tamaño original
     */
    protected function calculateOptimalQuality(int $originalSize, int $targetSize): int
    {
        $ratio = $targetSize / $originalSize;
        
        if ($ratio >= 1) {
            return 85; // No necesitamos comprimir
        } elseif ($ratio >= 0.5) {
            return 75;
        } elseif ($ratio >= 0.25) {
            return 60;
        } else {
            return 45;
        }
    }

    /**
     * Detectar si es un dispositivo móvil
     */
    protected function isMobileDevice(): bool
    {
        $userAgent = request()->header('User-Agent');
        
        if (!$userAgent) {
            return false;
        }
        
        $mobileKeywords = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone',
            'BlackBerry', 'Opera Mini', 'IEMobile'
        ];
        
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Sanitizar nombre de archivo
     */
    protected function sanitizeFilename(string $filename): string
    {
        // Remover caracteres especiales y espacios
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        $filename = preg_replace('/_+/', '_', $filename);
        $filename = trim($filename, '_');
        
        return $filename;
    }

    /**
     * Guardar imagen con formato específico
     */
    protected function saveImage($img, string $filepath, array $options): void
    {
        switch (strtolower($options['format'])) {
            case 'jpeg':
            case 'jpg':
                $img->toJpeg($options['quality'])->save($filepath);
                break;
            case 'png':
                $img->toPng()->save($filepath);
                break;
            case 'webp':
                $img->toWebp($options['quality'])->save($filepath);
                break;
            default:
                $img->toJpeg($options['quality'])->save($filepath);
        }
    }

    /**
     * Eliminar imagen del sistema de archivos
     *
     * @param string $filename
     * @param string $directory
     * @param string $defaultImage
     * @return bool
     */
    protected function deleteImage(string $filename, string $directory, string $defaultImage = 'default.svg'): bool
    {
        if ($filename === $defaultImage) {
            return true; // No eliminar imagen por defecto
        }

        $fullPath = public_path($directory . '/' . $filename);
        
        if (file_exists($fullPath)) {
            try {
                unlink($fullPath);
                Log::info('Imagen eliminada exitosamente', [
                    'filename' => $filename,
                    'path' => $fullPath
                ]);
                return true;
            } catch (\Exception $e) {
                Log::error('Error al eliminar imagen', [
                    'error' => $e->getMessage(),
                    'filename' => $filename,
                    'path' => $fullPath
                ]);
                return false;
            }
        }

        return true; // Archivo no existe, considerar como éxito
    }

    /**
     * Obtener URL completa de la imagen
     *
     * @param string $filename
     * @param string $directory
     * @param string $defaultImage
     * @return string
     */
    protected function getImageUrl(string $filename, string $directory, string $defaultImage = 'default.svg'): string
    {
        if (empty($filename) || $filename === $defaultImage) {
            return asset($directory . '/' . $defaultImage);
        }

        $fullPath = public_path($directory . '/' . $filename);
        
        if (file_exists($fullPath)) {
            return asset($directory . '/' . $filename);
        }

        // Si la imagen no existe, devolver imagen por defecto
        return asset($directory . '/' . $defaultImage);
    }

    /**
     * Validar archivo de imagen con soporte para móviles
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param array $options
     * @return bool
     */
    protected function validateImage($image, array $options = []): bool
    {
        $config = config('images.validation');
        $mobileConfig = config('images.mobile');
        
        $defaultOptions = [
            'max_size' => $mobileConfig['max_upload_size'],
            'allowed_types' => $config['allowed_types'],
            'min_dimensions' => $config['min_dimensions'],
            'max_dimensions' => $config['max_dimensions']
        ];

        $options = array_merge($defaultOptions, $options);

        // Validar tamaño
        if ($image->getSize() > ($options['max_size'] * 1024)) {
            throw new \Exception('La imagen no debe superar los ' . ($options['max_size'] / 1024) . 'MB');
        }

        // Validar tipo
        $extension = strtolower($image->getClientOriginalExtension());
        $mimeType = strtolower($image->getMimeType());
        
        $validTypes = array_merge($options['allowed_types'], ['heic', 'heif']);
        $validMimeTypes = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 
            'image/webp', 'image/heic', 'image/heif'
        ];
        
        if (!in_array($extension, $validTypes) && !in_array($mimeType, $validMimeTypes)) {
            throw new \Exception('Tipo de archivo no permitido. Tipos válidos: ' . implode(', ', $validTypes));
        }

        // Validar dimensiones solo para formatos soportados por GD
        if (!in_array($mimeType, ['image/heic', 'image/heif'])) {
            $imageInfo = getimagesize($image->getRealPath());
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];

                if ($width < $options['min_dimensions']['width'] || $height < $options['min_dimensions']['height']) {
                    throw new \Exception('La imagen debe tener al menos ' . $options['min_dimensions']['width'] . 'x' . $options['min_dimensions']['height'] . ' píxeles');
                }

                if ($width > $options['max_dimensions']['width'] || $height > $options['max_dimensions']['height']) {
                    throw new \Exception('La imagen no debe superar ' . $options['max_dimensions']['width'] . 'x' . $options['max_dimensions']['height'] . ' píxeles');
                }
            }
        }

        return true;
    }

    /**
     * Generar thumbnail de una imagen
     *
     * @param string $imagePath
     * @param string $thumbnailPath
     * @param int $width
     * @param int $height
     * @return bool
     */
    protected function generateThumbnail(string $imagePath, string $thumbnailPath, int $width = 150, int $height = 150): bool
    {
        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($imagePath);
            
            $img = $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->toJpeg(80)->save($thumbnailPath);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error al generar thumbnail', [
                'error' => $e->getMessage(),
                'image_path' => $imagePath,
                'thumbnail_path' => $thumbnailPath
            ]);
            return false;
        }
    }
}
