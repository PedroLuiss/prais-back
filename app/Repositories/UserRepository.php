<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface {
    public function getUser(User $user): UserResource {
        return new UserResource($user);
    }

    public function allUser(): JsonResponse {
        $users = User::all();
        if ($users->isEmpty()) {
            return response()->json([
                "message" => __("response.user.no_users_found"),
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(UserResource::collection($users));
    }

    public function updateUser(Request $request): JsonResponse|UserResource {
        $Validator = Validator::make($request->all(), [
            "name" => "sometimes|min:3|max:30",
            "email" => "sometimes|email|max:255",
            "password" => "sometimes|min:6|max:30",
        ]);

        if ($Validator->fails()) {
            return response()->json([
                "message" => $Validator->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user();

        if (null !== $request->input("name")) {
            $name = htmlspecialchars(trim($request->input("name")));
            $user->name = $name;
        }
        // Check if different email given is unique.
        if (null !== $request->input("email")) {
            $email = filter_var(trim($request->input("email")), FILTER_SANITIZE_EMAIL);
            if ($user->email !== $email) {
                $emailExists = User::where("email", $email)->exists();
                if ($emailExists) {
                    return response()->json([
                        "message" => __(
                            "validation.exists",
                            ["attribute" => "email"],
                        ),
                    ], Response::HTTP_BAD_REQUEST);
                }
            }
            $user->email = $email;
        }
        if (null !== $request->input("password")) {
            $password = htmlspecialchars(trim($request->input("password")));
            $user->password = $password;
        }

        if (isset($name) || isset($email) || isset($password)) {
            $user->save();
        }

        return new UserResource($user);
    }

    public function deleteUser(User $user): JsonResponse {
        $user->delete();
        return response()->json([
            "message" => __("response.user.delete_user_success"),
        ]);
    }
}
