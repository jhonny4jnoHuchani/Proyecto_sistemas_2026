<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Asignacion;
use App\Models\Nota;
use App\Models\Curso;
use App\Models\Gestion;
use App\Models\Trimestre;
use Illuminate\Support\Facades\Hash;

class EstudiantePruebaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtenemos la gestión actual (2026) y el primer curso disponible
        $gestion = Gestion::where('anio', 2026)->first();
        $curso = Curso::first(); // Generalmente será 1ro A
        $trimestres = Trimestre::where('gestion_id', $gestion->id)->get();

        // 2. Crear tus credenciales de acceso (Reglas de tu compañero)
        $ciEstudiante = '9899411';

        $user = User::create([
            'username' => $ciEstudiante . '@example.com',
            'email'    => $ciEstudiante . '@example.com',
            'password' => Hash::make($ciEstudiante),
            'rol'      => 'estudiante',
            'estado'   => true,
        ]);

        // 3. Crear tu perfil de Estudiante
        $estudiante = Estudiante::create([
            'user_id'          => $user->id,
            'nombre'           => 'David',
            'apellido'         => 'Lecoña',
            'ci'               => $ciEstudiante,
            'rude'             => 'RUDE' . $ciEstudiante,
            'fecha_nacimiento' => '2005-05-15',
            'direccion'        => 'Av. Principal, El Alto',
            'telefono'         => '74535690',
            'estado'           => true
        ]);

        // 4. Inscribirte en el Curso
        $inscripcion = Inscripcion::create([
            'id_estudiante'     => $estudiante->id,
            'id_curso'          => $curso->id,
            'id_gestion'        => $gestion->id,
            'fecha_inscripcion' => now(),
            'estado'            => true,
        ]);

        // 5. Verificar si el curso tiene materias asignadas, si no, le creamos 3 materias básicas
        $asignaciones = Asignacion::where('curso_id', $curso->id)->get();
        if ($asignaciones->isEmpty()) {
            $asignaciones = collect([
                Asignacion::create(['curso_id' => $curso->id, 'materia_id' => 1, 'docente_id' => 1, 'gestion_id' => $gestion->id, 'estado' => true]),
                Asignacion::create(['curso_id' => $curso->id, 'materia_id' => 2, 'docente_id' => 2, 'gestion_id' => $gestion->id, 'estado' => true]),
                Asignacion::create(['curso_id' => $curso->id, 'materia_id' => 3, 'docente_id' => 3, 'gestion_id' => $gestion->id, 'estado' => true]),
            ]);
        }

        // 6. Llenar el boletín con notas aleatorias para los 3 trimestres
        foreach ($asignaciones as $asignacion) {
            foreach ($trimestres as $trimestre) {
                Nota::create([
                    'id_inscripcion' => $inscripcion->id_inscripcion,
                    'id_asignacion'  => $asignacion->id,
                    'id_trimestre'   => $trimestre->id,
                    // Genera notas entre 60 y 95 para que aparezcas aprobado
                    'nota_final'     => rand(60, 95) 
                ]);
            }
        }
    }
}