<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\PurchaseHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testAccessItemPage(): void
    {
        $item = Item::with('category')->inRandomOrder()->first();
        $response = $this->get('/item/'. $item->id);
        $response->assertStatus(200)
            ->assertViewIs('item')
            ->assertSee($item->name)
            ->assertSee($item->brand)
            ->assertSee(number_format($item->price));
    }

    public function testRecommendationItem()
    {
        $response = $this->get('/');
        $weekAgo = Carbon::now()->subWeek();
        $now = Carbon::now();
        $items = Item::where([
            ['created_at', '>=', $weekAgo],
            ['created_at', '<=', $now],
        ])->get();
        foreach ($items as $item) {
            if (PurchaseHistory::where('item_id', $item->id)->exists()) {
                $key = $items->search($item);
                $items->pull($key);
            }
        }
        $viewItems = $response->viewData('items');
        $this->assertEquals($items, $viewItems);
    }
}
