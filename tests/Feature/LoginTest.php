<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Hash;



class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );

        // Manually set the client ID in the Passport configuration
        app()->instance(Client::class, $client);
    }

    public function test_login(): void{
       $user2 = User::create([
            'id' => 2,
            'email' => 'test@example2.com',
            'password' => bcrypt('password2'),
            'name' => 'test2',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post('v1/login', [ // password matches
            'email' => 'test@example2.com',
            'password' => 'password2',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
        ]);
        

        $response = $this->post('v1/login', [ // password does not match
            'email' => 'test@example.com',
            'password' => 'inco',

        ]);
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
        
        $response = $this->post('v1/login', [ // email does not exist
            'email' => 'incorrect-email@example.com',
            'password' => 'password1',
        ]);
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);

    }
}
