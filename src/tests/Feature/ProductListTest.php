<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function test_全商品を取得できる()
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

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }
    public function test_購入済み商品はsoldと表示される()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password123'),
        ]);

        Item::create([
            'user_id' => $user->id,
            'name' => '革靴',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 3000,
            'image_path' => 'test.jpg',
            'is_sold' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }
    public function test_自分が出品した商品は表示されない()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Item::create([
            'user_id' => $user->id,
            'name' => '自分の商品',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertDontSee('自分の商品');
    }
}
