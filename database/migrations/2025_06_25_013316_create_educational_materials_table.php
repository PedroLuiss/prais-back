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
        Schema::create('educational_materials', function (Blueprint $table) {
            $table->id();

            // 'Título del material educativo.'
            $table->string('title');

            // 'Tipo de material (documento, video, etc.).'
            $table->string('type', 50);

            // 'Ruta o archivo cargado.'
            $table->text('path');

            // 'Fecha de publicación del material.'
            $table->date('publication_date')->nullable();

            // 'Usuario que subió el material.'
            // Asumiendo que tu tabla de usuarios se llama 'users'.
            $table->foreignId('user_id')->constrained('users');

            $table->timestamps(); // Añade created_at y updated_at
        });

        DB::statement("COMMENT ON TABLE educational_materials IS 'Repositorio de materiales educativos del sistema.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_materials');
    }
};
