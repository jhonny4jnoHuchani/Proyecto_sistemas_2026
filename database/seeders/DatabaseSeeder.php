<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Llamar al seeder de estudiantes (si existe)
        // $this->call([
        //     EstudianteSeeder::class,
        // ]);

        // Usuario de prueba normal
        User::create([
            'username' => 'testuser',           // ← username, no name
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'rol' => 'estudiante',
            'estado' => true,
        ]);

        // Usuario administrador
        User::create([
            'username' => 'admin',              // ← username
            'email' => 'hynoku2004r@gmail.com',
            'password' => Hash::make('hynoku2004r@gmail.com'),
            'rol' => 'admin',
            'estado' => true,
        ]);

        // Si necesitas más usuarios de ejemplo
        User::create([
            'username' => 'secretaria1',
            'email' => 'secretaria@example.com',
            'password' => Hash::make('secretaria123'),
            'rol' => 'secretaria',
            'estado' => true,
        ]);

        User::create([
            'username' => 'docente1',
            'email' => 'docente@example.com',
            'password' => Hash::make('docente123'),
            'rol' => 'docente',
            'estado' => true,
        ]);
    }
}