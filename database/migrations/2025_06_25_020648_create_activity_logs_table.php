<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     protected $tableName = 'activity_logs'; // Historial_actividad

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id()->comment('Identificador único del historial de actividad');

            $table->foreignId('user_id')
                ->comment('Usuario que realizó la acción')
                ->constrained('users'); // Asumiendo tabla 'users'

            $table->string('module', 50)->comment('Módulo afectado por la acción (Ej: Beneficiario, Acompañamiento, etc)');

            $table->text('description')->comment('Descripción de la acción realizada');

            // Esta es la forma elegante de Laravel para manejar las columnas polimórficas
            // 'id_objeto_afectado' y 'tipo_objeto_afectado'.
            // El método `morphs` crea las columnas `loggable_id` (BIGINT) y `loggable_type` (VARCHAR).
            // Lo hacemos manualmente para poder añadir comentarios.
            $table->unsignedBigInteger('loggable_id')->nullable()->comment('ID del objeto afectado (Ej: id_beneficiario, id_presupuesto)');
            $table->string('loggable_type')->nullable()->comment('Nombre de la entidad afectada (beneficiario, ejecucion_presupuestaria, etc)');
            $table->index(['loggable_id', 'loggable_type']); // Un índice es muy recomendable para estas columnas.

            // 'fecha_actividad' se maneja con 'created_at'.
            $table->timestamp('created_at')->useCurrent()->comment('Fecha y hora en que ocurrió la acción');
            // Un log no se actualiza, por lo que omitimos 'updated_at'.
        });

        // Comentario general para la tabla
        DB::statement("COMMENT ON TABLE {$this->tableName} IS 'Registro de acciones realizadas en el sistema por los usuarios, agrupadas por módulo'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
