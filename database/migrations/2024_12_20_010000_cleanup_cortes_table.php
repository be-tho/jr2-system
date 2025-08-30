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
        Schema::table('cortes', function (Blueprint $table) {
            // Verificar si las columnas existen antes de intentar renombrarlas
            if (Schema::hasColumn('cortes', 'nombre') && !Schema::hasColumn('cortes', 'descripcion')) {
                $table->renameColumn('nombre', 'descripcion');
            }
            
            if (Schema::hasColumn('cortes', 'cantidad') && !Schema::hasColumn('cortes', 'cantidad_total')) {
                $table->renameColumn('cantidad', 'cantidad_total');
            }
        });

        // Cambiar el tipo de columna colores a JSON usando SQL directo
        try {
            DB::statement('ALTER TABLE cortes MODIFY COLUMN colores JSON');
        } catch (\Exception $e) {
            // Si ya es JSON, ignorar el error
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cortes', function (Blueprint $table) {
            // Revertir cambios si es necesario
            if (Schema::hasColumn('cortes', 'descripcion') && !Schema::hasColumn('cortes', 'nombre')) {
                $table->renameColumn('descripcion', 'nombre');
            }
            
            if (Schema::hasColumn('cortes', 'cantidad_total') && !Schema::hasColumn('cortes', 'cantidad')) {
                $table->renameColumn('cantidad_total', 'cantidad');
            }
        });

        // Revertir colores a string
        try {
            DB::statement('ALTER TABLE cortes MODIFY COLUMN colores VARCHAR(255)');
        } catch (\Exception $e) {
            // Ignorar errores
        }
    }
};
