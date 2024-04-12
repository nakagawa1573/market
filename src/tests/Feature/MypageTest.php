<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testAccessProfilePage(): void
    {
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200)
            ->assertViewIs('profile');
    }

    public function testAccessProfilePageNotLoginStatus(): void
    {
        $response = $this->followingRedirects()->get('/mypage/profile');
        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    public function testViewSelledItems()
    {
        $item = Item::factory()->create();
        $user = User::find($item->user_id);
        $response = $this->followingRedirects()->actingAs($user)->get('/mypage');
        $sells = $response->viewData('sells');
        $this->assertTrue($sells->contains($item));
    }

    public function testViewPurchasedItems()
    {
        $item = Item::factory()->create();
        $user = User::find($item->user_id);
        $item = PurchaseHistory::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->followingRedirects()->actingAs($user)->get('/mypage');
        $purchases = $response->viewData('purchases');
        $this->assertTrue($purchases->contains($item));
    }
}
