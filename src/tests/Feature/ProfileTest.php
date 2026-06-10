<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
