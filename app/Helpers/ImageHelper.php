<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Obtener URL completa de una imagen
     *
     * @param string $filename
     * @param string $directory
     * @param string $defaultImage
     * @return string
     */
    public static function getImageUrl(string $filename, string $directory, string $defaultImage = 'default.jpg'): string
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
     * Obtener URL de imagen de artículo
     *
     * @param string $filename
     * @return string
     */
    public static function getArticuloImageUrl(string $filename): string
    {
        return self::getImageUrl($filename, 'src/assets/uploads/articulos', 'default-articulo.svg');
    }

    /**
     * Obtener URL de imagen de corte
     *
     * @param string $filename
     */
    public static function getCorteImageUrl(string $filename): string
    {
        return self::getImageUrl($filename, 'src/assets/uploads/cortes', 'default-corte.svg');
    }

    /**
     * Verificar si una imagen existe
     *
     * @param string $filename
     * @param string $directory
     * @return bool
     */
    public static function imageExists(string $filename, string $directory): bool
    {
        if (empty($filename)) {
            return false;
        }

        $fullPath = public_path($directory . '/' . $filename);
        return file_exists($fullPath);
    }

    /**
     * Verificar si una imagen es la imagen por defecto
     *
     * @param string $filename
     * @param string $defaultImage
     * @return bool
     */
    public static function isDefaultImage(string $filename, string $defaultImage): bool
    {
        return empty($filename) || $filename === $defaultImage;
    }

    /**
     * Obtener clase CSS para imagen por defecto
     *
     * @param string $filename
     * @param string $defaultImage
     * @return string
     */
    public static function getDefaultImageClass(string $filename, string $defaultImage): string
    {
        if (self::isDefaultImage($filename, $defaultImage)) {
            return 'opacity-75 grayscale';
        }
        return '';
    }

    /**
     * Obtener texto alternativo para imagen por defecto
     *
     * @param string $filename
     * @param string $defaultImage
     * @param string $itemName
     * @param string $itemType
     * @return string
     */
    public static function getDefaultImageAlt(string $filename, string $defaultImage, string $itemName, string $itemType = 'item'): string
    {
        if (self::isDefaultImage($filename, $defaultImage)) {
            return "Imagen por defecto de {$itemType}: {$itemName}";
        }
        return "Imagen de {$itemType}: {$itemName}";
    }

    /**
     * Obtener información de una imagen
     *
     * @param string $filename
     * @param string $directory
     * @return array|null
     */
    public static function getImageInfo(string $filename, string $directory): ?array
    {
        if (empty($filename)) {
            return null;
        }

        $fullPath = public_path($directory . '/' . $filename);
        
        if (!file_exists($fullPath)) {
            return null;
        }

        $imageInfo = getimagesize($fullPath);
        
        if (!$imageInfo) {
            return null;
        }

        return [
            'width' => $imageInfo[0],
            'height' => $imageInfo[1],
            'mime_type' => $imageInfo['mime'],
            'file_size' => filesize($fullPath),
            'file_path' => $fullPath
        ];
    }

    /**
     * Generar thumbnail de una imagen
     *
     * @param string $filename
     * @param string $directory
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public static function generateThumbnail(string $filename, string $directory, int $width = 150, int $height = 150): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $fullPath = public_path($directory . '/' . $filename);
        
        if (!file_exists($fullPath)) {
            return null;
        }

        try {
            $thumbnailName = 'thumb_' . $filename;
            $thumbnailPath = public_path($directory . '/' . $thumbnailName);
            
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $img = $manager->read($fullPath);
            
            $img = $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->toJpeg(80)->save($thumbnailPath);
            
            return $thumbnailName;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Limpiar imágenes huérfanas
     *
     * @param string $directory
     * @param array $validFilenames
     * @return int
     */
    public static function cleanupOrphanedImages(string $directory, array $validFilenames): int
    {
        $fullPath = public_path($directory);
        
        if (!is_dir($fullPath)) {
            return 0;
        }

        $files = scandir($fullPath);
        $deletedCount = 0;

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === '.gitkeep') {
                continue;
            }

            if (!in_array($file, $validFilenames)) {
                $filePath = $fullPath . '/' . $file;
                if (is_file($filePath)) {
                    unlink($filePath);
                    $deletedCount++;
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Obtener la URL de la imagen de perfil del usuario
     */
    public static function getProfileImageUrl($filename = null)
    {
        if (!$filename || $filename === 'usuario.jpg') {
            return asset('src/assets/images/usuario.jpg');
        }
        
        return asset('storage/profile-images/' . $filename);
    }
    
    /**
     * Obtener la clase CSS para la imagen de perfil
     */
    public static function getProfileImageClass($filename = null)
    {
        if (!$filename || $filename === 'usuario.jpg') {
            return 'default-profile';
        }
        
        return 'user-profile';
    }
    
    /**
     * Obtener el texto alternativo para la imagen de perfil
     */
    public static function getProfileImageAlt($filename = null, $userName = 'Usuario')
    {
        if (!$filename || $filename === 'usuario.jpg') {
            return 'Imagen de perfil por defecto';
        }
        
        return 'Foto de perfil de ' . $userName;
    }
}
