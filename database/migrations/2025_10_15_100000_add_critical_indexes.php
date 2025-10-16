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
        // Verificar si estamos usando MySQL/MariaDB para FULLTEXT
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql' || $driver === 'mariadb') {
            // Agregar índice FULLTEXT para búsquedas en artículos
            Schema::table('articulos', function (Blueprint $table) {
                // Verificar si el índice FULLTEXT ya existe
                $indexes = $this->getExistingIndexes('articulos');
                
                if (!in_array('articulos_fulltext_search', $indexes)) {
                    $table->fullText(['nombre', 'descripcion', 'codigo'], 'articulos_fulltext_search');
                }
            });
        }

        // Índices compuestos para ventas
        Schema::table('ventas', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('ventas');
            
            // Índice compuesto para reportes por usuario y fecha
            if (!in_array('ventas_user_fecha_index', $indexes)) {
                $table->index(['user_id', 'fecha_venta'], 'ventas_user_fecha_index');
            }
            
            // Índice para filtros por monto
            if (!in_array('ventas_total_index', $indexes)) {
                $table->index('total', 'ventas_total_index');
            }
            
            // Índice compuesto para búsquedas por cliente y fecha
            if (!in_array('ventas_cliente_fecha_index', $indexes)) {
                $table->index(['cliente_nombre', 'fecha_venta'], 'ventas_cliente_fecha_index');
            }
        });

        // Índices compuestos para venta_items
        Schema::table('venta_items', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('venta_items');
            
            // Índice compuesto para joins optimizados
            if (!in_array('venta_items_articulo_venta_index', $indexes)) {
                $table->index(['articulo_id', 'venta_id'], 'venta_items_articulo_venta_index');
            }
            
            // Índice para reportes de artículos más vendidos
            if (!in_array('venta_items_cantidad_index', $indexes)) {
                $table->index('cantidad', 'venta_items_cantidad_index');
            }
            
            // Índice para reportes por subtotal
            if (!in_array('venta_items_subtotal_index', $indexes)) {
                $table->index('subtotal', 'venta_items_subtotal_index');
            }
        });

        // Índices adicionales para artículos
        Schema::table('articulos', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('articulos');
            
            // Índice compuesto para búsquedas por categoría y stock
            if (!in_array('articulos_categoria_stock_index', $indexes)) {
                $table->index(['categoria_id', 'stock'], 'articulos_categoria_stock_index');
            }
            
            // Índice compuesto para búsquedas por temporada y precio
            if (!in_array('articulos_temporada_precio_index', $indexes)) {
                $table->index(['temporada_id', 'precio'], 'articulos_temporada_precio_index');
            }
            
            // Índice para búsquedas por código (si no existe)
            if (!in_array('articulos_codigo_index', $indexes)) {
                $table->index('codigo', 'articulos_codigo_index');
            }
        });

        // Índices adicionales para cortes
        Schema::table('cortes', function (Blueprint $table) {
            $indexes = $this->getExistingIndexes('cortes');
            
            // Índice compuesto para reportes por estado y fecha
            if (!in_array('cortes_estado_fecha_index', $indexes)) {
                $table->index(['estado', 'fecha'], 'cortes_estado_fecha_index');
            }
            
            // Índice para búsquedas por tipo de tela
            if (!in_array('cortes_tipo_tela_index', $indexes)) {
                $table->index('tipo_tela', 'cortes_tipo_tela_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar índices FULLTEXT
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropIndex('articulos_fulltext_search');
        });

        // Eliminar índices de ventas
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropIndex('ventas_user_fecha_index');
            $table->dropIndex('ventas_total_index');
            $table->dropIndex('ventas_cliente_fecha_index');
        });

        // Eliminar índices de venta_items
        Schema::table('venta_items', function (Blueprint $table) {
            $table->dropIndex('venta_items_articulo_venta_index');
            $table->dropIndex('venta_items_cantidad_index');
            $table->dropIndex('venta_items_subtotal_index');
        });

        // Eliminar índices adicionales de artículos
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropIndex('articulos_categoria_stock_index');
            $table->dropIndex('articulos_temporada_precio_index');
            $table->dropIndex('articulos_codigo_index');
        });

        // Eliminar índices adicionales de cortes
        Schema::table('cortes', function (Blueprint $table) {
            $table->dropIndex('cortes_estado_fecha_index');
            $table->dropIndex('cortes_tipo_tela_index');
        });
    }

    /**
     * Get existing indexes for a table
     */
    private function getExistingIndexes(string $table): array
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            return array_column($indexes, 'Key_name');
        } catch (\Exception $e) {
            // Si la tabla no existe o hay error, retornar array vacío
            return [];
        }
    }
};
