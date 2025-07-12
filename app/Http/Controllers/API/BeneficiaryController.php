<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Http\Resources\UserResource;
use App\Models\Beneficiary;
use App\Repositories\BeneficiaryRepository;
use App\Services\BeneficiaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Validators\ValidationException;

class BeneficiaryController extends Controller
{
    protected $beneficiaryService;
    protected $beneficiaryRepository;

    // Inyectamos el servicio
    public function __construct(BeneficiaryService $beneficiaryService, BeneficiaryRepository $beneficiaryRepository)
    {
        $this->beneficiaryService = $beneficiaryService;
        $this->beneficiaryRepository = $beneficiaryRepository;
    }

    public function collection()
    {
        return $this->beneficiaryRepository->getAllForExport();
    }

    /**
     * Muestra la lista de beneficiarios con filtros.
     *
     * @param Request $request
     * @return UserResource
     */
    public function index(Request $request): JsonResponse
    {
        $beneficiaries = $this->beneficiaryService->listBeneficiaries($request->all());
        return response()->json($beneficiaries, 201);
    }

    /**
     * Almacena un nuevo beneficiario en la base de datos.
     *
     * @param StoreBeneficiaryRequest $request
     * @return JsonResponse
     */
    public function store(StoreBeneficiaryRequest $request): JsonResponse
    {

        try {
            $validatedData = $request->validated();

            $beneficiary = $this->beneficiaryService->createBeneficiary($validatedData);

            return response()->json($beneficiary, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear beneficiario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error inesperado al guardar el beneficiario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un beneficiario existente en la base de datos.
     *
     * @param UpdateBeneficiaryRequest $request
     * @param Beneficiary $beneficiary
     * @return JsonResponse
     */
    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary): JsonResponse
    {

        try {
            $validatedData = $request->validated();

            $updatedBeneficiary = $this->beneficiaryService->updateBeneficiary($beneficiary, $validatedData);

            return response()->json($updatedBeneficiary, 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar beneficiario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error inesperado al actualizar el beneficiario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina lógicamente un beneficiario.
     *
     * @param Beneficiary $beneficiary
     * @return JsonResponse
     */
    public function destroy(Beneficiary $beneficiary): JsonResponse
    {
        try {
            $this->beneficiaryService->deleteBeneficiary($beneficiary);

            return response()->json(['message' => 'Beneficiario eliminado correctamente.'], 200);
        } catch (\Exception $e) {
            Log::error('Error al eliminar beneficiario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error inesperado al eliminar el beneficiario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Maneja la solicitud de exportación de beneficiarios.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
     */
    public function export(Request $request)
    {
        $rules = [
            'format' => 'required|in:xlsx,csv',
        ];

        $messages = [
            'format.required' => 'El campo formato es obligatorio.',
            'format.in' => 'El formato debe ser "xlsx" o "csv".',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        try {
            return $this->beneficiaryService->exportBeneficiaries($validatedData['format']);
        } catch (\Exception $e) {
            Log::error('Error al exportar beneficiarios: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error inesperado al generar el archivo de exportación.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Proporciona una plantilla de Excel para la importación masiva.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadImportTemplate()
    {
        return $this->beneficiaryService->getImportTemplate();
    }

    /**
     * Importa beneficiarios desde un archivo Excel.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación de archivo.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->beneficiaryService->importBeneficiaries($request->file('file'));

            return response()->json([
                'success' => true,
                'message' => 'La importación se ha completado exitosamente.'
            ], 200);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = [
                    'row' => $failure->row(), // Fila donde ocurrió el error
                    'attribute' => $failure->attribute(), // Columna (ej. 'email')
                    'errors' => $failure->errors(), // Mensajes de error para esa celda
                    'values' => $failure->values() // Valores de la fila que fallaron
                ];
            }

            return response()->json([
                'success' => false,
                'message' => 'Se encontraron errores de validación en el archivo.',
                'errors' => $errors
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error en importación masiva: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado durante la importación.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
