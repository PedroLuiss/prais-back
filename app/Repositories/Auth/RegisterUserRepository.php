<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisterUserRepository implements RegisterUserRepositoryInterface {
    public function register(Request $request): JsonResponse|UserResource {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3|max:30",
            "email" => "required|email|max:255|unique:users",
            "password" => "required|min:6|max:30",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $name = htmlspecialchars(trim($request->input("name")));
        $email = filter_var(trim($request->input("email")), FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars(trim($request->input("password")));

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();

        return response()->json([
            "data" => new UserResource($user),
        ], Response::HTTP_CREATED);
    }
}