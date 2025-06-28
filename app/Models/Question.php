<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo para representar una pregunta en el sistema.
 */
class Question extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'status',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Es crucial para los campos booleanos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];


    /**
     * Los acompañamientos que tienen una respuesta a esta pregunta.
     */
    public function psychosocialAccompaniments(): BelongsToMany
    {
        return $this->belongsToMany(PsychosocialAccompaniment::class, 'psychosocial_accompaniment_question')
            ->withPivot('value');
    }
}
