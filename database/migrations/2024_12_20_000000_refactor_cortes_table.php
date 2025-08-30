<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cortes', function (Blueprint $table) {
            // Agregar nuevos campos
            $table->string('tipo_tela')->after('numero_corte');
            $table->integer('cantidad_encimadas')->after('tipo_tela');
        });

        // Manejar el renombrado de columnas de manera segura
        Schema::table('cortes', function (Blueprint $table) {
            // Solo renombrar si nombre existe y descripcion no existe
            if (Schema::hasColumn('cortes', 'nombre') && !Schema::hasColumn('cortes', 'descripcion')) {
                $table->renameColumn('nombre', 'descripcion');
            }
            
            // Solo renombrar si cantidad existe y cantidad_total no existe
            if (Schema::hasColumn('cortes', 'cantidad') && !Schema::hasColumn('cortes', 'cantidad_total')) {
                $table->renameColumn('cantidad', 'cantidad_total');
            }
        });

        // Cambiar el tipo de columna colores a JSON
        Schema::table('cortes', function (Blueprint $table) {
            $table->json('colores')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cortes', function (Blueprint $table) {
            // Revertir cambios
            $table->dropColumn(['tipo_tela', 'cantidad_encimadas']);
        });

        Schema::table('cortes', function (Blueprint $table) {
            // Revertir renombrado solo si es necesario
            if (Schema::hasColumn('cortes', 'descripcion') && !Schema::hasColumn('cortes', 'nombre')) {
                $table->renameColumn('descripcion', 'nombre');
            }
            
            if (Schema::hasColumn('cortes', 'cantidad_total') && !Schema::hasColumn('cortes', 'cantidad')) {
                $table->renameColumn('cantidad_total', 'cantidad');
            }
        });

        // Revertir colores a string
        Schema::table('cortes', function (Blueprint $table) {
            $table->string('colores')->change();
        });
    }
};
