<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\NotificationAlert
 *
 * Representa un tipo de alerta o notificación del sistema que puede ser
 * activada o desactivada a nivel global.
 *
 * @property int $id Identificador único de la alerta o notificación.
 * @property string $name Nombre de la alerta (Ej: vencimiento cuenta, documentos nuevos).
 * @property bool $status Estado de la alerta: TRUE = activa, FALSE = inactiva.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class NotificationAlert extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'notification_alerts';

    /**
     * Los atributos que se pueden asignar de forma masiva (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * Esto asegura que 'status' siempre sea un booleano en el código PHP.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Los usuarios que han configurado esta alerta.
     *
     * Esta es la relación que definimos en la pregunta anterior.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_alert_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
