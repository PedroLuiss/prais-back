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
        Schema::create('devices', function (Blueprint $table) {
            $table->id()->comment('Identificador único del Dispositivo PRAIS.');
            $table->string('name')->comment('Nombre del Dispositivo PRAIS.');
            $table->unsignedBigInteger('health_service_id')->nullable()->comment('Referencia al Servicio de Salud al que pertenece el dispositivo.');
            $table->foreign('health_service_id')->references('id')->on('health_services')->onDelete('set null');

            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE devices IS 'Representa los dispositivos PRAIS disponibles.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
