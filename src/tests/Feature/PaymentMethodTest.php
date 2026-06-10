<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_購入時に選択した支払い方法が保存される()
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

        $this->get('/order/success/' . $item->id . '?payment_method=2');

        $this->assertDatabaseHas('orders', [
            'buyer_user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 2,
        ]);
    }
}
