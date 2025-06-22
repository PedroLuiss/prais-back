<?php

namespace App\Repositories\Auth;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LoginUserRepositoryInterface {
    public function login(Request $request): JsonResponse|UserResource;
}