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
        'max_size' => 8192, // 8MB en KB
        'allowed_types' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
        'min_dimensions' => [
            'width' => 100,
            'height' => 100,
        ],
        'max_dimensions' => [
            'width' => 4000,
            'height' => 4000,
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
