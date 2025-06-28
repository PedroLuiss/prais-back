<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
       protected $tableName = 'psychosocial_accompaniments';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id()->comment('Identificador único del acompañamiento psicosocial');
            // Clave foránea VARCHAR al beneficiario
            // $table->string('beneficiary_id', 15)->comment('ID del beneficiario al que se le realizó el acompañamiento');
            $table->foreignId('beneficiary_id')->constrained('beneficiaries')->onDelete('cascade')->comment('ID del beneficiario al que se le realizó el acompañamiento');
            $table->text('location')->nullable()->comment('Ubicación geográfica donde se realizó el acompañamiento');
            $table->date('interview_date')->nullable()->comment('Fecha en que se realizó la entrevista con el beneficiario');
            $table->text('victim_name')->nullable()->comment('Nombre completo de la víctima relacionada (si aplica)');
            $table->text('cause_or_role')->nullable()->comment('Rol judicial o nombre de la causa relacionada');
            $table->text('search_stage')->nullable()->comment('Etapa en que se encuentra la búsqueda judicial o reparación');
            $table->integer('age')->nullable()->comment('Edad calculada del beneficiario en la fecha de la entrevista');
            $table->string('gender_identity')->nullable()->comment('Identidad de género del beneficiario');
            $table->string('occupation')->nullable()->comment('Ocupación actual del beneficiario');
            $table->timestamps();
        });

        // Comentario general para la tabla
        DB::statement("COMMENT ON TABLE {$this->tableName} IS 'Registros de entrevistas e intervenciones psicosociales realizadas a beneficiarios'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychosocial_accompaniments');
    }
};
