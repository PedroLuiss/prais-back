<?php

namespace App\Repositories\Auth;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface RegisterUserRepositoryInterface {
    public function register(Request $request): JsonResponse|UserResource;
}