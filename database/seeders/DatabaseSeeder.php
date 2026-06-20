<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GestionSeeder::class,
            TrimestreSeeder::class,
            UserSeeder::class,     // primero: crea los 17 users (id 1-17)
            MateriaSeeder::class,
            DocenteSeeder::class,  // depende de los user_id del UserSeeder
            CursoSeeder::class,
            //añadir el seeder para ejecutar un solo comando
            EstudiantePruebaSeeder::class,
            AdministradorSeeder::class,
        ]);
    }
}