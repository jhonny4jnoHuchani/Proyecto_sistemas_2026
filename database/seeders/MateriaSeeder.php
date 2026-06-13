<?php

namespace Database\Seeders;

use App\Models\Materia;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        Materia::create([
            'nombre' => 'Álgebra Lineal',
            'area' => 'Matemáticas',
            'carga_horaria' => 80,
            'estado' => true
        ]);

        Materia::create([
            'nombre' => 'Física I',
            'area' => 'Ciencias',
            'carga_horaria' => 100,
            'estado' => true
        ]);

        Materia::create([
            'nombre' => 'Programación Web',
            'area' => 'Tecnología',
            'carga_horaria' => 120,
            'estado' => true
        ]);

        Materia::create([
            'nombre' => 'Química Orgánica',
            'area' => 'Química',
            'carga_horaria' => 90,
            'estado' => false
        ]);
    }
}