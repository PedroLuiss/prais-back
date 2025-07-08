<?php

namespace App\Repositories;

use App\Models\Beneficiary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BeneficiaryRepository
{
    /**
     * Obtiene una lista paginada y filtrada de beneficiarios.
     *
     * @param array $filters Los filtros a aplicar.
     * @param int $perPage El número de resultados por página.
     * @return LengthAwarePaginator
     */
    public function getFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Beneficiary::query();

        if (!empty($filters['run'])) {
            $query->where('run', $filters['run']);
        }

        if (!empty($filters['beneficiary_name'])) {
            $name = $filters['beneficiary_name'];
            $query->where(function ($q) use ($name) {
                $q->where(DB::raw("CONCAT(first_names, ' ', primary_last_name, ' ', secondary_last_name)"), 'ILIKE', "%{$name}%");
            });
        }

        if (!empty($filters['victim_run'])) {
            $query->where('index_run', $filters['victim_run']);
        }

        if (!empty($filters['victim_name'])) {
            $query->where('rettig_law_victim_full_name', 'ILIKE', "%{$filters['victim_name']}%");
        }

        return $query->orderBy('primary_last_name', 'asc')->paginate($perPage);
    }
}
