<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de Imágenes
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las opciones de procesamiento de imágenes
    | para diferentes tipos de entidades en tu aplicación.
    |
    */

    'defaults' => [
        'quality' => 80,
        'format' => 'jpeg',
        'maintain_aspect_ratio' => true,
        'filename_prefix' => time() . '_',
    ],

    'articulos' => [
        'directory' => 'src/assets/uploads/articulos',
        'default_image' => 'default-articulo.png',
        'options' => [
            'width' => 500,
            'height' => 600,
            'quality' => 80,
            'format' => 'jpeg',
            'maintain_aspect_ratio' => true,
            'mobile_optimize' => true,
            'target_file_size' => 2048, // 2MB objetivo
        ],
        'thumbnails' => [
            'enabled' => true,
            'width' => 150,
            'height' => 150,
            'quality' => 70,
        ],
        'mobile' => [
            'enabled' => true,
            'auto_optimize' => true,
            'max_upload_size' => 51200, // 50MB
            'target_file_size' => 2048, // 2MB objetivo después de optimización
            'compression_levels' => [
                'high' => 60,
                'medium' => 75,
                'low' => 85,
            ],
            'resize_strategy' => 'smart', // smart, force, maintain
            'formats' => [
                'preferred' => 'webp',
                'fallback' => 'jpeg',
            ],
        ],
    ],

    'cortes' => [
        'directory' => 'src/assets/uploads/cortes',
        'default_image' => 'default-corte.jpg',
        'options' => [
            'width' => 450,
            'height' => 600,
            'quality' => 80,
            'format' => 'jpeg',
            'maintain_aspect_ratio' => true,
        ],
        'thumbnails' => [
            'enabled' => true,
            'width' => 150,
            'height' => 150,
            'quality' => 70,
        ],
    ],

    'validation' => [
        'max_size' => 51200, // 50MB en KB (aumentado para móviles)
        'allowed_types' => ['jpeg', 'jpg', 'png', 'gif', 'webp', 'heic', 'heif'],
        'min_dimensions' => [
            'width' => 50,
            'height' => 50,
        ],
        'max_dimensions' => [
            'width' => 8000,
            'height' => 8000,
        ],
    ],

    // Configuración específica para dispositivos móviles
    'mobile' => [
        'enabled' => true,
        'auto_optimize' => true,
        'max_upload_size' => 51200, // 50MB
        'target_file_size' => 2048, // 2MB objetivo después de optimización
        'compression_levels' => [
            'high' => 60,
            'medium' => 75,
            'low' => 85,
        ],
        'resize_strategy' => 'smart', // smart, force, maintain
        'formats' => [
            'preferred' => 'webp',
            'fallback' => 'jpeg',
        ],
    ],

    'cleanup' => [
        'enabled' => true,
        'schedule' => 'weekly', // daily, weekly, monthly
        'dry_run' => false,
        'log_deletions' => true,
    ],

    'storage' => [
        'driver' => 'local', // local, s3, etc.
        'disk' => 'public',
        'visibility' => 'public',
    ],
];
