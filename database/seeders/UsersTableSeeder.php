<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([ // id 1
            'name' => 'Maestro',
            'email' => 'correo1@ejemplo1.com',
            'email_verified_at' => now(),
            'password' => 123456789,
            'wins' => 4,
            'losses' => 0,
            'gamesPlayed' => 4,
            'successRate' => 100.00,
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([ // id 2
            'name' => 'player2',
            'email' => 'correo2@ejemplo2.com',
            'email_verified_at' => now(),
            'password' => 123456789,
            'wins' => 0,
            'losses' => 1,
            'gamesPlayed' => 1,
            'successRate' => 00.00,
            'role' => 'user',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([ // id 3
            'name' => 'player3',
            'email' => 'correo3@ejemplo3.com',
            'email_verified_at' => now(),
            'password' => 123456789,
            'wins' => 1,
            'losses' => 0,
            'gamesPlayed' => 1,
            'successRate' => 100.00,
            'role' => 'user',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
