<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RepressiveSituation extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Los beneficiarios que pertenecen a esta Situación Represiva.
     *
     * Esto define la relación Muchos-a-Muchos a través de la tabla pivote
     * 'beneficiary_repressive_situation'.
     */
    public function beneficiaries(): BelongsToMany
    {
        return $this->belongsToMany(
            Beneficiary::class,                 // 1. Modelo relacionado
            'beneficiary_repressive_situation', // 2. Nombre de la tabla pivote
            'repressive_situation_id',          // 3. Llave foránea de este modelo en la tabla pivote
            'beneficiarie_id'                    // 4. Llave foránea del modelo relacionado
        );
    }
}
