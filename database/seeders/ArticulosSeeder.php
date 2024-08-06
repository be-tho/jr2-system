<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articulos')->insert([
            [
                'nombre' => 'Remera de lurex',
                'temporada_id' => 1,
                'descripcion' => 'Remera de lurex con cuello redondo y manga corta',
                'codigo' => 'REM001',
                'stock' => 10,
                'precio' => 1500,
                'imagen' => 'default-articulo.png',
                'categoria' => 'Remeras',
            ],
            [
                'nombre' => 'Pantalon de jean',
                'temporada_id' => 1,
                'descripcion' => 'Pantalon de jean con cintura elastizada y bolsillos',
                'codigo' => 'PAN001',
                'stock' => 5,
                'precio' => 2500,
                'imagen' => 'default-articulo.png',
                'categoria' => 'Pantalones',
            ],
            [
                'nombre' => 'Calza de algodon',
                'temporada_id' => 1,
                'descripcion' => 'Calza de algodon con cintura elastizada y largo al tobillo',
                'codigo' => 'CAL001',
                'stock' => 15,
                'precio' => 1200,
                'imagen' => 'default-articulo.png',
                'categoria' => 'Calzas',
            ],
            [
                'nombre' => 'Campera de jean',
                'temporada_id' => 1,
                'descripcion' => 'Campera de jean con cierre y bolsillos',
                'codigo' => 'CAM001',
                'stock' => 3,
                'precio' => 3500,
                'imagen' => 'default-articulo.png',
                'categoria' => 'Camperas',
            ],
            [
                'nombre' => 'Pollera de gabardina',
                'temporada_id' => 1,
                'descripcion' => 'Pollera de gabardina con cintura elastizada y largo a la rodilla',
                'codigo' => 'POL001',
                'stock' => 7,
                'precio' => 2000,
                'imagen' => 'default-articulo.png',
                'categoria' => 'Polleras',
            ],
            [
                'nombre' => 'Vestido de lino',
                'temporada_id' => 1,
                'descripcion' => 'Vestido de lino con cuello redondo y manga corta',
                'codigo' => 'VES001',
                'stock' => 2,
                'precio' => 3000,
                'imagen' => 'default-articulo.png',
                'categoria' => 'Vestidos',
            ]
        ]);
    }
}
