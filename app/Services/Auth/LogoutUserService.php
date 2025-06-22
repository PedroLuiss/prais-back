<?php

namespace App\Services\Auth;

use App\Repositories\Auth\LogoutUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogoutUserService {
    public function __construct(
        protected LogoutUserRepositoryInterface $logoutUserRepository,
    ) {}

    public function logout(Request $request): JsonResponse {
        return $this->logoutUserRepository->logout($request);
    }
}