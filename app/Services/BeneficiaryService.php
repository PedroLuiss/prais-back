<?php

namespace App\Services;

use App\Models\Beneficiary;
use App\Repositories\BeneficiaryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BeneficiaryService
{
    protected $beneficiaryRepository;

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
        $filters = [
            'run' => $requestData['run'] ?? null,
            'beneficiary_name' => $requestData['beneficiary_name'] ?? null,
            'victim_run' => $requestData['victim_run'] ?? null,
            'victim_name' => $requestData['victim_name'] ?? null,
        ];

        return $this->beneficiaryRepository->getFiltered($filters);
    }


    /**
     * Prepara los datos y crea un nuevo beneficiario.
     *
     * @param array $data Los datos validados del request.
     * @return Beneficiary
     */
    public function createBeneficiary(array $data): Beneficiary
    {
        return $this->beneficiaryRepository->create($data);
    }
}
