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
            'role' => 'admin',
            'email' => 'test@test.com',
            'password' => Hash::make(123456789),
            'stripe_account_id' => 'acct_1P5JLMPeBToOxOeF',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);

        User::factory()->count(50)->create();
    }
}
