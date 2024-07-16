<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cortes')->insert([
            [
                'numero_corte'      => '10',
                'nombre'            => 'Lurex',
                'colores'           => 'Azul 10 , Rojo 20 , Verde 15',
                'cantidad'          => '125',
                'articulos'         => '#124, #125, #126',
                'descripcion'       => 'Corte de Lurex para la temporada de invierno',
                'costureros'        => 'Maria, Juan, Pedro',
                'fecha'             => '2021-10-10',
                'estado'            => '0',
                'created_at'        => '2023-10-10',
                'imagen'        	=> 'default-corte.jpg',
                'imagen_alt'    	=> 'Imagen por defecto del corte',
                'updated_at'        => now()

            ],
            [
                'numero_corte'      => '11',
                'nombre'            => 'Modal',
                'colores'           => 'Azul 12 , Rojo 30 , Verde 24',
                'cantidad'          => '534',
                'articulos'         => '#434, #025, #086',
                'descripcion'       => 'Corte de Modal para la temporada de verano',
                'costureros'        => 'Maria, Juan, Pedro',
                'fecha'             => '2021-10-10',
                'estado'            => '1',
                'created_at'        => '2023-10-10',
                'imagen'        	=> 'default-corte.jpg',
                'imagen_alt'    	=> 'Imagen por defecto del corte',
                'updated_at'        => now()
            ],
            [
                'numero_corte'      => '12',
                'nombre'            => 'Modal',
                'colores'           => 'Negro 32 , Crema 11 , Marino 27',
                'cantidad'          => '390',
                'articulos'         => '#234, #105, #350',
                'descripcion'       => 'Corte de Modal para la temporada de verano',
                'costureros'        => 'Julia, Maria, Luis',
                'fecha'             => '2021-10-10',
                'estado'            => '2',
                'created_at'        => '2023-10-10',
                'imagen'            => 'default-corte.jpg',
                'imagen_alt'    	=> 'Imagen por defecto del corte',
                'updated_at' => now()
            ]
        ]);
    }
}
