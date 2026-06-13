<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['username' => 'juan.perez',       'email' => 'juan.perez@example.com'],
            ['username' => 'maria.gonzalez',   'email' => 'maria.gonzalez@example.com'],
            ['username' => 'carlos.rodriguez', 'email' => 'carlos.rodriguez@example.com'],
            ['username' => 'ana.flores',       'email' => 'ana.flores@example.com'],
            ['username' => 'luis.mamani',      'email' => 'luis.mamani@example.com'],
            ['username' => 'patricia.choque',  'email' => 'patricia.choque@example.com'],
            ['username' => 'roberto.quispe',   'email' => 'roberto.quispe@example.com'],
            ['username' => 'daniela.vargas',   'email' => 'daniela.vargas@example.com'],
            ['username' => 'jorge.mendoza',    'email' => 'jorge.mendoza@example.com'],
            ['username' => 'carla.soto',       'email' => 'carla.soto@example.com'],
            ['username' => 'fernando.aramayo', 'email' => 'fernando.aramayo@example.com'],
            ['username' => 'gabriela.cruz',    'email' => 'gabriela.cruz@example.com'],
            ['username' => 'ricardo.fernandez','email' => 'ricardo.fernandez@example.com'],
            ['username' => 'sandra.ortiz',     'email' => 'sandra.ortiz@example.com'],
            ['username' => 'mauricio.apaza',   'email' => 'mauricio.apaza@example.com'],
            ['username' => 'pedro.limachi',    'email' => 'pedro.limachi@example.com'],
            ['username' => 'lucia.torrez',     'email' => 'lucia.torrez@example.com'],
        ];

        foreach ($usuarios as $u) {
            User::create([
                'username' => $u['username'],
                'email'    => $u['email'],
                'password' => Hash::make('password123'),
                'rol'      => 'docente',
                'estado'   => true,
            ]);
        }
    }
}