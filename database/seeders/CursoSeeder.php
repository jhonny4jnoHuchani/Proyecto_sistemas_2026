<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        Curso::create([
            'nombre' => 'Primero',
            'paralelo' => 'A',
            'turno' => 'Mañana',
            'estado' => true
        ]);

        Curso::create([
            'nombre' => 'Segundo',
            'paralelo' => 'B',
            'turno' => 'Tarde',
            'estado' => true
        ]);

        Curso::create([
            'nombre' => 'Tercero',
            'paralelo' => 'C',
            'turno' => 'Noche',
            'estado' => false
        ]);

        Curso::create([
            'nombre' => 'Cuarto',
            'paralelo' => 'A',
            'turno' => 'Mañana',
            'estado' => true
        ]);
    }
}