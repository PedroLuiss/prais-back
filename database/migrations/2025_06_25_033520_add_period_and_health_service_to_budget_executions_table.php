<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     protected $tableName = 'budget_executions'; // ejecuciones presupuestarias
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       // Usamos Schema::table() para modificar una tabla existente.
        Schema::table($this->tableName, function (Blueprint $table) {
            // $table->string('period', 7)->nullable()->comment('Mes y año de la ejecución presupuestaria (MM-YYYY)')->after('id'); // 'after' es opcional pero mejora el orden

            // // Asumiendo que la tabla servicio_salud es 'health_services' en tu app
            // $table->foreignId('health_service_id')
            //       ->nullable() // ¡Importante! Para no dar error en tablas con datos existentes
            //       ->comment('ID del servicio de salud al que pertenece esta ejecución presupuestaria')
            //       ->constrained('health_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            // Para revertir, primero se elimina la restricción de clave foránea
            $table->dropForeign(['health_service_id']);

            // Luego se eliminan las columnas
            $table->dropColumn(['period', 'health_service_id']);
        });
    }
};
