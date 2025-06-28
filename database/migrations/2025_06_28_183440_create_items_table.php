<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Ejecuta las migraciones para crear la tabla 'items'.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);

            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE items IS 'Catálogo de ítems presupuestarios (Ej: RRHH, Actividades comunitarias, etc)'");
        DB::statement("COMMENT ON COLUMN items.name IS 'Nombre del ítem presupuestario'");
    }

    /**
     * Reverse the migrations.
     *
     * Revierte las migraciones, eliminando la tabla 'items'.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
