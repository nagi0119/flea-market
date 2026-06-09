<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            ['name' => 'ファッション'],
            ['name' => '家電'],
            ['name' => 'キッチン'],
            ['name' => 'メンズ'],
            ['name' => 'レディース'],
            ['name' => 'アクセサリー'],
            ['name' => 'コスメ'],
            ['name' => '雑貨'],
            ['name' => 'PC・周辺機器'],
            ['name' => 'オーディオ'],
            ['name' => '食品'],
            ['name' => 'バッグ'],
            ['name' => '靴'],
            ['name' => '美容'],
            ['name' => '生活用品'],
        ]);
    }
}
