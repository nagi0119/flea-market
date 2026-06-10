<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品を出品できる()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        $category = Category::create([
            'name' => 'ファッション',
            'sort_order' => 1,
        ]);

        $this->actingAs($user);

        Storage::fake('public');

        $response = $this->post('/sell', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => '商品説明',
            'price' => 1000,
            'item_condition' => 1,
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => '商品説明',
            'price' => 1000,
            'item_condition' => 1,
            'is_sold' => false,
        ]);

        $this->assertDatabaseHas('item_categories', [
            'category_id' => $category->id,
        ]);
    }
}
