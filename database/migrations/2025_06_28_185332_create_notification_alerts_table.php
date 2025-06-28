<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Ejecuta las migraciones para crear la tabla 'notification_alerts'.
     */
    public function up(): void
    {
        Schema::create('notification_alerts', function (Blueprint $table) {
            // Columna: id
            // Equivalente a: id_alerta SERIAL PRIMARY KEY
            $table->id();

            // Columna: name
            // Equivalente a: nombre VARCHAR(100) NOT NULL
            $table->string('name', 100);

            // Columna: status
            // Equivalente a: estado BOOLEAN NOT NULL
            $table->boolean('status');

            // Columnas de timestamps estándar de Laravel (created_at, updated_at)
            $table->timestamps();
        });

        // Añadir comentarios a la tabla y columnas, específico para PostgreSQL
        DB::statement("COMMENT ON TABLE notification_alerts IS 'Tabla de alertas o notificaciones activas/inactivas'");
        DB::statement("COMMENT ON COLUMN notification_alerts.id IS 'Identificador único de la alerta o notificación'");
        DB::statement("COMMENT ON COLUMN notification_alerts.name IS 'Nombre de la alerta (Ej: vencimiento cuenta, documentos nuevos)'");
        DB::statement("COMMENT ON COLUMN notification_alerts.status IS 'Estado de la alerta: TRUE = activa, FALSE = inactiva'");
    }

    /**
     * Reverse the migrations.
     *
     * Revierte las migraciones, eliminando la tabla 'notification_alerts'.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_alerts');
    }
};
