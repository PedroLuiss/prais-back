<?php

namespace App\Exports;

use App\Models\Beneficiary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BeneficiariesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Beneficiary::with('device')->get();
    }

    /**
     * Define los títulos de las columnas en español.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'RUN',
            'DV',
            'Nombres',
            'Apellido Paterno',
            'Apellido Materno',
            'Género',
            'Fecha de Nacimiento',
            'Email',
            'Teléfonos',
            'Región',
            'Comuna',
            'Estado Civil',
            'Nivel Educacional',
            'Previsión de Salud',
            '¿Listado Valech?',
            '¿Exonerado Político?',
            'Fecha de Acreditación',
            'Fecha Ingreso al Dispositivo',
            'Marca PRAIS-FONASA',
            'Dispositivo Perteneciente'
        ];
    }

    /**
     * Mapea los datos de cada beneficiario a una fila del Excel.
     *
     * @param Beneficiary $beneficiary
     * @return array
     */
    public function map($beneficiary): array
    {
        return [
            $beneficiary->id,
            $beneficiary->run,
            $beneficiary->verification_digit,
            $beneficiary->first_names,
            $beneficiary->primary_last_name,
            $beneficiary->secondary_last_name,
            $beneficiary->gender,
            // Formateamos las fechas para mejor lectura
            $beneficiary->birth_date ? $beneficiary->birth_date->format('d-m-Y') : '',
            $beneficiary->email,
            $beneficiary->phone_numbers,
            $beneficiary->region,
            $beneficiary->commune,
            $beneficiary->civil_status,
            $beneficiary->education_level,
            $beneficiary->health_insurance,
            // Convertimos booleanos a 'Sí' o 'No'
            $beneficiary->valech_listed ? 'Sí' : 'No',
            $beneficiary->exonerated_listed ? 'Sí' : 'No',
            $beneficiary->accreditation_date ? $beneficiary->accreditation_date->format('d-m-Y') : '',
            $beneficiary->device_entry_date ? $beneficiary->device_entry_date->format('d-m-Y') : '',
            $beneficiary->has_prais_fonasa_mark ? 'Sí' : 'No',
            // Accedemos a la relación para obtener el nombre del dispositivo
            $beneficiary->device ? $beneficiary->device->name : 'N/A',
        ];
    }
}
