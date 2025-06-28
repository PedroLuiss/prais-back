<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tableName = 'beneficiary_change_histories';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create($this->tableName, function (Blueprint $table) {
            $table->id()->comment('Identificador del cambio registrado.');

            // Clave foránea VARCHAR al beneficiario
           $table->foreignId('beneficiary_id')->constrained('beneficiaries')->onDelete('cascade');

            $table->string('field_modified', 100)->comment('Nombre del campo que fue modificado.');

            // Los valores anterior y nuevo pueden ser nulos (ej. al crear un nuevo registro)
            $table->text('old_value')->nullable()->comment('Valor anterior del campo.');
            $table->text('new_value')->nullable()->comment('Nuevo valor del campo.');

            // Clave foránea al usuario que realizó la modificación
            $table->foreignId('modified_by_user_id')
                  ->comment('Usuario que modificó el registro.')
                  ->constrained('users'); // Asumiendo que la tabla de usuarios es 'users'

            // 'fecha_modificacion' se maneja con el 'created_at' de Laravel
            // ya que un registro de historial se crea y no se modifica.
            $table->timestamps();

            // Un registro de historial no debería tener 'updated_at', por lo que lo omitimos.
        });

        // Agrega el comentario general a la tabla
        DB::statement("COMMENT ON TABLE {$this->tableName} IS 'Registro de cambios realizados sobre los beneficiarios.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_change_histories');
    }
};
