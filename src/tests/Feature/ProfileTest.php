<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_プロフィール情報を更新できる()
    {
        $user = User::create([
            'name' => '変更前ユーザー',
            'email' => 'profile@example.com',
            'password' => bcrypt('password123'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        $this->actingAs($user);

        $this->post('/mypage/profile', [
            'name' => '変更後ユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '変更後ユーザー',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building_name' => 'テストビル',
        ]);
    }
    public function test_プロフィール編集画面で登録済み情報が初期値として表示される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'profile-edit@example.com',
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

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル');
        $response->assertSee('profiles/test.jpg');
    }
}
