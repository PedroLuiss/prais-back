<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Item
 *
 * Representa un ítem del catálogo presupuestario.
 * Por ejemplo: "Recursos Humanos", "Actividades Comunitarias", etc.
 *
 * @property int $id
 * @property string $name Nombre del ítem presupuestario.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Item extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * Laravel infiere 'items' por defecto, pero es buena práctica ser explícito.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * Los atributos que se pueden asignar de forma masiva (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * Esto asegura que siempre trabajes con los tipos de datos correctos en PHP.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * Las ejecuciones presupuestarias a las que este ítem está asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function budgetExecutions(): BelongsToMany
    {
        return $this->belongsToMany(BudgetExecution::class, 'budget_execution_item')
                    ->withPivot('value') // <-- ¡Muy importante!
                    ->withTimestamps(); // <-- Si tu tabla pivote tiene timestamps
    }

}
