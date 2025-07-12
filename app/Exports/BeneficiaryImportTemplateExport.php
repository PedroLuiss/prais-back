<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class BeneficiaryImportTemplateExport implements WithHeadings, FromArray
{
    /**
     * Devuelve un array vacío ya que solo queremos las cabeceras.
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Define los títulos de las columnas en español para la plantilla.
     * ESTOS NOMBRES DEBEN SER EXACTOS para que la importación funcione.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'run',
            'dv',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'genero',
            'fecha_nacimiento',
            'email',
            'telefonos',
            'region',
            'comuna',
            'calle',
            'numero_calle',
            'numero_depto',
            'estado_civil',
            'nivel_educacional',
            'prevision_salud',
            'listado_valech',
            'exonerado_politico',
            'fecha_acreditacion', //  (dd-mm-yyyy)
            'fecha_ingreso_dispositivo',//(dd-mm-yyyy),
            'marca_prais_fonasa',//(Sí/No)
            'relacion_victima',
            'run_indice',
            'dv_indice',
            'nombre_completo_victima_rettig',
            'observacion_relevante',
            'id_dispositivo',
        ];
    }
}
