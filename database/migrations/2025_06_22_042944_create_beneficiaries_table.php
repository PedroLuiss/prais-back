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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->string('id', 20)->primary()->comment('Identificador único, generado a partir de RUN y DV');

            $table->integer('run')->comment('RUN del beneficiario');
            $table->string('verification_digit', 1)->comment('Dígito verificador del RUN');
            $table->string('first_names')->comment('Nombres del beneficiario');
            $table->string('primary_last_name')->comment('Primer apellido del beneficiario');
            $table->string('secondary_last_name')->nullable()->comment('Segundo apellido del beneficiario');
            $table->string('gender', 20)->nullable()->comment('Sexo del beneficiario: HOMBRE, MUJER, INTERSEX');
            $table->date('birth_date')->nullable()->comment('Fecha de nacimiento del beneficiario');
            $table->date('accreditation_date')->nullable()->comment('Fecha en que fue acreditado como beneficiario');
            $table->date('device_entry_date')->nullable()->comment('Fecha en que ingresó al dispositivo PRAIS');
            $table->string('accreditation_quality', 50)->nullable()->comment('Calidad de acreditación: Índice, A. Directo/a, Beneficiario/a');
            $table->string('relationship_with_index', 100)->nullable()->comment('Relación del beneficiario con la persona índice');
            $table->string('index_run', 50)->nullable()->comment('RUN, pasaporte u otro identificador de la persona índice');
            $table->string('index_verification_digit', 20)->nullable()->comment('Dígito verificador u otra codificación del índice');
            $table->string('rettig_law_victim_full_name')->nullable()->comment('Nombre de la víctima Ley Rettig (si aplica)');
            $table->string('relationship_with_victim', 100)->nullable()->comment('Relación con víctima Ley Rettig');
            $table->string('has_prais_fonasa_mark', 5)->nullable()->comment('Indica si tiene marca PRAIS en FONASA: SI o NO');
            $table->string('status_in_device', 100)->nullable()->comment('Estado del beneficiario: VIGENTE, FALLECIDO, TRASLADADO, etc.');
            $table->date('transfer_date')->nullable()->comment('Fecha de traslado a otro dispositivo PRAIS');
            $table->string('transferred_to_prais_ss')->nullable()->comment('Servicio de Salud destino del traslado');
            $table->date('disaffiliation_date')->nullable()->comment('Fecha de desafiliación del programa PRAIS');
            $table->date('death_date')->nullable()->comment('Fecha de defunción del beneficiario');
            $table->text('cause_of_death_diagnosis')->nullable()->comment('Causas de defunción y códigos CIE-10');
            $table->string('street_name')->nullable()->comment('Nombre de la calle del domicilio');
            $table->string('street_number', 20)->nullable()->comment('Número de la calle');
            $table->string('department_number', 20)->nullable()->comment('Número del departamento (si aplica)');
            $table->string('commune', 100)->nullable()->comment('Comuna del domicilio');
            $table->string('region', 100)->nullable()->comment('Región del domicilio (autocompletado desde comuna)');
            $table->text('phone_numbers')->nullable()->comment('Teléfonos de contacto (fijo o móvil)');
            $table->string('email')->nullable()->unique()->comment('Correo electrónico del beneficiario');
            $table->string('civil_status', 50)->nullable()->comment('Estado civil: Soltero, Casado, Viudo, etc.');
            $table->string('education_level', 100)->nullable()->comment('Nivel educacional alcanzado');
            $table->string('health_insurance', 50)->nullable()->comment('Previsión de salud: FONASA, ISAPRE, etc.');
            $table->text('relevant_observation')->nullable()->comment('Observaciones relevantes complementarias');
            $table->string('valech_listed', 2)->nullable()->comment('Indica si el RUN está en la nómina Valech: SI o NO');
            $table->string('exonerated_listed', 2)->nullable()->comment('Indica si el RUN está en la nómina de Exonerados: SI o NO');
            $table->integer('age_in_years')->nullable()->comment('Edad del beneficiario (calculada)');
            $table->string('age_group', 50)->nullable()->comment('Categoría del grupo etario');
            $table->integer('accreditation_or_entry_year')->nullable()->comment('Año en que se acreditó o ingresó al dispositivo PRAIS');

            // Foreign Key a la tabla 'dispositivos' (devices)
            // Asumo que la tabla de dispositivos se llamará 'devices' y su PK es 'id'
            $table->unsignedBigInteger('device_id')->nullable()->comment('Dispositivo PRAIS al que está asignado');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('set null');

            $table->timestamps(); // Adds created_at and updated_at
        });

        // Añadir comentario a la tabla (compatible con PostgreSQL y MySQL)
        DB::statement('COMMENT ON TABLE beneficiaries IS \'Tabla que almacena la información completa de los beneficiarios del programa PRAIS\'');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
