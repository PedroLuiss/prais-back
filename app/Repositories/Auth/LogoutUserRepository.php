<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogoutUserRepository implements LogoutUserRepositoryInterface {
    public function logout(Request $request): JsonResponse {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => __("response.ok_success"),
        ]);
    }
}