<?php

namespace App\Services\Auth;

use App\Repositories\Auth\LoginUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class LoginUserService {
    public function __construct(
        protected LoginUserRepositoryInterface $loginUserRepository,
    ) {}

    public function login(Request $request): JsonResponse|UserResource {
        return $this->loginUserRepository->login($request);
    }
}