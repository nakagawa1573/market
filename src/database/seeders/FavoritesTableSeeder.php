<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i < 7; $i++) {
            $param = [
                'user_id' => 1,
                'item_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('favorites')->insert($param);
        }
        Favorite::factory()->count(30)->create();
    }
}
