<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'user_id' => 1,
            'item_id' => Item::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('purchase_histories')->insert($param);
    }
}
