<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品を購入できる()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
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
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($buyer);

        $this->get('/order/success/' . $item->id . '?payment_method=1');

        $this->assertDatabaseHas('orders', [
            'buyer_user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 1,
        ]);
    }

    public function test_購入した商品は_sold_になる()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($buyer);

        $this->get('/order/success/' . $item->id . '?payment_method=1');

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);
    }
    public function test_購入した商品がマイページの購入一覧に表示される()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer3@example.com',
            'password' => bcrypt('password123'),
        ]);

        $buyer->forceFill([
            'email_verified_at' => now(),
        ])->save();

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller3@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
            'item_condition' => 1,
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($buyer);

        $this->get('/order/success/' . $item->id . '?payment_method=1');

        $response = $this->get('/mypage?tab=buy');

        $response->assertSee('購入済み商品');
    }
}
