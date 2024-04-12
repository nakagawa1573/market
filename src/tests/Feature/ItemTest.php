<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ItemTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testFavoriteSuccess(): void
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->post('/item/favorite/' . $item->id);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
        ]);
    }

    public function testFavoriteErrorNotLogin(): void
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->post('/item/favorite/' . $item->id);
        $response->assertRedirect('/login');
    }

    public function testFavoriteErrorAgain(): void
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $this->get('/item/' . $item->id);
        $this->actingAs($user)->post('/item/favorite/' . $item->id);
        $response = $this->followingRedirects()->actingAs($user)->post('/item/favorite/' . $item->id);
        $favorite = Favorite::where('user_id', $user->id)->count();
        $this->assertTrue($favorite == 1);
    }

    public function testViewFavoriteCount()
    {
        $item = Item::inRandomOrder()->first();
        $count = Favorite::where('item_id', $item->id)->count();
        $response = $this->get('/item/' . $item->id);
        $favoriteCount = $response->viewData('favoriteCount');
        $this->assertEquals($count, $favoriteCount);
    }

    public function testViewCommentCount()
    {
        $item = Item::inRandomOrder()->first();
        $count = Comment::where('item_id', $item->id)->count();
        $response = $this->get('/item/' . $item->id);
        $commentCount = $response->viewData('commentCount');
        $this->assertEquals($count, $commentCount);
    }

    public function testCommentSuccess()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $count = Comment::where('item_id', $item->id)->count();
        $response = $this->actingAs($user)->post('/item/comment/'.$item->id,[
            'comment' => 'testest'
        ]);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
        ]);
    }

    public function testCommentErrorNotLogin()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->followingRedirects()->post('/item/comment/' . $item->id, [
            'comment' => 'testest'
        ]);
        $response->assertViewIs('auth.login');
        $this->assertDatabaseMissing('comments',[
            'user_id' => $user->id,
        ]);
    }

    public function testCommentErrorRequired()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->post('/item/comment/' . $item->id, [
            'comment' => null,
        ]);
        $response->assertSessionHasErrors('comment');
    }

    public function testCommentErrorString()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->post('/item/comment/' . $item->id, [
            'comment' => 111111,
        ]);
        $response->assertSessionHasErrors('comment');
    }

    public function testCommentErrorMax()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->post('/item/comment/' . $item->id, [
            'comment' => fake()->realText(201)
        ]);
        $response->assertSessionHasErrors('comment');
    }

    public function testAccessPurchasePage()
    {
        $user = User::factory()->create();
        $item = Item::inRandomOrder()->first();
        $response = $this->actingAs($user)->get('/purchase/'.$item->id);
        $response->assertStatus(200)->assertViewIs('purchase');
    }

    public function testAccessPurchasePageNotLogin()
    {
        $item = Item::inRandomOrder()->first();
        $response = $this->followingRedirects()->get('/purchase/' . $item->id);
        $response->assertStatus(200)->assertViewIs('auth.login');
    }
}
