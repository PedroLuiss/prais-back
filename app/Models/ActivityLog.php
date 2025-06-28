<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Modelo para el registro de acciones realizadas en el sistema por los usuarios.
 */
class ActivityLog extends Model
{
    use HasFactory;

    /**
     * El modelo no utiliza la columna 'updated_at'.
     */
    const UPDATED_AT = null;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'module',
        'description',
        'loggable_id',
        'loggable_type',
    ];

    /**
     * Obtiene el usuario que realizó la acción.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el modelo padre al que pertenece este log (la relación polimórfica).
     *
     * Esto te permite hacer: $log->loggable para obtener el Beneficiario, Presupuesto, etc.
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
