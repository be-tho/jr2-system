<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categoria')->insert([
            [
                'id' => 1,
                'nombre' => 'Remeras',
            ],
            [
                'id' => 2,
                'nombre' => 'Pantalones',
            ],
            [
                'id' => 3,
                'nombre' => 'Calzas',
            ],
            [
                'id' => 4,
                'nombre' => 'Camperas',
            ],
            [
                'id' => 5,
                'nombre' => 'Polleras',
            ],
            [
                'id' => 6,
                'nombre' => 'Vestidos',
            ],
            [
                'id' => 7,
                'nombre' => 'Buzos',
            ],
            [
                'id' => 8,
                'nombre' => 'Shorts',
            ],
            [
                'id' => 9,
                'nombre' => 'Sweaters',
            ],
            [
                'id' => 10,
                'nombre' => 'Camisas',
            ],
        ]);
    }
}
