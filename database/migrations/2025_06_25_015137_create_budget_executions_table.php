<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budget_executions', function (Blueprint $table) {
            $table->id()->comment('Identificador único del registro de ejecución.');
            $table->unsignedTinyInteger('month')->comment('Mes correspondiente al gasto registrado.')->checkBetween(1, 12);
            $table->year('year')->comment('Año del gasto registrado.');
            $table->string('expense_type', 100)->comment('Categoría del gasto (RRHH, actividades, etc.).');
            $table->decimal('amount', 12, 2)->comment('Monto ejecutado.');
            $table->text('support_file')->nullable()->comment('Archivo de respaldo (factura, convenio, acta).');
            $table->unsignedBigInteger('created_by')->comment('Usuario que registró el gasto.');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');

             $table->string('period', 7)->nullable()->comment('Mes y año de la ejecución presupuestaria (MM-YYYY)')->after('id'); // 'after' es opcional pero mejora el orden

            // Asumiendo que la tabla servicio_salud es 'health_services' en tu app
            $table->foreignId('health_service_id')
                  ->nullable() // ¡Importante! Para no dar error en tablas con datos existentes
                  ->comment('ID del servicio de salud al que pertenece esta ejecución presupuestaria')
                  ->constrained('health_services');
        });
        DB::statement("COMMENT ON TABLE budget_executions IS 'Tabla: Ejecución Presupuestaria'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_executions');
    }
};
