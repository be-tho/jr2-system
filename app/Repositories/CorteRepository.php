<?php

namespace App\Repositories;

use App\Models\Corte;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CorteRepository extends BaseRepository
{
    public function __construct(Corte $model)
    {
        parent::__construct($model);
    }

    /**
     * Obtener cortes paginados con filtros avanzados
     */
    public function getPaginatedWithFilters(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->query();

        // Aplicar búsqueda
        if (!empty($filters['search'])) {
            $this->applySearch($query, $filters['search'], ['numero_corte', 'descripcion', 'tipo_tela']);
        }

        // Aplicar filtros de estado
        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('estado', $filters['estado']);
        }

        // Aplicar filtros de fecha
        if (!empty($filters['fecha'])) {
            $this->applyDateFilter($query, $filters['fecha']);
        }

        if (!empty($filters['fecha_desde'])) {
            $query->whereDate('fecha', '>=', $filters['fecha_desde']);
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->whereDate('fecha', '<=', $filters['fecha_hasta']);
        }

        // Aplicar ordenamiento
        $this->applyOrdering($query, $filters['order_by'] ?? 'created_at', $filters['order_direction'] ?? 'desc');

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Aplicar filtros de fecha predefinidos
     */
    private function applyDateFilter($query, string $dateFilter): void
    {
        switch ($dateFilter) {
            case 'today':
                $query->whereDate('fecha', today());
                break;
            case 'week':
                $query->whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('fecha', now()->month);
                break;
            case 'year':
                $query->whereYear('fecha', now()->year);
                break;
        }
    }

    /**
     * Obtener estadísticas de cortes
     */
    public function getStats(): array
    {
        $stats = DB::table('cortes')
            ->selectRaw('
                COUNT(*) as total_cortes,
                SUM(cantidad_total) as total_articulos,
                SUM(cantidad_encimadas) as total_encimadas,
                COUNT(CASE WHEN estado = 0 THEN 1 END) as cortados,
                COUNT(CASE WHEN estado = 1 THEN 1 END) as costurando,
                COUNT(CASE WHEN estado = 2 THEN 1 END) as entregados,
                COUNT(CASE WHEN estado IN (0, 1) THEN 1 END) as pendientes
            ')
            ->first();

        return [
            'total_cortes' => $stats->total_cortes ?? 0,
            'total_articulos' => $stats->total_articulos ?? 0,
            'total_encimadas' => $stats->total_encimadas ?? 0,
            'cortados' => $stats->cortados ?? 0,
            'costurando' => $stats->costurando ?? 0,
            'entregados' => $stats->entregados ?? 0,
            'pendientes' => $stats->pendientes ?? 0,
        ];
    }

    /**
     * Obtener cortes agrupados por estado
     */
    public function getGroupedByEstado(): SupportCollection
    {
        $estadoNombres = [
            0 => 'Cortado',
            1 => 'Costurando', 
            2 => 'Entregado',
            'unknown' => 'Desconocido'
        ];
        
        // Obtener el total de cortes para calcular porcentajes
        $totalCortes = $this->model->count();
        
        $estados = $this->model
            ->select('estado')
            ->selectRaw('COUNT(*) as cantidad, SUM(cantidad_total) as total_articulos')
            ->groupBy('estado')
            ->get();

        $result = [];
        foreach ($estados as $item) {
            $estadoKey = $item->estado !== null ? $item->estado : 'unknown';
            $porcentaje = $totalCortes > 0 ? round(($item->cantidad / $totalCortes) * 100, 1) : 0;
            
            $result[$estadoKey] = [
                'estado' => $estadoNombres[$estadoKey] ?? 'Desconocido',
                'cantidad' => $item->cantidad,
                'total_articulos' => $item->total_articulos,
                'porcentaje' => $porcentaje,
            ];
        }
        
        return collect($result);
    }

    /**
     * Obtener cortes agrupados por mes
     */
    public function getGroupedByMes(): SupportCollection
    {
        $meses = $this->model
            ->selectRaw('
                DATE_FORMAT(fecha, "%Y-%m") as mes,
                COUNT(*) as cantidad,
                SUM(cantidad_total) as total_articulos
            ')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $result = [];
        foreach ($meses as $item) {
            $mesKey = $item->mes !== null ? $item->mes : 'unknown';
            $result[$mesKey] = [
                'cantidad' => $item->cantidad,
                'total_articulos' => $item->total_articulos,
            ];
        }
        
        return collect($result);
    }

    /**
     * Obtener cortes por estado específico
     */
    public function getByEstado(int $estado): Collection
    {
        return $this->model
            ->where('estado', $estado)
            ->orderBy('fecha', 'desc')
            ->get();
    }

    /**
     * Obtener cortes pendientes (estado 0 y 1)
     */
    public function getPendientes(): Collection
    {
        return $this->model
            ->whereIn('estado', [0, 1])
            ->orderBy('fecha', 'asc')
            ->get();
    }

    /**
     * Obtener cortes por rango de fechas
     */
    public function getByDateRange(string $fechaDesde, string $fechaHasta): Collection
    {
        return $this->model
            ->whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->orderBy('fecha', 'desc')
            ->get();
    }

    /**
     * Obtener cortes del día actual
     */
    public function getToday(): Collection
    {
        return $this->model
            ->whereDate('fecha', today())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtener cortes de la semana actual
     */
    public function getThisWeek(): Collection
    {
        return $this->model
            ->whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('fecha', 'desc')
            ->get();
    }

    /**
     * Obtener cortes del mes actual
     */
    public function getThisMonth(): Collection
    {
        return $this->model
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->orderBy('fecha', 'desc')
            ->get();
    }

    /**
     * Obtener el siguiente número de corte
     */
    public function getNextNumeroCorte(): int
    {
        $lastCorte = $this->model
            ->orderBy('numero_corte', 'desc')
            ->first();

        return $lastCorte ? $lastCorte->numero_corte + 1 : 1;
    }

    /**
     * Verificar si existe un número de corte
     */
    public function numeroCorteExists(int $numeroCorte): bool
    {
        return $this->model->where('numero_corte', $numeroCorte)->exists();
    }

    /**
     * Obtener tipos de tela únicos
     */
    public function getTiposTela(): Collection
    {
        return $this->model
            ->select('tipo_tela')
            ->distinct()
            ->whereNotNull('tipo_tela')
            ->orderBy('tipo_tela')
            ->get();
    }

    /**
     * Obtener cortes por tipo de tela
     */
    public function getByTipoTela(string $tipoTela): Collection
    {
        return $this->model
            ->where('tipo_tela', $tipoTela)
            ->orderBy('fecha', 'desc')
            ->get();
    }
}
