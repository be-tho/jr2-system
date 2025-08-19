<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Connection Name
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching facade. This connection name is used when another
    | is not explicitly specified when executing a given caching function.
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "connections" for your application as
    | well as their drivers. You may even define multiple connections for the
    | same driver to easily switch between cache implementations.
    |
    | Supported drivers: "apc", "array", "database", "file",
    |         "memcached", "redis", "dynamodb", "octane", "null"
    |
    */

    'connections' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
            'lock_connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, or DynamoDB cache
    | stores there might be other applications using the same cache. For
    | that reason, you may prefix every cache key to avoid collisions.
    |
    */

    'prefix' => env(
        'CACHE_PREFIX',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_cache_'
    ),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL (Time To Live) Settings
    |--------------------------------------------------------------------------
    |
    | Default TTL values for different types of cached data
    |
    */

    'ttl' => [
        'dolar_rates' => 300, // 5 minutos para tasas del dólar
        'articulos_list' => 600, // 10 minutos para listas de artículos
        'categorias' => 1800, // 30 minutos para categorías
        'temporadas' => 1800, // 30 minutos para temporadas
        'search_results' => 300, // 5 minutos para resultados de búsqueda
        'dashboard_stats' => 900, // 15 minutos para estadísticas del dashboard
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Compression
    |--------------------------------------------------------------------------
    |
    | Enable compression for cache data to reduce memory usage
    |
    */

    'compression' => env('CACHE_COMPRESSION', false),

    /*
    |--------------------------------------------------------------------------
    | Cache Warming
    |--------------------------------------------------------------------------
    |
    | Enable automatic cache warming for frequently accessed data
    |
    */

    'warming' => [
        'enabled' => env('CACHE_WARMING', true),
        'strategies' => [
            'dolar_rates' => \App\Jobs\UpdateDolarRatesJob::class,
            'articulos_stats' => \App\Jobs\WarmArticulosCacheJob::class,
        ],
    ],

];
