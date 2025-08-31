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
        Schema::create('costureros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->text('direccion');
            $table->string('celular');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento de búsquedas
            $table->index('nombre_completo');
            $table->index('celular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costureros');
    }
};
