<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     protected $tableName = 'psychosocial_accompaniment_question';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            // Clave foránea a la tabla de acompañamientos
            $table->foreignId('psychosocial_accompaniment_id')
                  ->constrained('psychosocial_accompaniments') // Asumiendo el nombre de la tabla anterior
                  ->cascadeOnDelete(); // Equivalente a ON DELETE CASCADE

            // Clave foránea a la tabla de preguntas
            $table->foreignId('question_id')
                  ->constrained('questions') // Asumiendo el nombre de la tabla de preguntas
                  ->cascadeOnDelete();

            // Campo extra en la tabla pivote
            $table->decimal('value', 12, 2)->comment('Valor numérico de la respuesta a la pregunta.');

            // Definición de la clave primaria compuesta
            $table->primary(['psychosocial_accompaniment_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychosocial_accompaniment_question');
    }
};
