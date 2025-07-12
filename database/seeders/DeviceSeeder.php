<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device; // Importamos el modelo Device

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // NOTA: Asegúrate de que los 'health_service_id' (1, 2) existan en tu tabla 'health_services'
        // antes de ejecutar este seeder. Deberías tener un HealthServiceSeeder que se ejecute primero.

        $devices = [
            [
                'name' => 'Dispositivo PRAIS Metropolitano Central',
                'health_service_id' => 1,
            ],
            [
                'name' => 'Dispositivo PRAIS Metropolitano Norte',
                'health_service_id' => 1,
            ],
            [
                'name' => 'Dispositivo PRAIS Valparaíso - San Antonio',
                'health_service_id' => 2,
            ],
        ];

        // Recorremos el array y creamos o actualizamos cada dispositivo
        foreach ($devices as $deviceData) {
            Device::updateOrCreate(
                ['name' => $deviceData['name']], // Condición para buscar (clave única)
                $deviceData  // Datos para crear o actualizar
            );
        }
    }
}
