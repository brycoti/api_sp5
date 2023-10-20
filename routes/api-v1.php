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

    Route::post('/logout', [UserController::class, 'logout'])->name('api.v1.logout');

    Route::put('/players/{id}', [UserController::class, 'update'])->name('api.v1.updateName');
    Route::post('/players/{id}/games', [RollDiceController::class, 'rollIt'])->name('api.v1.rollIt');
    Route::delete('/players/{id}/games', [RollDiceController::class, 'deleteRolls'])->name('api.v1.delete');
    Route::get('/players', [UserController::class, 'index'])->name('api.v1.index');
    Route::get('/players/{id}/games', [UserController::class, 'show'])->name('api.v1.show');
    Route::get('players/ranking', [UserController::class, 'ranking'])->name('api.v1.ranking');
    Route::get('players/ranking/loser', [UserController::class, 'loser'])->name('api.v1.loser');
    Route::get('players/ranking/winner', [UserController::class, 'winner'])->name('api.v1.winner');
});
