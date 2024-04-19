<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => fake()->realText(10),
            'brand' => fake()->realText(10),
            'price' => fake()->numberBetween(1, 10000000),
            'description' => fake()->realText(50),
            'img' => 'PXL_20240406_014732240.jpg',
        ];
    }
}
