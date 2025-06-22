<?php

namespace App\Http\Controllers\API\Auth;

use App\Services\Auth\LoginUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class LoginController
{
    public function __construct(
        protected LoginUserService $loginUserService
    ) {}

    public function login(Request $request): JsonResponse|UserResource {
        return $this->loginUserService->login($request);
    }
}
