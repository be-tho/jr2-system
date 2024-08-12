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
                'nombre' => 'Remeras',
            ],
            [
                'nombre' => 'Pantalones',
            ],
            [
                'nombre' => 'Calzas',
            ],
            [
                'nombre' => 'Camperas',
            ],
            [
                'nombre' => 'Polleras',
            ],
            [
                'nombre' => 'Vestidos',
            ],
            [
                'nombre' => 'Buzos',
            ],
            [
                'nombre' => 'Sweaters',
            ],
            [
                'nombre' => 'Camisas',
            ],
            [
                'nombre' => 'Shorts',
            ],
        ]);
    }
}
