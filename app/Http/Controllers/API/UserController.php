<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController
{
    public function __construct(
        protected UserService $userService,
    ) {}

    public function getUser(Request $request): UserResource {
        return $this->userService->getUser($request->user());
    }

    public function allUser(): JsonResponse {
        return $this->userService->allUser();
    }

    public function updateUser(Request $request): JsonResponse|UserResource {
        return $this->userService->updateUser($request);
    }

    public function deleteUser(Request $request): JsonResponse {
        return $this->userService->deleteUser($request->user());
    }
}
