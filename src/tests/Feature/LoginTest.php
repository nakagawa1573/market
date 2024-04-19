<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testLoginSuccess(): void
    {
        $user = User::factory()->create();
        $this->post('/login',[
            'email' => $user->email,
            'password' => '123456789'
        ]);
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginErrorEmailRequired(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => null,
            'password' => '123456789'
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testLoginErrorEmailString(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => [$user->email],
            'password' => '123456789'
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testLoginErrorPasswordRequired(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => null
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function testLoginErrorPasswordString(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => ['123456789']
        ]);
        $response->assertSessionHasErrors('password');
    }
}
