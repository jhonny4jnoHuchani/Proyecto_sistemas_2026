<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'juan.perez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'rol' => 'docente',
            'estado' => true
        ]);

        User::create([
            'username' => 'maria.gonzalez',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'rol' => 'docente',
            'estado' => true
        ]);

        User::create([
            'username' => 'carlos.rodriguez',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
            'rol' => 'docente',
            'estado' => true
        ]);
    }
}