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
        Schema::create('cortes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_corte');
            $table->string('nombre');
            $table->string('colores');
            $table->integer('cantidad');
            $table->string('articulos');
            $table->string('descripcion');
            $table->string('costureros');
            $table->boolean('estado')->default(0);
            $table->string('imagen');
            $table->string('imagen_alt')->nullable();
            $table->date('fecha')->format('d-m-Y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cortes');
    }
};
