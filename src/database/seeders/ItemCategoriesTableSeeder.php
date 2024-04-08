<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ItemCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'item_id' => 1,
            'category_id' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 2,
            'category_id' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 3,
            'category_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 3,
            'category_id' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 4,
            'category_id' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 5,
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 6,
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 6,
            'category_id' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 7,
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 7,
            'category_id' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 8,
            'category_id' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 9,
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 9,
            'category_id' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 10,
            'category_id' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 11,
            'category_id' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 12,
            'category_id' => 13,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 13,
            'category_id' => 13,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 14,
            'category_id' => 13,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 15,
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);

        $param = [
            'item_id' => 15,
            'category_id' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('item_categories')->insert($param);
    }
}
