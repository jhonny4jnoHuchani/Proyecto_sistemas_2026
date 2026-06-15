<?php

namespace Database\Seeders;

use App\Models\Gestion;
use Illuminate\Database\Seeder;

class GestionSeeder extends Seeder
{
    public function run(): void
    {
        Gestion::create([
            'anio' => 2024,
            'estado' => false,
            'fecha_apertura' => '2024-02-01',
            'fecha_clausura' => '2024-12-15',
            'documento' => 'gestion_2024.pdf'
        ]);

        Gestion::create([
            'anio' => 2025,
            'estado' => false,
            'fecha_apertura' => '2025-02-01',
            'fecha_clausura' => '2025-12-15',
            'documento' => 'gestion_2025.pdf'
        ]);

        Gestion::create([
            'anio' => 2026,
            'estado' => true,
            'fecha_apertura' => '2026-02-01',
            'fecha_clausura' => '2026-12-15',
            'documento' => 'gestion_2026.pdf'
        ]);
    }
}