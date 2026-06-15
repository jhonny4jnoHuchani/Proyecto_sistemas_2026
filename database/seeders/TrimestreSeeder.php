<?php

namespace Database\Seeders;

use App\Models\Trimestre;
use App\Models\Gestion;
use Illuminate\Database\Seeder;

class TrimestreSeeder extends Seeder
{
    public function run(): void
    {
        $gestiones = Gestion::all();

        foreach ($gestiones as $gestion) {
            Trimestre::create([
                'gestion_id' => $gestion->id,
                'nombre' => '1er Trimestre',
                'estado' => true
            ]);

            Trimestre::create([
                'gestion_id' => $gestion->id,
                'nombre' => '2do Trimestre',
                'estado' => true
            ]);

            Trimestre::create([
                'gestion_id' => $gestion->id,
                'nombre' => '3er Trimestre',
                'estado' => true
            ]);
        }
    }
}