<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'jain',
            'email' => 'jain@example.com',
            'password' => Hash::make('123'),
        ]);

        $user2 = User::create([
            'name' => 'yepe',
            'email' => 'yepe@example.com',
            'password' => Hash::make('123'),
        ]);
    }
}
