<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix("/auth")->group(function () {
    Route::post("/login", [LoginController::class, "login"])
        ->name("login")
        ->middleware("guest");
    Route::delete("/", [LogoutController::class, "logout"])
        ->name("logout")
        ->middleware("auth:sanctum");
    Route::post("/register", [RegisterController::class, "register"])
        ->name("register")
        ->middleware("guest");
});

Route::prefix("/user")->group(function() {
    Route::get("", [UserController::class, "getUser"])
        ->name("user.get")
        ->middleware("auth:sanctum");
    Route::get("all", [UserController::class, "allUser"])
        ->name("user.all")
        ->middleware("auth:sanctum");
    Route::patch("", [UserController::class, "updateUser"])
        ->name("user.update")
        ->middleware("auth:sanctum");
    Route::delete("", [UserController::class, "deleteUser"])
        ->name("user.delete")
        ->middleware("auth:sanctum");
});
