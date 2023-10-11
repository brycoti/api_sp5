<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiceRoll;

class DiceRollController extends Controller
{
    

public function rollDice()
{
    $dice1 = rand(1, 6);
    $dice2 = rand(1, 6);

    $total = $dice1 + $dice2;
    $win = ($total === 7);

    $diceRoll = new DiceRoll();
    $diceRoll->dice1 = $dice1;
    $diceRoll->dice2 = $dice2;
    $diceRoll->win = $win;
    $diceRoll->save();

    return response()->json([
        'dice1' => $dice1,
        'dice2' => $dice2,
        'total' => $total,
        'win' => $win,
    ], 200);
}

}
