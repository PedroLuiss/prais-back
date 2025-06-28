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
        Schema::create('emotional_interventions', function (Blueprint $table) {
            $table->date('intervention_date')->comment('Fecha en que se realizó la intervención.');
            $table->text('description')->comment('Descripción del contenido de la intervención.');
            $table->string('type', 50)->comment('Tipo de intervención realizada.');
             $table->unsignedBigInteger('beneficiary_id')->comment('Beneficiario al que se le hizo la intervención.');
            $table->foreign('beneficiary_id')
                ->references('id')
                ->on('beneficiaries');
            $table->foreignId('user_id')
                ->comment('Usuario que registró la intervención.')
                ->constrained('users');

            $table->timestamps();
        });
        DB::statement("COMMENT ON TABLE emotional_interventions IS 'Intervenciones de apoyo emocional realizadas a beneficiarios.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emotional_interventions');
    }
};
