<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiceRollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    DB::table('dice_rolls')->insert([ // Tiradada 1 de Id 1 admin'
        'user_id' => 1,
        'dice1' => 6,
        'dice2' => 1,
        'total' => 7, // Calcula el total según tus necesidades
        'win' => 1, // 0 para perder, 1 para ganar
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('dice_rolls')->insert([ // Tiradada 2 de Id 1 admin'
        'user_id' => 1,
        'dice1' => 1,
        'dice2' => 6,
        'total' => 7, 
        'win' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('dice_rolls')->insert([
        'user_id' => 1,
        'dice1' => 1,
        'dice2' => 6,
        'total' => 7,
        'win' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('dice_rolls')->insert([
        'user_id' => 1,
        'dice1' => 1,
        'dice2' => 6,
        'total' => 7,
        'win' => 1, 
        'created_at' => now(),
        'updated_at' => now(),
    ]);


    DB::table('dice_rolls')->insert([
        'user_id' => 2, // Id 2 player'
        'dice1' => 1,
        'dice2' => 1,
        'total' => 2,
        'win' => 0, // 0 para perder, 1 para ganar
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('dice_rolls')->insert([
        'user_id' => 3, // Id 3 player'
        'dice1' => 4,
        'dice2' => 3,
        'total' => 7,
        'win' => 1, //1 para ganar
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('dice_rolls')->insert([
        'user_id' => 3, // Id 3 player'
        'dice1' => 1,
        'dice2' => 2,
        'total' => 3,
        'win' => 0, //
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    }
}

