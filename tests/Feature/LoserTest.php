<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 
use App\Models\User;

class LoserTest extends TestCase
{ use RefreshDatabase;
    public function test_admin_can_see_the_loser(){
        Role::create(['name' => 'admin']);
        $admin = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($admin, 'api')->json('GET', route('admin.api.v1.loser'))->assertStatus(200);
    }

    public function test_user_can_not_see_the_loser(){
        Role::create(['name' => 'user']);
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($user, 'api')->json('GET', route('admin.api.v1.loser'))->assertStatus(403);
    }

}
