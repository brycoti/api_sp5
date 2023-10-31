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

class UserRollDiceControllerTest extends TestCase
{

    use RefreshDatabase;
    public function test_user_can_roll_the_dice(){

        Role::create(['name' => 'user']); 

        $user = User::factory()->create()->assignRole('user');

        $response = $this->actingAs($user, 'api')->json('POST', route('user.api.v1.rollIt', ['id' => $user->id]))
        ->assertStatus(200)->assertJsonStructure([
            'dice1',
            'dice2',
            'total',
            'isWin',
            'message',
        ]);

        $this->assertDatabaseHas('dice_rolls', [
            'user_id' => $user->id
        ]);

        $response->dump();
        
    }
}