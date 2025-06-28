<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
      use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'health_service_id',
    ];

    /**
     * Obtiene el servicio de salud al que pertenece el dispositivo.
     *
     * La convención de Laravel nos permite definir esta relación de forma muy simple.
     * Eloquent buscará una columna 'service_health_id' en la tabla 'devices'.
     */
    public function serviceHealth(): BelongsTo
    {
        // Asumimos que el modelo para 'servicio_salud' se llama 'ServiceHealth'
        // y su clave primaria es 'id_servicio'.
        return $this->belongsTo(HealthService::class, 'health_service_id');
    }
}
