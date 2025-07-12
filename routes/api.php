<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\BeneficiaryController;
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


Route::get('beneficiaries', [BeneficiaryController::class, 'index'])->name('beneficiaries.index');
Route::post('beneficiaries', [BeneficiaryController::class, 'store'])->name('beneficiaries.store');
Route::put('beneficiaries/{beneficiary}', [BeneficiaryController::class, 'update'])->name('beneficiaries.update');
Route::delete('/beneficiaries/{beneficiary}', [BeneficiaryController::class, 'destroy'])->name('beneficiaries.destroy');

Route::get('/beneficiaries/export', [BeneficiaryController::class, 'export'])->name('beneficiaries.export');
Route::get('/beneficiaries/import-template', [BeneficiaryController::class, 'downloadImportTemplate'])->name('beneficiaries.import-template');
Route::post('/beneficiaries/import', [BeneficiaryController::class, 'import'])->name('beneficiaries.import');
