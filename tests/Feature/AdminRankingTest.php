<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 

class AdminRankingTest extends TestCase
{
     use RefreshDatabase;

    public function test_admin_can_see_all_users()
    { 
        Role::create(['name' => 'admin']);
        
        $admin = User::factory()->create()->assignRole('admin');
        
        $response = $this->actingAs($admin, 'api')->json('GET', route('admin.api.v1.ranking'))->assertStatus(200);

    }

    public function test_user_can_not_see_the_ranking(){
        Role::create(['name' => 'user']); 
        $user = User::factory()->create()->assignRole('user');

        $response = $this->actingAs($user, 'api')->json('GET', route('admin.api.v1.ranking'))->assertStatus(403);

    }
         

}
