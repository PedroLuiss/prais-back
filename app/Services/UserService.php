<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function getUser(User $user): UserResource
    {
        return $this->userRepository->getUser($user);
    }

    public function allUser(): JsonResponse
    {
        return $this->userRepository->allUser();
    }

    public function updateUser(Request $request): JsonResponse|UserResource
    {
        return $this->userRepository->updateUser($request);
    }

    public function deleteUser(User $user): JsonResponse
    {
        return $this->userRepository->deleteUser($user);
    }
}
