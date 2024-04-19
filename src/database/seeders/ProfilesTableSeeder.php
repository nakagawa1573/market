<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'user_id' => 1,
            'name' => '山田太郎',
            'post_code' => '100-8111',
            'address' => '東京都千代田区千代田1-1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('profiles')->insert($param);
    }
}
