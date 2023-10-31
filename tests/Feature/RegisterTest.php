<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase {
    use RefreshDatabase;
    /**
     * Set up the test environment.
     */
    protected function setUp(): void{
        parent::setUp();
    }
    /**
     * A basic feature test example.
     */
    function test_create_user(): void{
       
        Role::create(['name' => 'user']);

        $response = $this->post('v1/players', [ 
            'email' => 'test@example.com',
            'password' => 'password1',
            'name' => 'tester1',
            'password_confirmation' => 'password1',
        ]); 

        $response->assertJsonFragment([ // the answer has correct fields
            'name' => 'tester1',
            'email' => 'test@example.com',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $user->assignRole('user');

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('users', [ // create user in database
            'email' => 'test@example.com',
            'name' => 'tester1',
        ]);

        $this->assertDatabaseHas('roles', [ // create role in database
            'name' => 'user',
        ]);
        
        $this->assertDatabaseHas('model_has_roles', [ // create model_has_roles in database
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);
    }
}
