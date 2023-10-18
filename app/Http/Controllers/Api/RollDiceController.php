<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiceRoll;
use App\Models\User;

class RollDiceController extends Controller
{
    public function rollIt($id)  {
            // Find the user based on the provided ID
        $user = User::find($id);

        // Check if the user was found
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);
        $total = $dice1 + $dice2;

        if ($total === 7) {
            $isWin = true;
        } else {
            $isWin = false;
        }

        DiceRoll::create([
            'user_id' => $user->id,
            'dice1' => $dice1,
            'dice2' => $dice2,
            'total' => $total,
            'win' => $isWin,
        ]);

        $user->wins += $isWin ? 1 : 0;
        $user->losses += $isWin ? 0 : 1;
        $user->gamesPlayed += 1;

        // Calculate success rate after updating wins, losses, and gamesPlayed
        $user->successRate = ($user->wins / $user->gamesPlayed) * 100;

        $user->save();


        $message = $isWin ? 'You won!' : 'You lost!';

        return response()->json([
            'dice1' => $dice1,
            'dice2' => $dice2,
            'total' => $total,
            'isWin' => $isWin,
            'message' => $message,
        ], 200);
    }

    public function deleteRolls($id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        DiceRoll::where('user_id', $user->id)->delete();

        return response()->json([
            'message' => 'Rolls deleted.',
        ], 200);
        
    }
}
