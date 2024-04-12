<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess(): void
    {
        $this->post('/register', [
            'email' => 'testtest@test.com',
            'password' => '123456789',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'testtest@test.com',
        ]);
    }

    public function testRegisterErrorEmailRequired()
    {
        $response = $this->post('/register', [
            'email' => null,
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testRegisterErrorEmailTypeEmail()
    {
        $response = $this->post('/register', [
            'email' => 'testtest',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testRegisterErrorEmailUnique()
    {
        $user = User::factory()->create();
        $response = $this->post('/register', [
            'email' => $user->email,
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testRegisterErrorEmailString()
    {
        $response = $this->post('/register', [
            'email' => ['testtest@test.com'],
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testRegisterErrorEmailMax()
    {
        $response = $this->post('/register', [
            'email' => fake()->realText(192).'@test.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testRegisterErrorPasswordRequired()
    {
        $response = $this->post('/register', [
            'email' => 'testtest@test.com',
            'password' => null,
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function testRegisterErrorPasswordString()
    {
        $response = $this->post('/register', [
            'email' => 'testtest@test.com',
            'password' => 123456789,
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function testRegisterErrorPasswordMin()
    {
        $response = $this->post('/register', [
            'email' => 'testtest@test.com',
            'password' => '1234567',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function testRegisterErrorPasswordmax()
    {
        $response = $this->post('/register', [
            'email' => 'testtest@test.com',
            'password' => fake()->realText(192),
        ]);
        $response->assertSessionHasErrors('password');
    }
}
