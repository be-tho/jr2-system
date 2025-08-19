<?php

namespace App\Repositories;

use App\Models\Articulo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class ArticuloRepository extends BaseRepository
{
    public function __construct(Articulo $model)
    {
        parent::__construct($model);
    }

    /**
     * Obtener artículos con relaciones optimizadas
     */
    public function getWithRelations(array $relations = ['categoria:id,nombre', 'temporada:id,nombre']): Collection
    {
        return $this->model->with($relations)->get();
    }

    /**
     * Obtener artículos paginados con filtros avanzados
     */
    public function getPaginatedWithFilters(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->with(['categoria:id,nombre', 'temporada:id,nombre']);

        // Aplicar búsqueda
        if (!empty($filters['search'])) {
            $this->applySearch($query, $filters['search'], ['nombre', 'descripcion', 'codigo']);
        }

        // Aplicar filtros de categoría
        if (!empty($filters['categoria_id'])) {
            $query->where('categoria_id', $filters['categoria_id']);
        }

        // Aplicar filtros de temporada
        if (!empty($filters['temporada_id'])) {
            $query->where('temporada_id', $filters['temporada_id']);
        }

        // Aplicar filtros de stock
        if (!empty($filters['stock_min'])) {
            $query->where('stock', '>=', $filters['stock_min']);
        }

        if (!empty($filters['stock_max'])) {
            $query->where('stock', '<=', $filters['stock_max']);
        }

        // Aplicar filtros de precio
        if (!empty($filters['precio_min'])) {
            $query->where('precio', '>=', $filters['precio_min']);
        }

        if (!empty($filters['precio_max'])) {
            $query->where('precio', '<=', $filters['precio_max']);
        }

        // Aplicar ordenamiento
        $this->applyOrdering($query, $filters['order_by'] ?? 'created_at', $filters['order_direction'] ?? 'desc');

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Obtener estadísticas de artículos
     */
    public function getStats(): array
    {
        $stats = DB::table('articulos')
            ->selectRaw('
                COUNT(*) as total_articulos,
                SUM(stock) as stock_total,
                SUM(precio * stock) as valor_total_inventario,
                AVG(precio) as precio_promedio,
                COUNT(CASE WHEN stock = 0 THEN 1 END) as articulos_sin_stock,
                COUNT(CASE WHEN stock > 0 AND stock <= 10 THEN 1 END) as articulos_stock_bajo
            ')
            ->first();

        return [
            'total_articulos' => $stats->total_articulos ?? 0,
            'stock_total' => $stats->stock_total ?? 0,
            'valor_total' => $stats->valor_total_inventario ?? 0,
            'promedio_precio' => round($stats->precio_promedio ?? 0, 2),
            'articulos_sin_stock' => $stats->articulos_sin_stock ?? 0,
            'articulos_stock_bajo' => $stats->articulos_stock_bajo ?? 0,
        ];
    }

    /**
     * Obtener artículos agrupados por categoría
     */
    public function getGroupedByCategoria(): SupportCollection
    {
        $categorias = $this->model
            ->select('categoria_id', 'categoria.nombre as categoria_nombre')
            ->selectRaw('COUNT(*) as cantidad, SUM(precio) as valor_total, SUM(stock) as stock_total')
            ->join('categoria', 'articulos.categoria_id', '=', 'categoria.id')
            ->groupBy('categoria_id', 'categoria.nombre')
            ->orderBy('categoria.nombre')
            ->get();

        $result = [];
        foreach ($categorias as $item) {
            $categoriaNombre = $item->categoria_nombre !== null ? $item->categoria_nombre : 'Sin categoría';
            $result[$categoriaNombre] = [
                'cantidad' => $item->cantidad,
                'valor_total' => $item->valor_total,
                'stock_total' => $item->stock_total,
            ];
        }
        
        return collect($result);
    }

    /**
     * Obtener artículos agrupados por temporada
     */
    public function getGroupedByTemporada(): SupportCollection
    {
        $temporadas = $this->model
            ->select('temporada_id', 'temporada.nombre as temporada_nombre')
            ->selectRaw('COUNT(*) as cantidad, SUM(precio) as valor_total, SUM(stock) as stock_total')
            ->join('temporada', 'articulos.temporada_id', '=', 'temporada.id')
            ->groupBy('temporada_id', 'temporada.nombre')
            ->orderBy('temporada.nombre')
            ->get();

        $result = [];
        foreach ($temporadas as $item) {
            $temporadaNombre = $item->temporada_nombre !== null ? $item->temporada_nombre : 'Sin temporada';
            $result[$temporadaNombre] = [
                'cantidad' => $item->cantidad,
                'valor_total' => $item->valor_total,
                'stock_total' => $item->stock_total,
            ];
        }
        
        return collect($result);
    }

    /**
     * Obtener artículos con stock bajo
     */
    public function getLowStock(int $threshold = 10): Collection
    {
        return $this->model
            ->where('stock', '>', 0)
            ->where('stock', '<=', $threshold)
            ->with(['categoria:id,nombre', 'temporada:id,nombre'])
            ->orderBy('stock', 'asc')
            ->get();
    }

    /**
     * Obtener artículos sin stock
     */
    public function getOutOfStock(): Collection
    {
        return $this->model
            ->where('stock', 0)
            ->with(['categoria:id,nombre', 'temporada:id,nombre'])
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Buscar artículos por término
     */
    public function search(string $term): Collection
    {
        return $this->model
            ->where(function ($query) use ($term) {
                $query->where('nombre', 'like', "%{$term}%")
                      ->orWhere('descripcion', 'like', "%{$term}%")
                      ->orWhere('codigo', 'like', "%{$term}%");
            })
            ->with(['categoria:id,nombre', 'temporada:id,nombre'])
            ->get();
    }

    /**
     * Obtener artículos por rango de precios
     */
    public function getByPriceRange(float $minPrice, float $maxPrice): Collection
    {
        return $this->model
            ->whereBetween('precio', [$minPrice, $maxPrice])
            ->with(['categoria:id,nombre', 'temporada:id,nombre'])
            ->orderBy('precio')
            ->get();
    }

    /**
     * Obtener artículos por rango de stock
     */
    public function getByStockRange(int $minStock, int $maxStock): Collection
    {
        return $this->model
            ->whereBetween('stock', [$minStock, $maxStock])
            ->with(['categoria:id,nombre', 'temporada:id,nombre'])
            ->orderBy('stock')
            ->get();
    }
}
