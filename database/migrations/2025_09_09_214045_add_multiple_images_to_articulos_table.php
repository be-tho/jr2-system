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
            // Agregar campos para múltiples imágenes
            $table->string('imagen_2')->nullable()->after('imagen');
            $table->string('imagen_3')->nullable()->after('imagen_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            // Eliminar campos de múltiples imágenes
            $table->dropColumn(['imagen_2', 'imagen_3']);
        });
    }
};
