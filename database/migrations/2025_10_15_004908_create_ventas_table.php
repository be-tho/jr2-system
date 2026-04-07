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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('cliente_nombre')->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamp('fecha_venta');
            $table->text('notas')->nullable();
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index(['fecha_venta']);
            $table->index(['cliente_nombre']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};