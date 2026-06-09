<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品名で部分一致検索ができる()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        Item::create([
            'user_id' => $user->id,
            'name' => '革靴',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 2000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $response = $this->get('/?keyword=腕');

        $response->assertSee('腕時計');
        $response->assertDontSee('革靴');
    }
    public function test_検索状態がマイリストでも保持されている()
    {
        $response = $this->get('/?keyword=腕');

        $response->assertSee(
            'http://localhost?tab=mylist&amp;keyword=腕',
            false
        );
    }
}
