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
        User::create([
            'ci' => '12345678',
            'genero' => 'Masculino',
            'name' => 'Admin',
            'apellido' => 'Administrador',
            'celular' => '12345678',
            'direccion' => 'Dirección del admin',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
    }
}