<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para el registro de cambios realizados sobre los beneficiarios.
 */
class BeneficiaryChangeHistory extends Model
{
    use HasFactory;

    /**
     * Indica que el modelo no debe tener la columna 'updated_at'.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'beneficiary_id',
        'field_modified',
        'old_value',
        'new_value',
        'modified_by_user_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Potencialmente útil si guardas JSON o booleanos como texto.
     *
     * @var array
     */
    protected $casts = [
        // Ejemplo: si 'old_value' o 'new_value' guardaran JSON
        // 'old_value' => 'array',
        // 'new_value' => 'array',
    ];

    /**
     * Obtiene el beneficiario que fue modificado.
     */
    public function beneficiary(): BelongsTo
    {
        // Especificamos las claves explícitamente porque no siguen la convención de Laravel.
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    /**
     * Obtiene el usuario que realizó la modificación.
     */
    public function modifiedBy(): BelongsTo
    {
        // El nombre del método es más descriptivo que simplemente 'user()'.
        // La clave foránea es 'modified_by_user_id'.
        return $this->belongsTo(User::class, 'modified_by_user_id');
    }
}
