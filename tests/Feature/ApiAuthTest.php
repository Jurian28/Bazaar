<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_register_then_me_then_logout_then_me_null_then_login(): void
    {
        // Register
        $payload = [
            'name' => 'Jane Tester',
            'email' => 'jane@example.com',
            'password' => 'Password123!'
        ];
        $res = $this->postJson('/api/v1/auth/register', $payload);
        $res->assertCreated()
            ->assertJsonPath('user.email', 'jane@example.com');

        // Me (authenticated via session)
        $this->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('user.email', 'jane@example.com');

        // Logout
        $this->postJson('/api/v1/auth/logout')
            ->assertOk();

        // Me should be null
        $this->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJson(['user' => null]);

        // Login
        $this->postJson('/api/v1/auth/login', [
            'email' => 'jane@example.com',
            'password' => 'Password123!'
        ])->assertOk()->assertJsonPath('user.email', 'jane@example.com');
    }

    public function test_login_with_invalid_credentials_and_double_login_register(): void
    {
        // Create user
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => 'Password123!',
        ]);

        // Invalid credentials
        $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'wrong-password',
        ])->assertStatus(422);

        // Login valid
        $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Password123!',
        ])->assertOk();

        // Already logged in → login/register should return 400
        $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Password123!',
        ])->assertStatus(400);

        $this->postJson('/api/v1/auth/register', [
            'name' => 'Dup',
            'email' => 'dup@example.com',
            'password' => 'Password123!'
        ])->assertStatus(400);
    }
}
