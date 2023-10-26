<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;



class ExampleTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
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



    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // login test
    public function test_login(): void
    {
       $user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('password1'),
            'name' => 'test',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $response = $this->post('v1/login', [
            'email' => 'test@example.com',
            'password' => 'password1',
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
