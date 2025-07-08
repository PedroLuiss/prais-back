<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\BeneficiaryService;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $beneficiaries = $this->beneficiaryService->listBeneficiaries($request->all());
        return response($beneficiaries);
    }

}
