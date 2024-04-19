<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            '洋服', 'カバン', '靴', 'レディース', 'メンズ', 'ゲーム・おもちゃ',
            '楽器', '本', 'CD・DVD', 'スマホ・タブレット・PC',
            'テレビ', '家電', 'スポーツ', 'アウトドア', 'その他',
        ];

        foreach ($categories as $category) {
            $param = [
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('categories')->insert($param);
        }
    }
}
