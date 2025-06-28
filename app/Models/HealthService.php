<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthService extends Model
{
      use HasFactory;

    /**
     * La tabla asociada con el modelo.
     * No es estrictamente necesario definirlo porque Laravel lo infiere de 'HealthService' a 'health_services',
     * pero es una buena práctica para mayor claridad.
     *
     * @var string
     */
    protected $table = 'health_services';


    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Define la relación "tiene muchos".
     * Un Servicio de Salud tiene muchos Dispositivos.
     */
    public function devices(): HasMany
    {
        // Laravel automáticamente asume que la llave foránea en la tabla 'devices'
        // es 'health_service_id' y la llave local en esta tabla es 'id'.
        // Como nombramos las columnas siguiendo la convención, la definición es muy simple.
        return $this->hasMany(Device::class);
    }
}
