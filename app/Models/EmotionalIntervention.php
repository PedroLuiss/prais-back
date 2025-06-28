<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para las intervenciones de apoyo emocional realizadas a beneficiarios.
 */
class EmotionalIntervention extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'intervention_date',
        'description',
        'type',
        'beneficiary_id',
        'user_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'intervention_date' => 'date',
    ];

    /**
     * Obtiene el beneficiario asociado a la intervención.
     * Relación: Una intervención pertenece a un beneficiario.
     */
    public function beneficiary(): BelongsTo
    {
        // Como la clave foránea y la clave primaria no siguen la convención de Laravel,
        // debemos especificarlas explícitamente.
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    /**
     * Obtiene el usuario que registró la intervención.
     * Relación: Una intervención pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
