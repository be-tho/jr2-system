<?php

namespace App\Services;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Temporada;
use App\Repositories\ArticuloRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ArticuloService
{
    protected $articuloRepository;

    public function __construct(ArticuloRepository $articuloRepository)
    {
        $this->articuloRepository = $articuloRepository;
    }

    /**
     * Obtener artículos con filtros y paginación
     */
    public function getArticulosConFiltros(array $filtros, int $perPage = 12): LengthAwarePaginator
    {
        return $this->articuloRepository->getPaginatedWithFilters($filtros, $perPage);
    }

    /**
     * Buscar artículos por término
     */
    public function buscarArticulos(string $termino, int $limite = 15): Collection
    {
        return Cache::remember("articulos_search_{$termino}_{$limite}", 300, function () use ($termino, $limite) {
            return $this->articuloRepository->search($termino)
                ->take($limite);
        });
    }

    /**
     * Obtener artículos disponibles para venta (con stock > 0)
     */
    public function getArticulosDisponiblesParaVenta(string $busqueda = '', int $limite = 50): Collection
    {
        $query = Articulo::where('stock', '>', 0)
            ->with(['categoria:id,nombre', 'temporada:id,nombre']);

        if (!empty($busqueda)) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('codigo', 'like', "%{$busqueda}%")
                  ->orWhere('descripcion', 'like', "%{$busqueda}%");
            })
            ->orderByRaw("
                CASE 
                    WHEN nombre LIKE ? THEN 1
                    WHEN codigo LIKE ? THEN 2
                    WHEN descripcion LIKE ? THEN 3
                    ELSE 4
                END
            ", ["{$busqueda}%", "{$busqueda}%", "{$busqueda}%"])
            ->limit($limite);
        } else {
            $query->orderBy('nombre')->limit($limite);
        }

        return $query->get();
    }

    /**
     * Crear nuevo artículo
     */
    public function crearArticulo(array $datos): Articulo
    {
        try {
            Log::info('Creando nuevo artículo', ['datos' => $datos]);

            $articulo = Articulo::create($datos);

            Log::info('Artículo creado exitosamente', [
                'articulo_id' => $articulo->id,
                'nombre' => $articulo->nombre
            ]);

            // Limpiar caché relacionado
            $this->limpiarCacheArticulos();

            return $articulo;

        } catch (\Exception $e) {
            Log::error('Error al crear artículo', [
                'error' => $e->getMessage(),
                'datos' => $datos
            ]);
            throw $e;
        }
    }

    /**
     * Actualizar artículo existente
     */
    public function actualizarArticulo(int $id, array $datos): Articulo
    {
        try {
            Log::info('Actualizando artículo', ['articulo_id' => $id, 'datos' => $datos]);

            $articulo = Articulo::findOrFail($id);
            $articulo->update($datos);

            Log::info('Artículo actualizado exitosamente', [
                'articulo_id' => $articulo->id,
                'nombre' => $articulo->nombre
            ]);

            // Limpiar caché relacionado
            $this->limpiarCacheArticulos();

            return $articulo->fresh();

        } catch (\Exception $e) {
            Log::error('Error al actualizar artículo', [
                'articulo_id' => $id,
                'error' => $e->getMessage(),
                'datos' => $datos
            ]);
            throw $e;
        }
    }

    /**
     * Eliminar artículo
     */
    public function eliminarArticulo(int $id): bool
    {
        try {
            Log::info('Eliminando artículo', ['articulo_id' => $id]);

            $articulo = Articulo::findOrFail($id);
            $nombre = $articulo->nombre;
            
            $articulo->delete();

            Log::info('Artículo eliminado exitosamente', [
                'articulo_id' => $id,
                'nombre' => $nombre
            ]);

            // Limpiar caché relacionado
            $this->limpiarCacheArticulos();

            return true;

        } catch (\Exception $e) {
            Log::error('Error al eliminar artículo', [
                'articulo_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obtener artículos populares (con más stock)
     */
    public function getArticulosPopulares(int $limite = 5): Collection
    {
        return Cache::remember("articulos_populares_{$limite}", 600, function () use ($limite) {
            return Articulo::select('id', 'nombre', 'codigo', 'precio', 'stock', 'imagen')
                ->orderBy('stock', 'desc')
                ->limit($limite)
                ->get();
        });
    }

    /**
     * Obtener artículos recientes
     */
    public function getArticulosRecientes(int $limite = 5): Collection
    {
        return Cache::remember("articulos_recientes_{$limite}", 300, function () use ($limite) {
            return Articulo::with(['categoria:id,nombre', 'temporada:id,nombre'])
                ->latest()
                ->limit($limite)
                ->get();
        });
    }

    /**
     * Obtener artículos por rango de precios
     */
    public function getArticulosPorRangoPrecios(float $precioMin, float $precioMax): Collection
    {
        return $this->articuloRepository->getByPriceRange($precioMin, $precioMax);
    }

    /**
     * Obtener artículos por rango de stock
     */
    public function getArticulosPorRangoStock(int $stockMin, int $stockMax): Collection
    {
        return $this->articuloRepository->getByStockRange($stockMin, $stockMax);
    }

    /**
     * Obtener estadísticas de artículos
     */
    public function getEstadisticas(): array
    {
        return Cache::remember('articulos_estadisticas', 600, function () {
            return $this->articuloRepository->getStats();
        });
    }

    /**
     * Obtener artículos agrupados por categoría
     */
    public function getArticulosAgrupadosPorCategoria(): \Illuminate\Support\Collection
    {
        return Cache::remember('articulos_por_categoria', 1800, function () {
            return $this->articuloRepository->getGroupedByCategoria();
        });
    }

    /**
     * Obtener artículos agrupados por temporada
     */
    public function getArticulosAgrupadosPorTemporada(): \Illuminate\Support\Collection
    {
        return Cache::remember('articulos_por_temporada', 1800, function () {
            return $this->articuloRepository->getGroupedByTemporada();
        });
    }

    /**
     * Obtener datos para formularios (categorías y temporadas)
     */
    public function getDatosParaFormularios(): array
    {
        return Cache::remember('form_data_articulos', 1800, function () {
            return [
                'categorias' => Categoria::select('id', 'nombre')->orderBy('nombre')->get(),
                'temporadas' => Temporada::select('id', 'nombre')->orderBy('nombre')->get(),
            ];
        });
    }

    /**
     * Limpiar caché relacionado con artículos
     */
    public function limpiarCacheArticulos(): void
    {
        $keys = [
            'articulos_estadisticas',
            'articulos_por_categoria',
            'articulos_por_temporada',
            'form_data_articulos'
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Limpiar caché de búsquedas (patrón)
        $pattern = 'articulos_search_*';
        $pattern2 = 'articulos_populares_*';
        $pattern3 = 'articulos_recientes_*';
        
        // En un entorno real, usar Redis con SCAN o implementar cache tags
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("articulos_populares_{$i}");
            Cache::forget("articulos_recientes_{$i}");
        }
    }
}
