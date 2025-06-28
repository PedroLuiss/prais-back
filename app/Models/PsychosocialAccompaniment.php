<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo para los registros de entrevistas e intervenciones psicosociales.
 */
class PsychosocialAccompaniment extends Model
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
        'beneficiary_id',
        'location',
        'interview_date',
        'victim_name',
        'cause_or_role',
        'search_stage',
        'age',
        'gender_identity',
        'occupation',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'interview_date' => 'date',
        'age' => 'integer',
    ];

    /**
     * Obtiene el beneficiario asociado a este acompañamiento.
     */
    public function beneficiary(): BelongsTo
    {
        // Especificamos las claves explícitamente porque no siguen la convención de Laravel.
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }


    /**
     * Las preguntas asociadas a este acompañamiento.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'psychosocial_accompaniment_question')
                    ->withPivot('value') // ¡Importante! Para acceder al campo extra 'value'
                    ->withTimestamps(); // Si la tabla pivote tuviera timestamps
    }
}
