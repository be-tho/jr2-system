<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUsersRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Actualizar usuarios existentes que no tengan rol asignado
        User::whereNull('role')->orWhere('role', '')->update(['role' => 'user']);
        
        // Asegurar que beto@gmail.com sea administrador
        User::where('email', 'beto@gmail.com')->update(['role' => 'admin']);
        
        $this->command->info('Roles de usuarios actualizados correctamente.');
    }
}
