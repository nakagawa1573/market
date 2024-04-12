<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testPurchaseSuccess(): void
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $this->actingAs($user)->post('/purchase/'.$item->id);
        $this->assertDatabaseHas('purchase_histories',[
            'user_id' => $user->id,
        ]);
    }

    public function testPurchaseErrorAgain()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $this->actingAs($user)->post('/purchase/' . $item->id);
        $this->actingAs($user)->post('/purchase/' . $item->id);
        $item = PurchaseHistory::where('item_id', $item->id)->count();
        $this->assertFalse($item > 1);
    }

    public function testPurchaseNotLogin()
    {
        $item = Item::inRandomOrder()->first();
        $response = $this->followingRedirects()->post('/purchase/' . $item->id);
        $response->assertViewIs('auth.login');
    }

    
}
