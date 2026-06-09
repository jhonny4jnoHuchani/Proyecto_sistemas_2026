<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        // Estudiante 1
        $user1 = User::create([
            'ci' => '98765432',
            'genero' => 'Masculino',
            'name' => 'Juan',
            'apellido' => 'Perez',
            'celular' => '71122334',
            'direccion' => 'Av. Siempre Viva 123',
            'fecha_nacimiento' => '2000-05-15',
            'email' => 'juan.perez@example.com',
            'password' => Hash::make('estudiante123'),
        ]);
        
        Estudiante::create([
            'rude' => 'RUD00123456',
            'user_id' => $user1->id,
        ]);
        
        // Estudiante 2
        $user2 = User::create([
            'ci' => '87654321',
            'genero' => 'Femenino',
            'name' => 'Maria',
            'apellido' => 'Lopez',
            'celular' => '72233445',
            'direccion' => 'Calle Los Pinos 456',
            'fecha_nacimiento' => '2001-08-22',
            'email' => 'maria.lopez@example.com',
            'password' => Hash::make('estudiante123'),
        ]);
        
        Estudiante::create([
            'rude' => 'RUD00234567',
            'user_id' => $user2->id,
        ]);
        
        // Estudiante 3
        $user3 = User::create([
            'ci' => '76543210',
            'genero' => 'Masculino',
            'name' => 'Carlos',
            'apellido' => 'Rodriguez',
            'celular' => '73344556',
            'direccion' => 'Barrio Centro 789',
            'fecha_nacimiento' => '1999-11-30',
            'email' => 'carlos.rodriguez@example.com',
            'password' => Hash::make('estudiante123'),
        ]);
        
        Estudiante::create([
            'rude' => 'RUD00345678',
            'user_id' => $user3->id,
        ]);
    }
}