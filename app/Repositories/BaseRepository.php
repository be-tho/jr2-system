<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Obtener todos los registros
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Obtener registro por ID
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Obtener registro por ID o fallar
     */
    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Crear nuevo registro
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Actualizar registro existente
     */
    public function update(int $id, array $data): bool
    {
        $record = $this->find($id);
        if (!$record) {
            return false;
        }
        return $record->update($data);
    }

    /**
     * Eliminar registro
     */
    public function delete(int $id): bool
    {
        $record = $this->find($id);
        if (!$record) {
            return false;
        }
        return $record->delete();
    }

    /**
     * Paginación básica
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Contar registros
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Ejecutar consulta en transacción
     */
    protected function executeInTransaction(callable $callback)
    {
        return DB::transaction($callback);
    }

    /**
     * Aplicar filtros básicos
     */
    protected function applyFilters($query, array $filters): void
    {
        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }
    }

    /**
     * Aplicar ordenamiento
     */
    protected function applyOrdering($query, string $orderBy = 'id', string $direction = 'desc'): void
    {
        // Mapear valores lógicos a columnas de base de datos
        $columnMapping = [
            // Ordenamiento general
            'latest' => 'created_at',
            'oldest' => 'created_at',
            
            // Campos de artículos
            'nombre_asc' => 'nombre',
            'nombre_desc' => 'nombre',
            'precio_asc' => 'precio',
            'precio_desc' => 'precio',
            'stock_asc' => 'stock',
            'stock_desc' => 'stock',
            'codigo_asc' => 'codigo',
            'codigo_desc' => 'codigo',
            
            // Campos de cortes
            'numero_asc' => 'numero_corte',
            'numero_desc' => 'numero_corte',
            'fecha_asc' => 'fecha',
            'fecha_desc' => 'fecha',
            'estado_asc' => 'estado',
            'estado_desc' => 'estado',
            'cantidad_asc' => 'cantidad',
            'cantidad_desc' => 'cantidad',
        ];

        $actualColumn = $columnMapping[$orderBy] ?? $orderBy;
        $query->orderBy($actualColumn, $direction);
    }

    /**
     * Aplicar búsqueda en campos específicos
     */
    protected function applySearch($query, string $search, array $searchableFields): void
    {
        if ($search && !empty($searchableFields)) {
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }
    }
}
