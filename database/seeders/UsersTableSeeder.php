<?php

namespace Database\Seeders;

use App\Models\User;

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
        User::create([ // id 1
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => 123456789999,
            'wins' => 4,
            'losses' => 0,
            'gamesPlayed' => 4,
            'successRate' => 100.00,
            'remember_token' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('admin');

        User::create([ // id 2
            'name' => 'player2',
            'email' => 'correo2@ejemplo2.com',
            'email_verified_at' => now(),
            'password' => 123456789999,
            'wins' => 0,
            'losses' => 1,
            'gamesPlayed' => 1,
            'successRate' => 00.00,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('user');

        User::create([ // id 3
            'name' => 'player3',
            'email' => 'correo3@ejemplo3.com',
            'email_verified_at' => now(),
            'password' => 123456789999,
            'wins' => 1,
            'losses' => 0,
            'gamesPlayed' => 2,
            'successRate' => 50.00,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('user');
    }
}
