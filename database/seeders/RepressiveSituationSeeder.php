<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepressiveSituation; // Importamos el modelo

class RepressiveSituationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Lista de situaciones represivas comunes para poblar la base de datos
        $situations = [
            ['name' => 'Detenida/o Desaparecida/o'],
            ['name' => 'Ejecutada/o Política/o'],
            ['name' => 'Prisión Política y Tortura'],
            ['name' => 'Exonerada/o Política/o'],
            ['name' => 'Exilio'],
            ['name' => 'Relegación'],
            ['name' => 'Retorno'],
            ['name' => 'Víctima de Violencia Política'],
        ];

        // Recorremos la lista y creamos o actualizamos cada situación
        foreach ($situations as $situation) {
            RepressiveSituation::updateOrCreate(
                ['name' => $situation['name']], // Condición para buscar
                $situation // Datos para crear/actualizar
            );
        }
    }
}
