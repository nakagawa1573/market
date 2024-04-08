<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'email' => 'test@test.com',
            'password' => Hash::make(123456789),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);

        User::factory()->count(10)->create();
    }
}
