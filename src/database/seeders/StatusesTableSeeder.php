<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['未使用', '良好', '傷、汚れあり', '不良'];

        foreach ($statuses as $status) {
            $param = [
                'name' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('statuses')->insert($param);
        }
    }
}
