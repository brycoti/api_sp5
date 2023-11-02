<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\RollDiceController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 
use App\Models\User;
use App\Models\DiceRoll;



use function PHPUnit\Framework\assertCount;

class UserRollTest extends TestCase
{

    use RefreshDatabase;
    public function test_user_can_roll_the_dice(){

        Role::create(['name' => 'user']); 

        $this->assertCount(0, DiceRoll::all());
        $this->assertDatabaseCount('users', 0);

        $user = User::factory()->create()->assignRole('user'); 

        $response = $this->actingAs($user, 'api')->json('POST', route('user.api.v1.rollIt', ['id' => $user->id]))
        ->assertStatus(200)->assertJsonStructure([
            'dice1',
            'dice2',
            'total',
            'isWin',
            'message',
        ]);

        $this->assertCount(1, DiceRoll::all()); // El usuario crea una tirada de dado

        $response->dump();

        $response->assertStatus(200);

        $response = $this->assertDatabaseHas('users', [ // El usuario guarda la tirada de dado
            'gamesPlayed' => 1,
        ]);

        $this->assertDatabaseCount('users', 1); // El usuario se crea
    }

    
}