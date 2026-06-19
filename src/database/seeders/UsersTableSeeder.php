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
                'name' => 'aaa',
                'email' => 'aaa@example.com',
                'password' => Hash::make('11111111'),
                'email_verified_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'bbb',
                'email' => 'bbb@example.com',
                'password' => Hash::make('11111111'),
                'email_verified_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'ccc',
                'email' => 'ccc@example.com',
                'password' => Hash::make('11111111'),
                'email_verified_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'ddd',
                'email' => 'ddd@example.com',
                'password' => Hash::make('11111111'),
                'email_verified_at' => now(),
            ],

        ]);
    }
}
