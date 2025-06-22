<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserRepositoryInterface {
    public function getUser(User $user): UserResource;
    public function allUser(): JsonResponse;
    public function updateUser(Request $request): JsonResponse|UserResource;
    public function deleteUser(User $user): JsonResponse;
}
