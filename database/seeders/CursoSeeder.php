<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Configuración: grado => [paralelos], turno
        $cursos = [
            1 => ['paralelos' => ['A', 'B', 'C'], 'turno' => 'Mañana'],
            2 => ['paralelos' => ['A', 'B', 'C'], 'turno' => 'Mañana'],
            3 => ['paralelos' => ['A', 'B'],      'turno' => 'Tarde'],
            4 => ['paralelos' => ['A', 'B'],      'turno' => 'Tarde'],
            5 => ['paralelos' => ['A', 'B'],      'turno' => 'Tarde'],
            6 => ['paralelos' => ['A', 'B'],      'turno' => 'Tarde'],
        ];

        foreach ($cursos as $grado => $config) {
            foreach ($config['paralelos'] as $paralelo) {
                Curso::create([
                    'grado'    => $grado,
                    'paralelo' => $paralelo,
                    'turno'    => $config['turno'],
                    'estado'   => true,
                ]);
            }
        }
    }
}