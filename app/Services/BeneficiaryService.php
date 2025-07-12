<?php

namespace App\Services;

use App\Exports\BeneficiariesExport;
use App\Exports\BeneficiaryImportTemplateExport;
use App\Imports\BeneficiariesImport;
use App\Models\Beneficiary;
use App\Repositories\BeneficiaryRepository;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    /**
     * Prepara los datos y actualiza un beneficiario existente.
     *
     * @param Beneficiary $beneficiary El beneficiario a actualizar.
     * @param array $data Los datos validados del request.
     * @return Beneficiary
     */
    public function updateBeneficiary(Beneficiary $beneficiary, array $data): Beneficiary
    {
        return $this->beneficiaryRepository->update($beneficiary, $data);
    }


    /**
     * Elimina lógicamente un beneficiario.
     *
     * @param Beneficiary $beneficiary
     * @return bool|null
     */
    public function deleteBeneficiary(Beneficiary $beneficiary): ?bool
    {
        return $this->beneficiaryRepository->delete($beneficiary);
    }


    /**
     * Genera y devuelve un archivo de exportación de beneficiarios.
     *
     * @param string $format El formato deseado ('xlsx' o 'csv').
     * @return BinaryFileResponse
     */
    public function exportBeneficiaries(string $format): BinaryFileResponse
    {
        $fileName = 'beneficiarios-' . now()->format('Y-m-d') . '.' . $format;

        // Determina el tipo de archivo para el paquete
        $writerType = $format === 'xlsx' ? \Maatwebsite\Excel\Excel::XLSX : \Maatwebsite\Excel\Excel::CSV;

        // Inyectamos el repositorio en el constructor de la clase de exportación
        $export = new BeneficiariesExport($this->beneficiaryRepository);

        return Excel::download($export, $fileName, $writerType);
    }

    /**
     * Genera y devuelve el archivo de plantilla para la importación.
     *
     * @return BinaryFileResponse
     */
    public function getImportTemplate(): BinaryFileResponse
    {
        return Excel::download(new BeneficiaryImportTemplateExport(), 'plantilla-importacion-beneficiarios.xlsx');
    }

    /**
     * Procesa un archivo de Excel para la importación masiva de beneficiarios.
     *
     * @return void
     */
    public function importBeneficiaries($file): void
    {
        Excel::import(new BeneficiariesImport, $file);
    }
}
