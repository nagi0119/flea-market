<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_未認証ユーザーはプロフィール画面にアクセスできずメール認証画面にリダイレクトされる()
    {
        $user = User::create([
            'name' => '未認証ユーザー',
            'email' => 'unverified@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertRedirect('/email/verify');
    }

    public function test_メール認証ができる()
    {
        Event::fake();

        $user = User::create([
            'name' => '認証ユーザー',
            'email' => 'verified@example.com',
            'password' => bcrypt('password123'),
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $this->actingAs($user);

        $response = $this->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
