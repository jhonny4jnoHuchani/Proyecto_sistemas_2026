<?php

namespace Database\Seeders;

use App\Models\Docente;
use Illuminate\Database\Seeder;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        Docente::create([
            'user_id' => 1,  // Ahora existe el usuario con id=1
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '12345678',
            'especialidad' => 'Matemáticas',
            'estado' => true
        ]);

        Docente::create([
            'user_id' => 2,  // Usuario con id=2
            'nombre' => 'María',
            'apellido' => 'González',
            'ci' => '87654321',
            'especialidad' => 'Física',
            'estado' => true
        ]);

        Docente::create([
            'user_id' => 3,  // Usuario con id=3
            'nombre' => 'Carlos',
            'apellido' => 'Rodríguez',
            'ci' => '45678912',
            'especialidad' => 'Química',
            'estado' => false
        ]);
    }
}