<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $this->actingAs($user)->post('/purchase/' . $item->id);
        $this->assertDatabaseHas('purchase_histories', [
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

    public function testAccessPurchasePage()
    {
        $user = User::factory()->create();
        $this->assertNull($user->stripe_customer_id);
        $data = [
            'user_id' => $user->id,
            'name' => 'テスト太郎',
            'post_code' => '111-4444',
            'address' => 'テスト県テスト市',
        ];
        Profile::create($data);
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->get('/purchase/' . $item->id);
        $this->assertNotNull(User::find($user->id)->stripe_customer_id);
        $response->assertStatus(200)
            ->assertViewIs('purchase');
    }

    public function testAccessPurchasePageNotLogin()
    {
        $item = Item::inRandomOrder()->first();
        $response = $this->followingRedirects()->get('/purchase/' . $item->id);
        $response->assertStatus(200)->assertViewIs('auth.login');
    }

    public function testAccessPurchasePageDontHaveProfile()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->get('/purchase/' . $item->id);
        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('message', 'マイページからプロフィールの登録をしてください');
    }
}
