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
                'username' => 'Anahi_Alave',
                'email'    => 'anahi_alave@sistema.com',
                'password' => 'anahi_alave@sistema.com',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
            [
                'username' => 'David_Lecoña',
                'email'    => 'david_lecoña@sistema.com',
                'password' => 'david_lecoña@sistema.com',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
            [
                'username' => 'Cristian_Mayta',
                'email'    => 'cristian_mayta@sistema.com',
                'password' => 'cristian_mayta@sistema.com',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
            [
                'username' => 'Jhonny_',
                'email'    => 'hynoku2004r@gmail.com',
                'password' => 'hynoku2004r@gmail.com',
                'rol'      => 'admin',
                'estado'   => 1,
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }
    }
}