<?php

namespace App\Services\Auth;

use App\Repositories\Auth\RegisterUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class RegisterUserService {
    public function __construct(
        protected RegisterUserRepositoryInterface $registerUserRepository,
    ) {}

    public function register(Request $request): JsonResponse|UserResource {
        return $this->registerUserRepository->register($request);
    }
}