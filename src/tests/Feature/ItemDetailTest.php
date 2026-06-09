<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;
    public function test_必要な情報が表示される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand_name' => 'SEIKO',
            'item_condition' => 1,
            'description' => 'テスト用の商品説明',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertSee('腕時計');
        $response->assertSee('SEIKO');
        $response->assertSee('1,000');
        $response->assertSee('テスト用の商品説明');
        $response->assertSee('良好');
        $response->assertSee('テストユーザー');
        $response->assertSee('テストコメント');
    }
    public function test_複数選択されたカテゴリが表示されている()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'category@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'カテゴリ商品',
            'brand_name' => 'ブランド',
            'item_condition' => 1,
            'description' => 'カテゴリ確認用',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $category1 = Category::create([
            'name' => 'ファッション',
            'sort_order' => 1,
        ]);

        $category2 = Category::create([
            'name' => 'メンズ',
            'sort_order' => 2,
        ]);

        $item->categories()->attach([
            $category1->id,
            $category2->id,
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
