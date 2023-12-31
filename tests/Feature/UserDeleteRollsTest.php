<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\DiceRoll;

class UserDeleteRollsTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_delete_rolls(){

        Role::create(['name' => 'user']);
        $user = User::factory()->create()->assignRole('user');

        DiceRoll::create([ // create a roll
            'user_id' => $user->id,
            'dice1' => 1,
            'dice2' => 1,
            'total' => 2,
            'isWin' => false
        ]);

        $this->assertCount(1, DiceRoll::all()); // check if there is 1 roll

        $response = $this->actingAs($user, 'api')->json('DELETE', route('user.api.v1.delete', ['id' => $user->id]))
        ->assertStatus(200); //

        $this->assertCount(0, DiceRoll::all()); // check if there is 0 roll

        $this->assertDatabaseMissing('dice_rolls', [
            'user_id' => $user->id
        ]);
    }
}
