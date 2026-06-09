<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねした商品だけが表示される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        $likedItem = Item::create([
            'user_id' => $seller->id,
            'name' => 'いいねした商品',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        Item::create([
            'user_id' => $seller->id,
            'name' => 'いいねしていない商品',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 2000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }
    public function test_購入済み商品はsoldと表示される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '革靴',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 3000,
            'image_path' => 'test.jpg',
            'is_sold' => true,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');
    }
    public function test_未認証の場合は何も表示されない()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller3@example.com',
            'password' => bcrypt('password123'),
        ]);

        Item::create([
            'user_id' => $seller->id,
            'name' => '表示されない商品',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 3000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('表示されない商品');
    }
}
