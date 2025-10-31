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
        Schema::table('ventas', function (Blueprint $table) {
            // Hacer user_id nullable para permitir pedidos online sin usuario registrado
            $table->foreignId('user_id')->nullable()->change();
            
            // Campos para pedidos online
            $table->string('numero_orden')->unique()->nullable()->after('id');
            $table->string('cliente_apellido')->nullable()->after('cliente_nombre');
            $table->string('cliente_email')->nullable()->after('cliente_apellido');
            $table->string('cliente_telefono')->nullable()->after('cliente_email');
            $table->enum('tipo', ['manual', 'online'])->default('manual')->after('cliente_telefono');
            $table->enum('estado', ['pendiente', 'procesado', 'completado', 'cancelado'])->default('pendiente')->after('tipo');
            
            // Índices para optimizar consultas
            $table->index('numero_orden');
            $table->index('tipo');
            $table->index('estado');
            $table->index('cliente_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Revertir user_id a NOT NULL (solo si no hay pedidos online)
            // $table->foreignId('user_id')->nullable(false)->change();
            
            $table->dropIndex(['numero_orden']);
            $table->dropIndex(['tipo']);
            $table->dropIndex(['estado']);
            $table->dropIndex(['cliente_email']);
            
            $table->dropColumn([
                'numero_orden',
                'cliente_apellido',
                'cliente_email',
                'cliente_telefono',
                'tipo',
                'estado'
            ]);
        });
    }
};
