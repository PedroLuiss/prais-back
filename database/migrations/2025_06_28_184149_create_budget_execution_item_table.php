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
        // El nombre de la tabla sigue la convención de Laravel para tablas pivote:
        // (modelo1_singular)_(modelo2_singular) en orden alfabético.
        // Asumiendo que tus modelos se llaman 'BudgetExecution' y 'Item'.
        Schema::create('budget_execution_item', function (Blueprint $table) {

            // Columna: budget_execution_id
            // Equivalente a: id_ejecucion INTEGER NOT NULL REFERENCES ...
            // constrained() infiere la tabla 'budget_executions' y la columna 'id'.
            $table->foreignId('budget_execution_id')->constrained('budget_executions')->onDelete('cascade');

            // Columna: item_id
            // Equivalente a: id_item INTEGER NOT NULL REFERENCES ...
            // constrained() infiere la tabla 'items' y la columna 'id'.
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');

            // Columna: value (columna extra en la tabla pivote)
            // Equivalente a: valor NUMERIC(12,2) NOT NULL
            $table->decimal('value', 12, 2);

            // Llave primaria compuesta
            // Equivalente a: PRIMARY KEY (id_ejecucion, id_item)
            $table->primary(['budget_execution_id', 'item_id']);

            // Esta tabla no necesita timestamps si solo almacena la relación y el valor.
            // Si quieres registrar cuándo se creó o actualizó la relación, descomenta la siguiente línea:
            // $table->timestamps();
        });

        // Añadir comentarios a la tabla y columnas, específico para PostgreSQL
        DB::statement("COMMENT ON TABLE budget_execution_item IS 'Relación entre ejecución presupuestaria e ítems ejecutados'");
        DB::statement("COMMENT ON COLUMN budget_execution_item.value IS 'Monto en pesos chilenos ejecutado para este ítem'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_execution_item');
    }
};
