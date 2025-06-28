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
     * Ejecuta las migraciones para crear la tabla pivote 'notification_alert_user'.
     */
    public function up(): void
    {
        // El nombre de la tabla sigue la convención de Laravel para tablas pivote:
        // (modelo1_singular)_(modelo2_singular) en orden alfabético.
        // Asumiendo modelos 'NotificationAlert' y 'User'.
        Schema::create('notification_alert_user', function (Blueprint $table) {

            // Columna: user_id
            // Equivalente a: id_usuario INTEGER NOT NULL REFERENCES usuario(id_usuario)
            // constrained('users') infiere la tabla 'users' y la columna 'id'.
            // ¡Asegúrate que tu tabla de usuarios se llame 'users'!
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Columna: notification_alert_id
            // Equivalente a: id_alerta INTEGER NOT NULL REFERENCES alerta_notificacion(id_alerta)
            // ¡Asegúrate que tu tabla de alertas se llame 'notification_alerts'!
            $table->foreignId('notification_alert_id')->constrained('notification_alerts')->onDelete('cascade');

            // Columna: status (columna extra en la tabla pivote)
            // Equivalente a: estado BOOLEAN NOT NULL DEFAULT TRUE
            $table->boolean('status')->default(true);

            // Llave primaria compuesta
            // Equivalente a: PRIMARY KEY (sid_usuario, id_alerta)
            $table->primary(['user_id', 'notification_alert_id']);

            // Laravel recomienda añadir timestamps a las tablas pivote
            // para saber cuándo se creó o actualizó la relación.
            $table->timestamps();
        });

        // Añadir comentarios a la tabla y columnas, específico para PostgreSQL
        if (DB::connection()->getDriverName() == 'pgsql') {
            DB::statement("COMMENT ON TABLE notification_alert_user IS 'Relación entre usuarios y las alertas activadas/desactivadas para ellos'");
            DB::statement("COMMENT ON COLUMN notification_alert_user.status IS 'TRUE = alerta activada para el usuario, FALSE = desactivada'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * Revierte las migraciones, eliminando la tabla 'notification_alert_user'.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_alert_user');
    }
};
