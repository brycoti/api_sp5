<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RollDiceController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/prueba', function () {
    return "prueba";
});



Route::post('/players', [UserController::class, 'store'])->name('api.v1.register');

Route::post('/login', [UserController::class, 'login'])->name('api.v1.login');

Route::middleware('auth:api')->group(function () {
    Route::put('/players/{id}', [UserController::class, 'update'])->name('api.v1.updateName');
    Route::post('/players/{id}/games', [RollDiceController::class, 'rollIt'])->name('api.v1.rollIt');

    
    // Otras rutas que requieran el middleware 'auth:api' pueden ir aquí.
});


// Route::middleware('auth:api')->post('roll-dice', 'DiceRollController@rollDice');


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

*/
