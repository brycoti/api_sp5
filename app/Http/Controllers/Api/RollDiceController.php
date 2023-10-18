<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiceRoll;
use App\Models\User;

class RollDiceController extends Controller
{
        

    public function rollIt(Request $request, $id)
    {
        $user = User::find($id);

        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);
        $total = $dice1 + $dice2;

        if($total === 7){
            $isWin = true;
        }else{
            $isWin = false;
        }

        DiceRoll::create([
            'user_id' => $user->id,
            'dice1' => $dice1,
            'dice2' => $dice2,
            'total' => $total,
            'win' => $isWin,
        ]);

        $user->update([
            'wins' => $user->wins + ($isWin ? 1 : 0),
            'losses' => $user->losses + ($isWin ? 0 : 1),
        ]);

        $message = $isWin ? 'You won!' : 'You lost!'; 

        return response()->json([
            'dice1' => $dice1,
            'dice2' => $dice2,
            'total' => $total,
            'isWin' => $isWin,
            'message' => $message,
        ], 200);
    }

}
