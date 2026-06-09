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
        // Llamar al seeder de estudiantes
        $this->call([
            EstudianteSeeder::class,
        ]);

        // Usuario de prueba existente
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear usuario administrador
        User::create([
            'ci' => '12345678',
            'genero' => 'Masculino',
            'name' => 'Admin',
            'apellido' => 'Administrador',
            'celular' => '70000000',
            'direccion' => 'Oficina Central',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'hynoku2004r@gmail.com',
            'password' => Hash::make('hynoku2004r@gmail.com'),
        ]);
    }
}