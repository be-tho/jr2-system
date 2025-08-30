<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Crear permisos básicos
        $permissions = [
            'ver cortes',
            'ver articulos',
            'ver categorias',
            'ver temporadas',
            'ver reportes',
            'ver dolar',
            'ver dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos de lectura al rol user
        $userRole->givePermissionTo($permissions);

        // Asignar roles a usuarios existentes
        $adminUser = User::where('email', 'beto@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('administrador');
        }

        $regularUsers = User::whereIn('email', ['katy@jr2.com', 'judith@jr2.com'])->get();
        foreach ($regularUsers as $user) {
            $user->assignRole('user');
        }

        $this->command->info('Roles y permisos configurados correctamente.');
    }
}
