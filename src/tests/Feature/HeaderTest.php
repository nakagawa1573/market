<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HeaderTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */

    public function testAccessIndexPage()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
        ->assertViewIs('index');
    }

    public function testAccessLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    public function testAccessLoginPageLoginStatus()
    {
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->get('/login');
        $response->assertStatus(200)
            ->assertViewIs('index');
    }

    public function testAccessRegisterPage()
    {
        $response = $this->get('/register');
        $response->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    public function testAccessRegisterPageLoginStatus()
    {
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->get('/register');
        $response->assertStatus(200)
            ->assertViewIs('index');
    }

    public function testAccessMyPage()
    {
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->get('/mypage');
        $response->assertStatus(200)
            ->assertViewIs('mypage');
    }

    public function testAccessMyPageNotLoginStatus()
    {
        $response = $this->followingRedirects()->get('/mypage');
        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    public function testAccessSellPageNotLoginStatus()
    {
        $response = $this->followingRedirects()->get('/sell');
        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    public function testLogoutSuccess()
    {
        $user = User::factory()->create();
        $this->followingRedirects()->actingAs($user)->post('/logout');
        $this->assertTrue(auth()->guest());
    }

    public function testLogoutNotLoginStatus()
    {
        $user = User::factory()->create();
        $response = $this->followingRedirects()->post('/logout');
        $response->assertStatus(200)
            ->assertViewIs('index');
    }

    public function testSearchInName(): void
    {
        $item = Item::factory()->create();
        $keyword['keyword'] = $item->name;
        $response = $this->get(route('search', $keyword));
        $response->assertStatus(200)
            ->assertViewIs('search')
            ->assertSee($item->name)
            ->assertSee(number_format($item->price));
    }

    public function testSearchInBrand(): void
    {
        $item = Item::factory()->create();
        $keyword['keyword'] = $item->brand;
        $response = $this->get(route('search', $keyword));
        $response->assertStatus(200)
            ->assertViewIs('search')
            ->assertSee($item->name)
            ->assertSee(number_format($item->price));
    }

    public function testSearchInCategory(): void
    {
        $item = Item::factory()->create();
        $count = Category::all()->count();
        $categories = Category::inRandomOrder()->take(rand(1, $count))->get();
        foreach ($categories as $category) {
            ItemCategory::create([
                'item_id' => $item->id,
                'category_id' => $category->id,
            ]);
            $keyword['keyword'] = $category->name;
            $response = $this->get(route('search', $keyword));
            $response->assertStatus(200)
                ->assertViewIs('search')
                ->assertSee($item->name)
                ->assertSee(number_format($item->price));
        }
    }

    public function testSearchErrorKeywordNull()
    {
        $item = Item::factory()->create();
        $keyword['keyword'] = null;
        $response = $this->get(route('search', $keyword));
        $response->assertStatus(200)
            ->assertViewIs('search')
            ->assertSee('キーワード検索、または絞り込みで商品を検索してください。');
    }

}
