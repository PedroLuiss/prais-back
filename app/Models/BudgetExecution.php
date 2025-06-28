<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BudgetExecution extends Model
{
    use HasFactory;

    protected $table = 'budget_executions';


    protected $fillable = [
        'month',
        'year',
        'expense_type',
        'amount',
        'support_file',
        'created_by',
        'period',
        'health_service_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Obtiene el servicio de salud al que pertenece la ejecución.
     */
    public function healthService(): BelongsTo
    {
        return $this->belongsTo(HealthService::class); // Asumiendo que tienes un modelo HealthService
    }

     /**
     * Los ítems que pertenecen a esta ejecución presupuestaria.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'budget_execution_item')
                    ->withPivot('value') // <-- ¡Muy importante!
                    ->withTimestamps(); // <-- Si tu tabla pivote tiene timestamps
    }
}
