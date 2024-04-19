<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testAccessSellPage()
    {
        $user = User::factory()->create();
        $user['stripe_account_id'] = 'acct_1P5JLMPeBToOxOeF';
        $response = $this->followingRedirects()->actingAs($user)->get('/sell');
        $response->assertStatus(200)
            ->assertViewIs('sell');
    }

    public function testAccessSellPageAccountIdNull()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/sell');
        $this->assertStringContainsString('https://connect.stripe.com/setup/e/', $response->headers->get('Location'));
    }

    public function testSellSuccess(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => fake()->realText(10),
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
        ]);
        //テストで使用した画像を削除するための処理
        $item = Item::where('user_id', $user->id)->first();
        Storage::disk('public')->delete('/items/' . $item->img);
    }

    public function testSellSuccessNullBrand(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
        ]);
        //テストで使用した画像を削除するための処理
        $item = Item::where('user_id', $user->id)->first();
        Storage::disk('public')->delete('/items/' . $item->img);
    }

    public function testSellNotLogin(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->followingRedirects()->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $this->assertDatabaseMissing('items', [
            'user_id' => $user->id,
        ]);
        $response->assertViewIs('auth.login');
    }

    public function testSellErrorImgRequired()
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => null,
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('img');
    }


    public function testSellErrorImgTypeImage()
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => 'test.jpg',
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('img');
    }

    public function testSellErrorImgMax()
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg')->size(10001),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('img');
    }

    public function testSellErrorCategoryRequired()
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => null,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('category_id');
    }

    public function testSellErrorCategoryArray()
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => 1,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('category_id');
    }

    public function testSellErrorCategoryNumeric()
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => ['test', 'test2'],
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('category_id.*');
    }

    public function testSellErrorStatusRequired(): void
    {
        $user = User::factory()->create();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => null,
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('status_id');
    }

    public function testSellErrorStatusNumeric(): void
    {
        $user = User::factory()->create();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => fake()->realText(10),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('status_id');
    }

    public function testSellErrorStatusBetween(): void
    {
        $user = User::factory()->create();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => 5,
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('status_id');
    }

    public function testSellErrorNameRequired(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => null,
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function testSellErrorNameString(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => 1111,
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function testSellErrorNameMax(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(192),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function testSellErrorBrandString(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => 1111,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('brand');
    }

    public function testSellErrorBrandMax(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => fake()->realText(192),
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('brand');
    }

    public function testSellErrorDescriptionRequired(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => null,
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('description');
    }

    public function testSellErrorDescriptionString(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => 1111,
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('description');
    }

    public function testSellErrorDescriptionMax(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(201),
            'price' => fake()->numberBetween(1000, 1000000000),
        ]);
        $response->assertSessionHasErrors('description');
    }

    public function testSellErrorPriceRequired(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => null,
        ]);
        $response->assertSessionHasErrors('price');
    }

    public function testSellErrorPriceNumeric(): void
    {
        $user = User::factory()->create();
        $countStatus = Status::all()->count();
        $countCategory = Category::all()->count();
        for ($i = 0; $i < rand(1, $countCategory); $i++) {
            $categoryIds[] = rand(1, $countCategory);
        }
        $categoryIds = array_unique($categoryIds);
        $response = $this->actingAs($user)->post('/sell', [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $categoryIds,
            'status_id' => rand(1, $countStatus),
            'brand' => null,
            'name' => fake()->realText(10),
            'description' => fake()->realText(50),
            'price' => 'test',
        ]);
        $response->assertSessionHasErrors('price');
    }

}
