<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($user);

        $this->post('/item/' . $item->id . '/comment', [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }
    public function test_ログイン前ユーザーはコメントを送信できない()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->post('/item/' . $item->id . '/comment', [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }
    public function test_コメント未入力の場合バリデーションエラーになる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'empty@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($user);

        $response = $this->post('/item/' . $item->id . '/comment', [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }
    public function test_コメントが255文字以上の場合バリデーションエラーになる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'long@example.com',
            'password' => bcrypt('password123'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'item_condition' => 1,
            'description' => 'テスト商品',
            'price' => 1000,
            'image_path' => 'test.jpg',
            'is_sold' => false,
        ]);

        $this->actingAs($user);

        $response = $this->post('/item/' . $item->id . '/comment', [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }
}
