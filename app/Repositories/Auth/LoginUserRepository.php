<?php

namespace App\Repositories\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginUserRepository implements LoginUserRepositoryInterface {
    public function login(Request $request): JsonResponse|UserResource {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|max:255",
            "password" => "required|min:6|max:30",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $email = filter_var(trim($request->input("email")), FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars(trim($request->input("password")));
        
        $authentication = Auth::attempt([
            "email" => $email,
            "password" => $password,
        ]);

        if (!$authentication) {
            return response()->json([
                "message" => __("response.login.invalid_credentials_error"),
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where("email", $email)->first();

        if (null === $user) {
            return response()->json([
                "message" => __("response.internal_server_error"),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user->tap(function(User $user) use ($request) {
            $user->token = $user->createToken("token")->plainTextToken;
        });

        return new UserResource($user);
    }
}