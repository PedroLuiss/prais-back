<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\LogoutUserService;
use Illuminate\Http\JsonResponse;

class LogoutController
{
    public function __construct(
        protected LogoutUserService $logoutUserService,
    ) {}

    public function logout(Request $request): JsonResponse {
        return $this->logoutUserService->logout($request);
    }
}
