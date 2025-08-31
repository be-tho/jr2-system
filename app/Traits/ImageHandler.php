<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ImageHandler
{
    /**
     * Procesar y guardar una imagen
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
            $config = config('images.validation');
            
            $defaultOptions = [
                'width' => 450,
                'height' => 600,
                'quality' => 80,
                'format' => 'jpeg',
                'maintain_aspect_ratio' => true,
                'filename_prefix' => time() . '_'
            ];

            $options = array_merge($defaultOptions, $options);

            // Crear directorio si no existe
            $fullPath = public_path($directory);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            // Generar nombre único para la imagen
            $filename = $options['filename_prefix'] . $image->getClientOriginalName();
            $filepath = $fullPath . '/' . $filename;

            // Procesar imagen con Intervention Image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());

            // Aplicar compresión automática para imágenes grandes
            $originalSize = $image->getSize();
            $imageInfo = getimagesize($image->getRealPath());
            $originalWidth = $imageInfo[0];
            $originalHeight = $imageInfo[1];
            
            // Si la imagen es muy grande, aplicar compresión más agresiva
            if ($config['mobile_optimization']['enabled'] && 
                ($originalSize > ($config['max_size'] * 1024) || 
                 $originalWidth > $config['mobile_optimization']['max_width'] || 
                 $originalHeight > $config['mobile_optimization']['max_height'])) {
                
                // Redimensionar a límites de móvil si es necesario
                if ($originalWidth > $config['mobile_optimization']['max_width'] || 
                    $originalHeight > $config['mobile_optimization']['max_height']) {
                    $img = $img->resize($config['mobile_optimization']['max_width'], $config['mobile_optimization']['max_height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                
                // Usar calidad más baja para comprimir
                $options['quality'] = $config['mobile_optimization']['target_quality'];
                
                Log::info('Aplicando compresión automática para imagen móvil', [
                    'original_size' => $originalSize,
                    'original_dimensions' => $originalWidth . 'x' . $originalHeight,
                    'target_quality' => $options['quality']
                ]);
            } else {
                // Redimensionar manteniendo proporción según opciones normales
                if ($options['maintain_aspect_ratio']) {
                    $img = $img->resize($options['width'], $options['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $img = $img->resize($options['width'], $options['height']);
                }
            }

            // Guardar imagen
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

            Log::info('Imagen procesada y guardada exitosamente', [
                'original_name' => $image->getClientOriginalName(),
                'saved_path' => $filepath,
                'original_size' => $originalSize,
                'final_size' => filesize($filepath),
                'compression_ratio' => round((1 - filesize($filepath) / $originalSize) * 100, 2) . '%',
                'mime_type' => $image->getMimeType()
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
     * Validar archivo de imagen
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param array $options
     * @return bool
     */
    protected function validateImage($image, array $options = []): bool
    {
        $config = config('images.validation');
        
        $defaultOptions = [
            'max_size' => $config['max_size'],
            'allowed_types' => $config['allowed_types'],
            'min_dimensions' => $config['min_dimensions'],
            'max_dimensions' => $config['max_dimensions'],
            'mobile_optimization' => $config['mobile_optimization']
        ];

        $options = array_merge($defaultOptions, $options);

        // Validar tamaño con límite más permisivo para móviles
        $maxSize = $options['mobile_optimization']['enabled'] 
            ? $options['mobile_optimization']['max_size_before_compression'] 
            : $options['max_size'];
            
        if ($image->getSize() > ($maxSize * 1024)) {
            throw new \Exception('La imagen no debe superar los ' . ($maxSize / 1024) . 'MB');
        }

        // Validar tipo
        $extension = strtolower($image->getClientOriginalExtension());
        if (!in_array($extension, $options['allowed_types'])) {
            throw new \Exception('Tipo de archivo no permitido. Tipos válidos: ' . implode(', ', $options['allowed_types']));
        }

        // Validar dimensiones con límites más permisivos para móviles
        $imageInfo = getimagesize($image->getRealPath());
        if ($imageInfo) {
            $width = $imageInfo[0];
            $height = $imageInfo[1];

            if ($width < $options['min_dimensions']['width'] || $height < $options['min_dimensions']['height']) {
                throw new \Exception('La imagen debe tener al menos ' . $options['min_dimensions']['width'] . 'x' . $options['min_dimensions']['height'] . ' píxeles');
            }

            // Usar límites más permisivos para móviles
            $maxWidth = $options['mobile_optimization']['enabled'] 
                ? $options['mobile_optimization']['max_width'] 
                : $options['max_dimensions']['width'];
            $maxHeight = $options['mobile_optimization']['enabled'] 
                ? $options['mobile_optimization']['max_height'] 
                : $options['max_dimensions']['height'];

            if ($width > $maxWidth || $height > $maxHeight) {
                throw new \Exception('La imagen no debe superar ' . $maxWidth . 'x' . $maxHeight . ' píxeles');
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
