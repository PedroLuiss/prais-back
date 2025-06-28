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
        Schema::create('repressive_situations', function (Blueprint $table) {
            $table->id()->comment('Identificador de la situación represiva.');
            $table->string('name')->comment('Nombre de la situación represiva.');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE repressive_situations IS 'Situaciones represivas posibles según legislación.'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repressive_situations');
    }
};
