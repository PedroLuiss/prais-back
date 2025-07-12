<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Resources\UserResource;
use App\Services\BeneficiaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BeneficiaryController extends Controller
{
    protected $beneficiaryService;

    // Inyectamos el servicio
    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
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

}
