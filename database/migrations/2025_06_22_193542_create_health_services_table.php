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
        Schema::create('health_services', function (Blueprint $table) {
            $table->id()->comment('Identificador único del Servicio de Salud.');
            $table->string('name')->comment('Nombre del Servicio de Salud.');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE health_services IS 'Contiene los distintos Servicios de Salud disponibles.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_services');
    }
};
