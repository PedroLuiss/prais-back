<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LogoutUserRepositoryInterface {
    public function logout(Request $request): JsonResponse;
}