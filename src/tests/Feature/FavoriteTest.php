<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねした商品として登録できる()
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

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($user);

        $this->post('/item/' . $item->id . '/favorite');

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
    public function test_いいね済みの場合アイコンが変化する()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'icon@example.com',
            'password' => bcrypt('password123'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller-icon@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/item/' . $item->id);

        $response->assertSee('heart-active.png');
    }
    public function test_再度いいねを押すと解除できる()
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

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $this->post('/item/' . $item->id . '/favorite');

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
