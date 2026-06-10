<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザー情報と出品商品と購入商品が表示される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        Profile::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building_name' => 'テストビル',
            'image_path' => 'profiles/test.jpg',
        ]);

        $seller = User::create([
            'name' => '別ユーザー',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        $sellItem = Item::create([
            'user_id' => $user->id,
            'name' => '出品した商品',
            'item_condition' => 1,
            'description' => '出品商品説明',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $buyItem = Item::create([
            'user_id' => $seller->id,
            'name' => '購入した商品',
            'item_condition' => 1,
            'description' => '購入商品説明',
            'price' => 2000,
            'image_path' => 'test.jpg',
            'is_sold' => true,
        ]);

        Order::create([
            'buyer_user_id' => $user->id,
            'item_id' => $buyItem->id,
            'payment_method' => 1,
            'order_status' => 1,
            'ordered_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertSee('テストユーザー');
        $response->assertSee('出品した商品');

        $response = $this->get('/mypage?tab=buy');

        $response->assertSee('購入した商品');
    }
}
