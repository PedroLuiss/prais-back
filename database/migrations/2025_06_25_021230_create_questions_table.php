<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id()->comment('Identificador único de la pregunta.');
            $table->text('description')->comment('Texto o enunciado de la pregunta.');
            $table->boolean('status')->default(true)->comment('Estado de la pregunta (true=activo, false=inactivo).');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
