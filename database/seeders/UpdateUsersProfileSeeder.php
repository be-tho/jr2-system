<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUsersProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Actualizar usuarios existentes con valores por defecto para los nuevos campos
        User::whereNull('profile_image')->update([
            'profile_image' => 'usuario.jpg',
            'email_notifications' => true,
            'dark_mode' => false,
            'language' => 'es'
        ]);

        // Si no hay usuarios, crear uno de ejemplo
        if (User::count() === 0) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@jr2system.com',
                'password' => Hash::make('password'),
                'profile_image' => 'usuario.jpg',
                'email_notifications' => true,
                'dark_mode' => false,
                'language' => 'es'
            ]);
        }

        $this->command->info('Usuarios actualizados con campos de perfil exitosamente.');
    }
}
