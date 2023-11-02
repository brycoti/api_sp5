<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;
use App\Models\DiceRoll;



class UserShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_show_their_roll_dices_empty(){
        Role::create(['name' => 'user']);
        $user = User::factory()->create()->assignRole('user');
        DiceRoll::create([
            'user_id' => $user->id,
            'dice1' => 1,
            'dice2' => 6,
            'total' => 7,
            'win' => 1,
        ]);

        $this->assertCount(1, DiceRoll::all());
        
        $response = $this->actingAs($user, 'api')->json('GET', route('user.api.v1.show', ['id' => $user->id]));

        $this->assertDatabaseHas('dice_rolls', [
            'user_id' => $user->id
        ]);

        $response->assertStatus(200);
    }
}
