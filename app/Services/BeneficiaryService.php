<?php

namespace App\Services;

use App\Repositories\BeneficiaryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BeneficiaryService
{
    protected $beneficiaryRepository;

    // Inyectamos el repositorio a través del constructor (Mejor práctica)
    public function __construct(BeneficiaryRepository $beneficiaryRepository)
    {
        $this->beneficiaryRepository = $beneficiaryRepository;
    }

    /**
     * Prepara los filtros y obtiene la lista de beneficiarios.
     *
     * @param array $requestData Los datos del request HTTP.
     * @return LengthAwarePaginator
     */
    public function listBeneficiaries(array $requestData): LengthAwarePaginator
    {
        // Extraemos solo los filtros que nos interesan del request
        $filters = [
            'run' => $requestData['run'] ?? null,
            'beneficiary_name' => $requestData['beneficiary_name'] ?? null,
            'victim_run' => $requestData['victim_run'] ?? null,
            'victim_name' => $requestData['victim_name'] ?? null,
        ];

        // Llamamos al repositorio con los filtros limpios
        return $this->beneficiaryRepository->getFiltered($filters);
    }
}
