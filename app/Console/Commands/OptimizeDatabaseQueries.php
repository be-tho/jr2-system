<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class OptimizeDatabaseQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:optimize-queries {--analyze : Analyze query performance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize database queries and analyze performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database query optimization...');

        if ($this->option('analyze')) {
            $this->analyzeQueryPerformance();
        }

        $this->optimizeQueries();
        $this->clearCaches();
        
        $this->info('Database query optimization completed!');
    }

    /**
     * Analyze query performance
     */
    private function analyzeQueryPerformance()
    {
        $this->info('Analyzing query performance...');

        // Check for missing indexes
        $missingIndexes = $this->checkMissingIndexes();
        
        if (!empty($missingIndexes)) {
            $this->warn('Missing indexes found:');
            foreach ($missingIndexes as $index) {
                $this->line("  - {$index}");
            }
        } else {
            $this->info('All recommended indexes are present.');
        }

        // Analyze slow queries
        $slowQueries = $this->analyzeSlowQueries();
        
        if (!empty($slowQueries)) {
            $this->warn('Potentially slow queries detected:');
            foreach ($slowQueries as $query) {
                $this->line("  - {$query}");
            }
        } else {
            $this->info('No slow queries detected.');
        }
    }

    /**
     * Check for missing indexes
     */
    private function checkMissingIndexes(): array
    {
        $missingIndexes = [];

        // Check articulos table indexes
        $articulosIndexes = DB::select("SHOW INDEX FROM articulos");
        $articulosColumns = array_column($articulosIndexes, 'Column_name');
        
        $requiredArticulosIndexes = ['categoria_id', 'temporada_id', 'stock', 'precio'];
        foreach ($requiredArticulosIndexes as $index) {
            if (!in_array($index, $articulosColumns)) {
                $missingIndexes[] = "articulos.{$index}";
            }
        }

        // Check cortes table indexes
        $cortesIndexes = DB::select("SHOW INDEX FROM cortes");
        $cortesColumns = array_column($cortesIndexes, 'Column_name');
        
        $requiredCortesIndexes = ['estado', 'fecha', 'numero_corte'];
        foreach ($requiredCortesIndexes as $index) {
            if (!in_array($index, $cortesColumns)) {
                $missingIndexes[] = "cortes.{$index}";
            }
        }

        return $missingIndexes;
    }

    /**
     * Analyze slow queries
     */
    private function analyzeSlowQueries(): array
    {
        $slowQueries = [];

        // Check for queries without WHERE clauses on large tables
        $largeTables = ['articulos', 'cortes'];
        
        foreach ($largeTables as $table) {
            $count = DB::table($table)->count();
            if ($count > 1000) {
                $slowQueries[] = "SELECT * FROM {$table} (no WHERE clause, {$count} rows)";
            }
        }

        return $slowQueries;
    }

    /**
     * Optimize queries
     */
    private function optimizeQueries()
    {
        $this->info('Optimizing queries...');

        // Update table statistics
        $tables = ['articulos', 'cortes', 'categoria', 'temporada', 'costureros'];
        
        foreach ($tables as $table) {
            try {
                DB::statement("ANALYZE TABLE {$table}");
                $this->line("  ✓ Analyzed table: {$table}");
            } catch (\Exception $e) {
                $this->warn("  ✗ Failed to analyze table {$table}: " . $e->getMessage());
            }
        }

        // Optimize tables
        foreach ($tables as $table) {
            try {
                DB::statement("OPTIMIZE TABLE {$table}");
                $this->line("  ✓ Optimized table: {$table}");
            } catch (\Exception $e) {
                $this->warn("  ✗ Failed to optimize table {$table}: " . $e->getMessage());
            }
        }
    }

    /**
     * Clear caches
     */
    private function clearCaches()
    {
        $this->info('Clearing caches...');

        $cacheKeys = [
            'optimized_stats',
            'form_data',
            'categorias_for_filters',
            'categorias_for_form',
            'temporadas_for_filters',
            'temporadas_for_form',
            'general_stats',
            'performance_stats',
            'dashboard_stats',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear popular articles cache
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("popular_articulos_{$i}");
            Cache::forget("recent_cortes_{$i}");
        }

        $this->info('Caches cleared successfully.');
    }
}
