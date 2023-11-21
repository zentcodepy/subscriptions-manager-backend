<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function user_can_login()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $data = ['email' => $user->email, 'password' => 'password'];

        $response = $this->postJson('api/login', $data);

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }

    /** @test */
    public function user_cant_login_if_provide_wrong_password()
    {
        $user = User::factory()->create();
        $data = ['email' => $user->email, 'password' => 'banana'];

        $this->postJson('/sanctum/csrf-cookie');
        $response = $this->postJson('api/login', $data);

        $response->assertStatus(422);
        $this->assertGuest();
    }
}
