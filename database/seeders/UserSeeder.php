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
        // Crear usuario administrador
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'beto@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'image' => 'https://randomuser.me/api/portraits/thumb/women/13.jpg',
        ]);

        // Crear usuario de ejemplo con rol normal
        User::create([
            'id' => 2,
            'name' => 'Katy Villarroel',
            'email' => 'katy@jr2.com',
            'password' => bcrypt('cuenca218'),
            'role' => 'user',
            'image' => 'https://randomuser.me/api/portraits/thumb/men/1.jpg',
            'created_at' => now(),
        ]);
        User::create([
            'id' => 3,
            'name' => 'Judith Villarroel',
            'email' => 'judith@jr2.com',
            'password' => bcrypt('cuenca218'),
            'role' => 'user',
            'image' => 'https://randomuser.me/api/portraits/thumb/men/1.jpg',
            'created_at' => now(),
        ]);
    }
}
