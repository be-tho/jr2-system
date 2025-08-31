<?php

namespace App\Repositories;

use App\Models\Costurero;
use Illuminate\Pagination\LengthAwarePaginator;

class CostureroRepository extends BaseRepository
{
    public function __construct(Costurero $model)
    {
        parent::__construct($model);
    }

    /**
     * Obtener costureros paginados con filtros
     */
    public function getPaginatedWithFilters(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        // Aplicar búsqueda
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Aplicar ordenamiento
        $orderBy = $filters['order_by'] ?? 'latest';
        $orderDirection = $filters['order_direction'] ?? 'desc';

        switch ($orderBy) {
            case 'nombre_asc':
                $query->orderByNombre('asc');
                break;
            case 'nombre_desc':
                $query->orderByNombre('desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate($perPage);
    }

    /**
     * Obtener todos los costureros para select
     */
    public function getAllForSelect(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->select('id', 'nombre_completo')
            ->orderBy('nombre_completo')
            ->get();
    }
}
