<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'id' => 1,
                'name' => '田中太郎',
                'email' => 'tanaka@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 2,
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 3,
                'name' => '鈴木一郎',
                'email' => 'suzuki@example.com',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
