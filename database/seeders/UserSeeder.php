<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'username' => 'admin',                    // ← username, no name
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'estado' => true,
        ]);

        // Usuario Normal
        User::create([
            'username' => 'usuario',
            'email' => 'usuario@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'estudiante',
            'estado' => true,
        ]);
    }
}