<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'username' => 'admin1',
                'email'    => 'admin1@colegio.com',
                'password' => 'password123', // se hashea solo gracias al cast 'hashed' del modelo User
                'rol'      => 'admin',
                'estado'   => 1,
            ],
            [
                'username' => 'admin2',
                'email'    => 'admin2@colegio.com',
                'password' => 'password123',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
            [
                'username' => 'admin3',
                'email'    => 'admin3@colegio.com',
                'password' => 'password123',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
            [
                'username' => 'admin4',
                'email'    => 'admin4@colegio.com',
                'password' => 'password123',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']], // evita duplicados si vuelves a correr el seeder
                $admin
            );
        }
    }
}