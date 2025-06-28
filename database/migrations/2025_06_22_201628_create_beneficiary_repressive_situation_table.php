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
        Schema::create('beneficiary_repressive_situation', function (Blueprint $table) {
            // Columna para 'beneficiaries'
            // SQL: id_beneficiario VARCHAR(20)
            $table->unsignedBigInteger('beneficiary_id', 20)->comment('ID del beneficiario relacionado.');

            // Columna para 'repressive_situations'
            // SQL: id_situacion INTEGER
            // Usamos unsignedBigInteger para que coincida con el tipo de la columna id() de Laravel.
            $table->unsignedBigInteger('repressive_situation_id')->comment('ID de la situación represiva.');

            // Definición de las llaves foráneas
            // Asumimos que las tablas se llaman 'beneficiaries' y 'repressive_situations'.
            // Y que sus claves primarias son 'id_beneficiario' y 'id' respectivamente.
            $table->foreign('beneficiary_id')
                  ->references('id')->on('beneficiaries')
                  ->onDelete('cascade');

            $table->foreign('repressive_situation_id')
                  ->references('id')->on('repressive_situations')
                  ->onDelete('cascade');

            // SQL: PRIMARY KEY (id_beneficiario, id_situacion)
            // Clave primaria compuesta para asegurar que cada par beneficiario-situación sea único.
            $table->primary(['beneficiary_id', 'repressive_situation_id']);
        });

        // Comentario para la tabla pivote
        DB::statement("COMMENT ON TABLE beneficiary_repressive_situation IS 'Relación entre beneficiarios y situaciones represivas.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_repressive_situation');
    }
};
