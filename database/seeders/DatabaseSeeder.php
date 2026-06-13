<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,     // 1° Crear usuarios
            DocenteSeeder::class,  // 2° Crear docentes (dependen de users)
            MateriaSeeder::class,  // 3° Crear materias
            CursoSeeder::class,    // 4° Crear cursos
        ]);
    }
}