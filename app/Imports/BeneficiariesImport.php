<?php

namespace App\Imports;

use App\Models\Beneficiary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BeneficiariesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // El trait WithHeadingRow permite acceder a las celdas por su nombre de cabecera.
        return new Beneficiary([
            'run'                     => $row['run'],
            'verification_digit'      => $row['dv'],
            'first_names'             => $row['nombres'],
            'primary_last_name'       => $row['apellido_paterno'],
            'secondary_last_name'     => $row['apellido_materno'],
            'gender'                  => $row['genero'],
            'birth_date'              => $this->transformDate($row['fecha_nacimiento']),
            'email'                   => $row['email'],
            'phone_numbers'           => $row['telefonos'],
            'region'                  => $row['region'],
            'commune'                 => $row['comuna'],
            'street_name'             => $row['calle'],
            'street_number'           => $row['numero_calle'],
            'department_number'       => $row['numero_depto'],
            'civil_status'            => $row['estado_civil'],
            'education_level'         => $row['nivel_educacional'],
            'health_insurance'        => $row['prevision_salud'],
            'valech_listed'           => $this->transformBoolean($row['listado_valech']),
            'exonerated_listed'       => $this->transformBoolean($row['exonerado_politico']),
            'accreditation_date'      => $this->transformDate($row['fecha_acreditacion']),
            'device_entry_date'       => $this->transformDate($row['fecha_ingreso_dispositivo']),
            'has_prais_fonasa_mark'   => $this->transformBoolean($row['marca_prais_fonasa']),
            'relationship_with_victim'=> $row['relacion_victima'],
            'index_run'               => $row['run_indice'],
            'index_verification_digit'=> $row['dv_indice'],
            'rettig_law_victim_full_name' => $row['nombre_completo_victima_rettig'],
            'relevant_observation'    => $row['observacion_relevante'],
            'device_id'               => $row['id_dispositivo'],
        ]);
    }

    /**
     * Define las reglas de validación para cada fila.
     */
    public function rules(): array
    {
        return [
            '*.run' => 'required|integer',
            '*.dv' => 'required|string|max:1',
            '*.nombres' => 'required|string|max:255',
            '*.apellido_paterno' => 'required|string|max:255',
            '*.email' => 'nullable|email|unique:beneficiaries,email',
            '*.id_dispositivo' => 'required|integer|exists:devices,id',
        ];
    }

    /**
     * Define el tamaño de lote para inserciones masivas. Mejora el rendimiento.
     */
    public function batchSize(): int
    {
        return 500;
    }

    /**
     * Lee el archivo en trozos para no agotar la memoria.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Transforma un valor de fecha de Excel (puede ser número o string) a un objeto Carbon.
     */
    private function transformDate($value): ?\Carbon\Carbon
    {
        if (empty($value)) return null;
        // Intenta crear desde formato d-m-Y, si falla, asume que es un número de serie de Excel
        try {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $value);
        } catch (\Exception $e) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
        }
    }

    /**
     * Transforma "Sí" a true y cualquier otra cosa a false.
     */
    private function transformBoolean($value): bool
    {
        return strtolower(trim($value)) === 'sí';
    }
}
