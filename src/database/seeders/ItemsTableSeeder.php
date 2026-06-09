<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        Item::insert([
            [
                'user_id' => 1,
                'name' => '腕時計',
                'item_condition' => 1,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 2,
                'name' => 'HDD',
                'item_condition' => 2,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 3,
                'name' => '玉ねぎ3束',
                'item_condition' => 3,
                'brand_name' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'item_condition' => 4,
                'brand_name' => null,
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'is_sold' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'ノートPC',
                'item_condition' => 1,
                'brand_name' => null,
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 3,
                'name' => 'マイク',
                'item_condition' => 2,
                'brand_name' => null,
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'name' => 'ショルダーバッグ',
                'item_condition' => 3,
                'brand_name' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 2,
                'name' => 'タンブラー',
                'item_condition' => 4,
                'brand_name' => null,
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 3,
                'name' => 'コーヒーミル',
                'item_condition' => 1,
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'name' => 'メイクセット',
                'item_condition' => 2,
                'brand_name' => null,
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'is_sold' => false,
            ],
        ]);
    }
}
