<?php

namespace Tests\Feature;

use App\Models\DeliveryAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testAccessDeliverySuccess(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/purchase/delivery');
        $response->assertViewIs('delivery');
    }

    public function testAccessDeliveryNotLogin()
    {
        $response = $this->followingRedirects()->get('/purchase/delivery');
        $response->assertViewIs('auth.login');
    }

    public function testDeliverySuccess()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => 'test県',
            'building' => 'test',
        ];
        $this->actingAs($user)->post('/purchase/delivery', $data);
        $this->assertDatabaseHas('delivery_addresses', $data);
    }

    public function testDeliverySuccessBuildingNull()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => 'test県',
            'building' => null,
        ];
        $this->actingAs($user)->post('/purchase/delivery', $data);
        $this->assertDatabaseHas('delivery_addresses', $data);
    }

    public function testDeliverySuccessAgain()
    {
        $user = User::factory()->create();
        $OldData = [
            'user_id' => $user->id,
            'post_code' => '444-4444',
            'address' => 'test県',
            'building' => null,
        ];
        DeliveryAddress::create($OldData);
        $NewData = [
            'post_code' => '555-5555',
            'address' => 'test県',
            'building' => null,
        ];
        $this->actingAs($user)->post('/purchase/delivery', $NewData);
        $this->assertDatabaseMissing('delivery_addresses', $OldData);
        $this->assertDatabaseHas('delivery_addresses', $NewData);
    }

    public function testDeliveryNotLogin()
    {
        $data = [
            'post_code' => '444-4444',
            'address' => 'test県',
            'building' => 'test',
        ];
        $response = $this->post('/purchase/delivery', $data);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorPostCodeRequired()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => null,
            'address' => 'test県',
            'building' => 'test',
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('post_code');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorPostCodeFormat()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => 4444444,
            'address' => 'test県',
            'building' => 'test',
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('post_code');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorAddressRequired()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => null,
            'building' => 'test',
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('address');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorAddressString()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => 123456789,
            'building' => 'test',
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('address');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorAddressMax()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => fake()->realText(192),
            'building' => 'test',
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('address');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorBuildingString()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => 'テスト県',
            'building' => 1111,
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('building');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }

    public function testDeliveryErrorBuildingMax()
    {
        $user = User::factory()->create();
        $data = [
            'post_code' => '444-4444',
            'address' => 'テスト県',
            'building' => fake()->realText(192),
        ];
        $response = $this->actingAs($user)->post('/purchase/delivery', $data);
        $response->assertSessionHasErrors('building');
        $this->assertDatabaseMissing('delivery_addresses', $data);
    }
}
