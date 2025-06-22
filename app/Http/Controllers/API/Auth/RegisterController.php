<?php

namespace App\Http\Controllers\API\Auth;

use App\Services\Auth\RegisterUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class RegisterController
{
    public function __construct(
        protected RegisterUserService $registerUserService,
    ) {}

    public function register(Request $request): JsonResponse|UserResource {
        return $this->registerUserService->register($request);
    }
}
