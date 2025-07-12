<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthService; // Importamos el modelo

class HealthServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $healthServices = [
            ['name' => 'Servicio de Salud Metropolitano Central'],
            ['name' => 'Servicio de Salud Valparaíso - San Antonio'],
            ['name' => 'Servicio de Salud Metropolitano Norte'],
            ['name' => 'Servicio de Salud Metropolitano Sur'],
            ['name' => 'Servicio de Salud Viña del Mar - Quillota'],
            ['name' => 'Servicio de Salud del Maule'],
        ];

        foreach ($healthServices as $service) {
            HealthService::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
