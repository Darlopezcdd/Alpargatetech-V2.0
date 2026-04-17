<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla de auditoría del sistema.
 * Registra TODAS las acciones importantes: login, creación, edición, eliminación.
 * 'action'      : nombre corto de la acción (Login, Create Product, Delete Order)
 * 'description' : detalle legible para el administrador
 * 'ip_address'  : IP del usuario al momento de la acción
 * No usa SoftDelete — los logs son inmutables.
 * Índice en (user_id, created_at) para consultas del historial por usuario.
 * Índice en created_at para filtros por fecha.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('audit_logs')) {
            return; // Ya existe — instalación existente
        }

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('Usuario que realizó la acción — null si fue sistema');
            $table->string('action', 100)
                  ->comment('Nombre corto: Login | Create Product | Delete Order | etc.');
            $table->text('description')
                  ->nullable()
                  ->comment('Detalle legible de la acción para el administrador');
            $table->string('ip_address', 45)
                  ->nullable()
                  ->comment('IPv4 o IPv6 del usuario (45 chars cubre IPv6)');
            $table->timestamps(); // created_at = momento del evento

            // Consultas frecuentes
            $table->index(['user_id', 'created_at'], 'idx_audit_user_date');
            $table->index('created_at', 'idx_audit_date');
            $table->index('action', 'idx_audit_action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
