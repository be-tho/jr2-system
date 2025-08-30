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
        // Eliminar columnas duplicadas si existen
        if (Schema::hasColumn('cortes', 'nombre')) {
            Schema::table('cortes', function (Blueprint $table) {
                $table->dropColumn('nombre');
            });
        }
        
        if (Schema::hasColumn('cortes', 'cantidad')) {
            Schema::table('cortes', function (Blueprint $table) {
                $table->dropColumn('cantidad');
            });
        }

        // Asegurar que colores sea JSON
        try {
            DB::statement('ALTER TABLE cortes MODIFY COLUMN colores JSON');
        } catch (\Exception $e) {
            // Ignorar errores si ya es JSON
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear columnas si es necesario
        if (!Schema::hasColumn('cortes', 'nombre')) {
            Schema::table('cortes', function (Blueprint $table) {
                $table->string('nombre')->after('cantidad_encimadas');
            });
        }
        
        if (!Schema::hasColumn('cortes', 'cantidad')) {
            Schema::table('cortes', function (Blueprint $table) {
                $table->integer('cantidad')->after('colores');
            });
        }
    }
};
