<?php

namespace App\Helpers;

class MobileHelper
{
    /**
     * Detectar si es un dispositivo móvil
     */
    public static function isMobile(): bool
    {
        $userAgent = request()->header('User-Agent');
        
        if (!$userAgent) {
            return false;
        }
        
        $mobileKeywords = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone',
            'BlackBerry', 'Opera Mini', 'IEMobile', 'Mobile Safari'
        ];
        
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Detectar si es un iPhone específicamente
     */
    public static function isIPhone(): bool
    {
        $userAgent = request()->header('User-Agent');
        return $userAgent && stripos($userAgent, 'iPhone') !== false;
    }

    /**
     * Detectar si es un dispositivo Android
     */
    public static function isAndroid(): bool
    {
        $userAgent = request()->header('User-Agent');
        return $userAgent && stripos($userAgent, 'Android') !== false;
    }

    /**
     * Obtener información del dispositivo móvil
     */
    public static function getMobileInfo(): array
    {
        $userAgent = request()->header('User-Agent');
        
        $info = [
            'is_mobile' => false,
            'is_iphone' => false,
            'is_android' => false,
            'is_tablet' => false,
            'supports_heic' => false,
            'supports_webp' => false,
        ];
        
        if (!$userAgent) {
            return $info;
        }
        
        $info['is_mobile'] = self::isMobile();
        $info['is_iphone'] = self::isIPhone();
        $info['is_android'] = self::isAndroid();
        $info['is_tablet'] = stripos($userAgent, 'iPad') !== false || 
                            (stripos($userAgent, 'Android') !== false && stripos($userAgent, 'Mobile') === false);
        
        // iPhone soporta HEIC
        if ($info['is_iphone']) {
            $info['supports_heic'] = true;
        }
        
        // La mayoría de dispositivos móviles modernos soportan WebP
        if ($info['is_mobile']) {
            $info['supports_webp'] = true;
        }
        
        return $info;
    }

    /**
     * Obtener límites recomendados para el dispositivo
     */
    public static function getRecommendedLimits(): array
    {
        $mobileInfo = self::getMobileInfo();
        
        if ($mobileInfo['is_mobile']) {
            return [
                'max_file_size' => 50 * 1024 * 1024, // 50MB
                'max_dimensions' => ['width' => 8000, 'height' => 8000],
                'preferred_format' => $mobileInfo['supports_webp'] ? 'webp' : 'jpeg',
                'compression_quality' => 80,
            ];
        }
        
        return [
            'max_file_size' => 20 * 1024 * 1024, // 20MB
            'max_dimensions' => ['width' => 4000, 'height' => 4000],
            'preferred_format' => 'jpeg',
            'compression_quality' => 85,
        ];
    }
}
