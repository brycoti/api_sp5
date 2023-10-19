<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RollDiceController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;


Route::post('/players', [UserController::class, 'store'])->name('api.v1.register');

Route::post('/login', [UserController::class, 'login'])->name('api.v1.login');

Route::middleware('auth:api')->group(function () {
    Route::put('/players/{id}', [UserController::class, 'update'])->name('api.v1.updateName');
    Route::post('/players/{id}/games', [RollDiceController::class, 'rollIt'])->name('api.v1.rollIt');
    Route::delete('/players/{id}/games', [RollDiceController::class, 'deleteRolls'])->name('api.v1.delete');
    Route::get('/players', [UserController::class, 'index'])->name('api.v1.index');
});
