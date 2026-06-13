<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        Curso::create([
            'grado' => 1,           // Cambiado: 'nombre' → 'grado'
            'paralelo' => 'A',
            'turno' => 'Mañana',
            'estado' => true
        ]);

        Curso::create([
            'grado' => 2,           // Cambiado: 'nombre' → 'grado'
            'paralelo' => 'B',
            'turno' => 'Tarde',
            'estado' => true
        ]);

        Curso::create([
            'grado' => 3,           // Cambiado: 'nombre' → 'grado'
            'paralelo' => 'C',
            'turno' => 'Noche',
            'estado' => false
        ]);

        Curso::create([
            'grado' => 4,           // Cambiado: 'nombre' → 'grado'
            'paralelo' => 'A',
            'turno' => 'Mañana',
            'estado' => true
        ]);

        // Puedes agregar más cursos de ejemplo
        Curso::create([
            'grado' => 5,
            'paralelo' => 'B',
            'turno' => 'Tarde',
            'estado' => true
        ]);

        Curso::create([
            'grado' => 6,
            'paralelo' => 'C',
            'turno' => 'Noche',
            'estado' => true
        ]);
    }
}