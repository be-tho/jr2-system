<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Costurero;

class CostureroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $costureros = [
            [
                'nombre_completo' => 'María González',
                'direccion' => 'Av. Corrientes 1234, Buenos Aires',
                'celular' => '+54 9 11 1234-5678',
            ],
            [
                'nombre_completo' => 'Carlos Rodríguez',
                'direccion' => 'Calle San Martín 567, Córdoba',
                'celular' => '+54 9 351 987-6543',
            ],
            [
                'nombre_completo' => 'Ana López',
                'direccion' => 'Rivadavia 890, Rosario',
                'celular' => '+54 9 341 456-7890',
            ],
            [
                'nombre_completo' => 'Roberto Fernández',
                'direccion' => 'Belgrano 234, Mendoza',
                'celular' => '+54 9 261 345-6789',
            ],
            [
                'nombre_completo' => 'Laura Martínez',
                'direccion' => 'Sarmiento 456, La Plata',
                'celular' => '+54 9 221 234-5678',
            ],
        ];

        foreach ($costureros as $costurero) {
            Costurero::create($costurero);
        }
    }
}
