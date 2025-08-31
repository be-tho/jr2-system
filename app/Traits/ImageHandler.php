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

            // Redimensionar manteniendo proporción
            if ($options['maintain_aspect_ratio']) {
                $img = $img->resize($options['width'], $options['height'], function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $img = $img->resize($options['width'], $options['height']);
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
                'size' => $image->getSize(),
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
        $defaultOptions = [
            'max_size' => 8192, // 8MB
            'allowed_types' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
            'min_dimensions' => ['width' => 100, 'height' => 100],
            'max_dimensions' => ['width' => 4000, 'height' => 4000]
        ];

        $options = array_merge($defaultOptions, $options);

        // Validar tamaño
        if ($image->getSize() > ($options['max_size'] * 1024)) {
            throw new \Exception('La imagen no debe superar los ' . $options['max_size'] . 'KB');
        }

        // Validar tipo
        $extension = strtolower($image->getClientOriginalExtension());
        if (!in_array($extension, $options['allowed_types'])) {
            throw new \Exception('Tipo de archivo no permitido. Tipos válidos: ' . implode(', ', $options['allowed_types']));
        }

        // Validar dimensiones
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
