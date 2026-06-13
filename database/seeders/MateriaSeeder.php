<?php

namespace Database\Seeders;

use App\Models\Materia;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            ['nombre' => 'Matemáticas',        'area' => 'Ciencias Exactas', 'carga_horaria' => 120, 'estado' => true],
            ['nombre' => 'Lenguaje',           'area' => 'Comunicación',     'carga_horaria' => 100, 'estado' => true],
            ['nombre' => 'Ciencias Naturales', 'area' => 'Ciencias',         'carga_horaria' => 100, 'estado' => true],
            ['nombre' => 'Ciencias Sociales',  'area' => 'Humanidades',      'carga_horaria' => 90,  'estado' => true],
            ['nombre' => 'Inglés',             'area' => 'Idiomas',          'carga_horaria' => 80,  'estado' => true],
            ['nombre' => 'Educación Física',   'area' => 'Deportes',         'carga_horaria' => 60,  'estado' => true],
            ['nombre' => 'Artes Plásticas',    'area' => 'Arte',             'carga_horaria' => 60,  'estado' => true],
            ['nombre' => 'Música',             'area' => 'Arte',             'carga_horaria' => 60,  'estado' => true],
            ['nombre' => 'Religión',           'area' => 'Valores',          'carga_horaria' => 40,  'estado' => true],
            ['nombre' => 'Computación',        'area' => 'Tecnología',       'carga_horaria' => 80,  'estado' => true],
            ['nombre' => 'Física',             'area' => 'Ciencias Exactas', 'carga_horaria' => 100, 'estado' => true],
            ['nombre' => 'Química',            'area' => 'Ciencias Exactas', 'carga_horaria' => 90,  'estado' => true],
            ['nombre' => 'Biología',           'area' => 'Ciencias',         'carga_horaria' => 90,  'estado' => true],
            ['nombre' => 'Filosofía',          'area' => 'Humanidades',      'carga_horaria' => 60,  'estado' => true],
            ['nombre' => 'Programación Web',   'area' => 'Tecnología',       'carga_horaria' => 120, 'estado' => false],
        ];

        foreach ($materias as $materia) {
            Materia::create($materia);
        }
    }
}