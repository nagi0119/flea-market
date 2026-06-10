<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;


class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_配送先住所を変更できる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $this->post('/order/address/1', [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building_name' => 'テストビル',
        ]);
    }
    public function test_変更した配送先住所が購入画面に反映される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'address2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller-address@example.com',
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

        $this->actingAs($user);

        $this->post('/order/address/' . $item->id, [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);

        $response = $this->get('/item/' . $item->id . '/order');

        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル');
    }
}
