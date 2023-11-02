<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laravel\Passport\Passport;



class UpdateUserNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_their_name(){
        $user = User::factory()->create();

        $user->assignRole(Role::create(['name' => 'user'])); 

        $this->assertTrue($user->hasRole('user')); // Verifica si el usuario tiene el rol 'user'

        // Simula la autenticación de un usuario sin necesidad de un token real
        Passport::actingAs($user, ['*']);
    
        $user->assignRole(Role::create(['name' => 'user']));
    
        $modifiedName = 'Modified';
    
        // No es necesario utilizar withHeaders() cuando se utiliza Passport::actingAs()
        $response = $this->json('PUT', route('user.api.v1.updateName', ['id' => $user->id]), [
            'name' => $modifiedName,
        ]);

        $response->assertJsonFragment([ // Verifica si el nombre se actualizó correctamente
            'name' => $modifiedName,
        ]);
    
        $this->assertDatabaseHas('users', [ // Verifica si el nombre se actualizó en la base de datos
            'id' => $user->id,
            'name' => $modifiedName
        ]);
    
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [ // Verifica si el nombre se actualizó en la base de datos
            'id' => $user->id,
            'name' => $modifiedName
        ]);

    }
}
