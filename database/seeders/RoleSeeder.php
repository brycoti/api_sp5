<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'user']);

         Permission::create(['name' => 'user.api.v1.logout'])->syncRoles([$roleAdmin, $roleUser]);	
         Permission::create(['name' => 'user.api.v1.updateName'])->syncRoles([$roleAdmin, $roleUser]);
         Permission::create(['name' => 'user.api.v1.rollIt'])->syncRoles([$roleAdmin, $roleUser]);
         Permission::create(['name' => 'user.api.v1.delete'])->syncRoles([$roleAdmin, $roleUser]);
         Permission::create(['name' => 'user.api.v1.show'])->syncRoles([$roleAdmin, $roleUser]);

        // Admin puede ver todos los jugadores, % exito de cada jugador y % total de todos los jugadores
        Permission::create(['name' => 'admin.api.v1.index'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'admin.api.v1.ranking'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'admin.api.v1.loser'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'admin.api.v1.winner'])->syncRoles([$roleAdmin]);


    }
}
