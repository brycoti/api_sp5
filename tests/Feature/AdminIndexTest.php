<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;


class AdminIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_all_users(){
         
    Role::create(['name' => 'admin']);
        
    $admin = User::factory()->create()->assignRole('admin');
    $users = User::factory()->count(5)->create();

    $this->assertCount(6, User::all());
    
    $response = $this->actingAs($admin, 'api')->json('GET', route('admin.api.v1.index'))->assertStatus(200);
}



public function test_user_can_not_see_all_users (){
         
    Role::create(['name' => 'admin', ]); 
    Role::create(['name' => 'user', ]);
        
    $user = User::factory()->create()->assignRole('user');
    $users = User::factory()->count(5)->create();

    $this->assertCount(6, User::all());
    
    $response = $this->actingAs($user, 'api')->json('GET', route('admin.api.v1.index'))->assertStatus(403);
}

}