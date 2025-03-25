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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temporada_id')->constrained('temporada')->after('id')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categoria')->after('categoria_id')->onDelete('cascade');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('codigo');
            $table->integer('stock');
            $table->integer('precio');
            $table->string('imagen');
            $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
