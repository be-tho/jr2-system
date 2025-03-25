<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'beto@gmail.com',
            'password' => bcrypt('admin'),
            'image' => 'https://randomuser.me/api/portraits/thumb/women/13.jpg',
        ]);
    }
}
