<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testProfileSuccess(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => UploadedFile::fake()->image('test.jpg'),
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => fake()->streetAddress(),
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
        ]);

        //テストで使用した画像を削除するための処理
        $profile = Profile::where('user_id', $user->id)->first();
        Storage::disk('public')->delete('/profiles/' . $profile->img);
    }

    public function testProfileSuccessImgNull(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => fake()->streetAddress(),
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
        ]);
    }

    public function testProfileSuccessBuildingNull(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
        ]);
    }

    public function testProfileErrorImgTypeImage(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => 'test',
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('img');
    }

    public function testProfileErrorImgMax(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => UploadedFile::fake()->image('test.jpg')->size(5001),
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('img');
    }

    public function testProfileErrorNameRequired(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => null,
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('name');
    }

    public function testProfileErrorNameString(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => 1111,
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('name');
    }

    public function testProfileErrorNameMax(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->realText(192),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('name');
    }

    public function testProfileErrorPostCodeRequired(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => null,
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('post_code');
    }

    public function testProfileErrorPostCodeString(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => 444-4444,
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('post_code');
    }

    public function testProfileErrorPostCodeFormat(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('post_code');
    }

    public function testProfileErrorAddressRequired(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => null,
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('address');
    }

    public function testProfileErrorAddressString(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => 1111,
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('address');
    }

    public function testProfileErrorAddressMax(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->realText(192),
            'building' => null,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('address');
    }

    public function testProfileErrorBuildingString(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => 1111,
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('building');
    }

    public function testProfileErrorBuildingMax(): void
    {
        $user = User::factory()->create();
        $profileData = [
            'img' => null,
            'name' => fake()->name(),
            'post_code' => fake()->numberBetween(100, 999) . '-' . sprintf('%04d', fake()->numberBetween(1, 9999)),
            'address' => fake()->address(),
            'building' => fake()->realText(192),
        ];
        $response = $this->actingAs($user)->post('/mypage/profile', $profileData);
        $response->assertSessionHasErrors('building');
    }
}
