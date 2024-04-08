<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'user_id' => 1,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'AFG-2',
            'brand' => 'MAGPUL',
            'price' => '6000',
            'description' => 'カラー:コヨーテ<br><br>使用感有<br>購入後、即発送します',
            'img' => '1000005506.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'status_id' => 1,
            'name' => 'CTR Stock & QD Sling Swivel',
            'brand' => 'MAGPUL',
            'price' => '15000',
            'description' => 'カラー:コヨーテ<br><br>新品<br>購入後、即発送します',
            'img' => '1000005828.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'status_id' => 1,
            'name' => 'タクティカルブーツ',
            'brand' => 'HAIX',
            'price' => '25000',
            'description' => 'カラー:コヨーテ<br><br>サイズ:26cm<br><br>新品<br>購入後、即発送します',
            'img' => '1000008739.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => '耳栓',
            'brand' => '3M',
            'price' => '3000',
            'description' => '購入後、即発送します',
            'img' => 'afdsfd.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => '大型バッグ（仏軍配給品）',
            'brand' => '不明',
            'price' => '15000',
            'description' => '容量:100L<br><br>購入後、即発送します',
            'img' => 'bag1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'リュックサック（仏軍配給品）',
            'brand' => '不明',
            'price' => '10000',
            'description' => '容量:30L<br><br>購入後、即発送します',
            'img' => 'bag2.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'AMP72',
            'brand' => '5.11',
            'price' => '50000',
            'description' => 'カラー:OD<br><br>容量:40L<br><br>新品<br>購入後、即発送します',
            'img' => 'bag3.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'Predator Triton 17X',
            'brand' => 'Predator',
            'price' => '200000',
            'description' => '購入後、即発送します',
            'img' => 'pc.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => '仏軍迷彩服(夏用)',
            'brand' => '不明',
            'price' => '10000',
            'description' => 'サイズ:不明<br><br>購入後、即発送します',
            'img' => 'PXL_20230920_070659751.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'スクラッチ寄せ集め',
            'brand' => '不明',
            'price' => '30000',
            'description' => '購入後、即発送します',
            'img' => 'PXL_20240406_014601938.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'びっくりチキン',
            'brand' => 'Pclife',
            'price' => '500',
            'description' => '購入後、即発送します',
            'img' => 'PXL_20240406_014617204.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'ハーフラック、バーベル、ベンチ',
            'brand' => '不明',
            'price' => '50000',
            'description' => '購入後、即発送します',
            'img' => 'PXL_20240406_014632400.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'バトルロープ',
            'brand' => 'Yes4All',
            'price' => '3000',
            'description' => '購入後、即発送します',
            'img' => 'PXL_20240406_014652486.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'ケトルベル',
            'brand' => '不明',
            'price' => '3000',
            'description' => '重量:16kg<br><br>購入後、即発送します',
            'img' => 'PXL_20240406_014722038.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => User::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'name' => 'Dragon Egg Mk2',
            'brand' => 'Direct Action',
            'price' => '20000',
            'description' => '容量:25L<br><br>購入後、即発送します',
            'img' => 'PXL_20240406_014732240.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('items')->insert($param);
    }
}
