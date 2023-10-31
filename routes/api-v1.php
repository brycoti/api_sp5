<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RollDiceController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;


Route::post('/players', [UserController::class, 'store'])->name('user.api.v1.register');

Route::post('/login', [UserController::class, 'login'])->name('user.api.v1.login');


Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [UserController::class, 'logout'])->middleware('role:admin|user')->name('user.api.v1.logout');

    Route::put('/players/{id}', [UserController::class, 'update'])->middleware('role:admin|user')->name('user.api.v1.updateName');
    Route::post('/players/{id}/games', [RollDiceController::class, 'rollIt'])->middleware('role:admin|user')->name('user.api.v1.rollIt');
    Route::delete('/players/{id}/games', [RollDiceController::class, 'deleteRolls'])->middleware('role:admin|user')->name('user.api.v1.delete');
    Route::get('/players', [UserController::class, 'index'])->middleware('role:admin')->name('admin.api.v1.index');
    Route::get('/players/{id}/games', [UserController::class, 'show'])->middleware('role:admin|user')->name('user.api.v1.show');
    Route::get('players/ranking', [UserController::class, 'ranking'])->middleware('role:admin')->name('admin.api.v1.ranking');
    Route::get('players/ranking/loser', [UserController::class, 'loser'])->middleware('role:admin')->name('admin.api.v1.loser');
    Route::get('players/ranking/winner', [UserController::class, 'winner'])->middleware('role:admin')->name('admin.api.v1.winner');
});
