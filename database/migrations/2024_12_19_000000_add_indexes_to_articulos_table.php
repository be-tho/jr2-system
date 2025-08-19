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
        Schema::table('articulos', function (Blueprint $table) {
            // Índice para búsqueda por nombre
            $table->index('nombre');
            
            // Índice para búsqueda por código
            $table->index('codigo');
            
            // Índice compuesto para búsquedas frecuentes
            $table->index(['nombre', 'codigo']);
            
            // Índice para ordenamiento
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropIndex(['nombre']);
            $table->dropIndex(['codigo']);
            $table->dropIndex(['nombre', 'codigo']);
            $table->dropIndex(['created_at']);
        });
    }
};
