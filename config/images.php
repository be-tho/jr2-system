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
        ],
        'thumbnails' => [
            'enabled' => true,
            'width' => 150,
            'height' => 150,
            'quality' => 70,
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
        'max_size' => 20480, // 20MB en KB (aumentado para fotos de móviles)
        'allowed_types' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
        'min_dimensions' => [
            'width' => 100,
            'height' => 100,
        ],
        'max_dimensions' => [
            'width' => 8000, // Aumentado para fotos de alta resolución
            'height' => 8000,
        ],
        'mobile_optimization' => [
            'enabled' => true,
            'max_size_before_compression' => 51200, // 50MB antes de comprimir
            'target_quality' => 75, // Calidad objetivo después de compresión
            'max_width' => 4000, // Ancho máximo después de compresión
            'max_height' => 4000, // Alto máximo después de compresión
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
