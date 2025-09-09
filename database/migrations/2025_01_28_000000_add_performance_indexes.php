<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            // Verificar si los índices ya existen antes de crearlos
            $indexes = $this->getExistingIndexes('articulos');
            
            if (!in_array('articulos_categoria_id_index', $indexes)) {
                $table->index('categoria_id');
            }
            if (!in_array('articulos_temporada_id_index', $indexes)) {
                $table->index('temporada_id');
            }
            if (!in_array('articulos_stock_index', $indexes)) {
                $table->index('stock');
            }
            if (!in_array('articulos_precio_index', $indexes)) {
                $table->index('precio');
            }
            if (!in_array('articulos_categoria_id_temporada_id_index', $indexes)) {
                $table->index(['categoria_id', 'temporada_id']);
            }
            if (!in_array('articulos_stock_precio_index', $indexes)) {
                $table->index(['stock', 'precio']);
            }
            if (!in_array('articulos_descripcion_index', $indexes)) {
                $table->index('descripcion');
            }
        });

        Schema::table('cortes', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('cortes');
            
            if (!in_array('cortes_estado_index', $indexes)) {
                $table->index('estado');
            }
            if (!in_array('cortes_fecha_index', $indexes)) {
                $table->index('fecha');
            }
            if (!in_array('cortes_numero_corte_index', $indexes)) {
                $table->index('numero_corte');
            }
            if (!in_array('cortes_estado_fecha_index', $indexes)) {
                $table->index(['estado', 'fecha']);
            }
            if (!in_array('cortes_fecha_created_at_index', $indexes)) {
                $table->index(['fecha', 'created_at']);
            }
        });

        Schema::table('categoria', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('categoria');
            
            if (!in_array('categoria_nombre_index', $indexes)) {
                $table->index('nombre');
            }
        });

        Schema::table('temporada', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('temporada');
            
            if (!in_array('temporada_nombre_index', $indexes)) {
                $table->index('nombre');
            }
        });

        Schema::table('costureros', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('costureros');
            
            if (!in_array('costureros_nombre_completo_index', $indexes)) {
                $table->index('nombre_completo');
            }
            if (!in_array('costureros_celular_index', $indexes)) {
                $table->index('celular');
            }
        });
    }

    /**
     * Get existing indexes for a table
     */
    private function getExistingIndexes(string $table): array
    {
        $indexes = DB::select("SHOW INDEX FROM {$table}");
        return array_column($indexes, 'Key_name');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropIndex(['categoria_id']);
            $table->dropIndex(['temporada_id']);
            $table->dropIndex(['stock']);
            $table->dropIndex(['precio']);
            $table->dropIndex(['categoria_id', 'temporada_id']);
            $table->dropIndex(['stock', 'precio']);
            $table->dropIndex(['descripcion']);
        });

        Schema::table('cortes', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropIndex(['fecha']);
            $table->dropIndex(['numero_corte']);
            $table->dropIndex(['estado', 'fecha']);
            $table->dropIndex(['fecha', 'created_at']);
        });

        Schema::table('categoria', function (Blueprint $table) {
            $table->dropIndex(['nombre']);
        });

        Schema::table('temporada', function (Blueprint $table) {
            $table->dropIndex(['nombre']);
        });

        Schema::table('costureros', function (Blueprint $table) {
            $table->dropIndex(['nombre_completo']);
            $table->dropIndex(['celular']);
        });
    }
};
