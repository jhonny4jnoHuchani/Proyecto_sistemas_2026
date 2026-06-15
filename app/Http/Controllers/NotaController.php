<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Curso;
use App\Models\Gestion;
use App\Models\Inscripcion;
use App\Models\Nota;
use App\Models\Trimestre;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * VISTA 1 — Lista de cursos de la gestión activa.
     */
    public function index()
    {
        $gestion = Gestion::where('estado', true)->first();

        if (!$gestion) {
            return redirect()->route('dashboard')->with('error', 'No existe una gestión activa.');
        }

        $cursos = Curso::where('estado', true)
            ->orderBy('grado')
            ->orderBy('paralelo')
            ->get();

        return view('notas.index', compact('gestion', 'cursos'));
    }

    /**
     * VISTA 2 — Materias asignadas a un curso.
     */
    public function materias(Curso $curso)
    {
        $gestion = Gestion::where('estado', true)->firstOrFail();

        $asignaciones = Asignacion::where('curso_id', $curso->id)
            ->where('estado', true)
            ->with(['materia', 'docente'])
            ->get();

        return view('notas.materias', compact('gestion', 'curso', 'asignaciones'));
    }

    /**
     * VISTA 3 — Trimestres disponibles para esa asignación.
     */
    public function trimestres(Curso $curso, Asignacion $asignacion)
    {
        $gestion = Gestion::where('estado', true)->firstOrFail();

        // Solo verificamos que la asignación pertenezca al curso
        abort_if(
            $asignacion->curso_id != $curso->id,
            403,
            'Asignación no válida para este curso.'
        );

        $trimestres = Trimestre::where('gestion_id', $gestion->id)
            ->orderBy('id')
            ->get();

        return view('notas.trimestres', compact('gestion', 'curso', 'asignacion', 'trimestres'));
    }

    /**
     * VISTA 4 — Tabla de estudiantes con inputs de nota.
     */
    public function cargar(Curso $curso, Asignacion $asignacion, Trimestre $trimestre)
    {
        $gestion = Gestion::where('estado', true)->firstOrFail();

        // Solo verificamos que la asignación pertenezca al curso
        abort_if(
            $asignacion->curso_id != $curso->id,
            403,
            'Asignación no válida para este curso.'
        );

        $inscripciones = Inscripcion::where('id_curso', $curso->id)
            ->where('id_gestion', $gestion->id)
            ->where('estado', true)
            ->with('estudiante')
            ->get()
            ->sortBy(fn($i) => $i->estudiante->apellido);

        $notasExistentes = Nota::where('id_asignacion', $asignacion->id)
            ->where('id_trimestre', $trimestre->id)
            ->pluck('nota_final', 'id_inscripcion');

        return view('notas.cargar', compact(
            'gestion',
            'curso',
            'asignacion',
            'trimestre',
            'inscripciones',
            'notasExistentes'
        ));
    }

    /**
     * AUTOGUARDADO AJAX — Guarda o actualiza una nota individual.
     */
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'id_inscripcion' => 'required|exists:inscripciones,id_inscripcion',
            'id_asignacion'  => 'required|exists:asignaciones,id',
            'id_trimestre'   => 'required|exists:trimestres,id',
            'nota_final'     => 'required|numeric|min:0|max:100',
        ]);

        $nota = Nota::updateOrCreate(
            [
                'id_inscripcion' => $validated['id_inscripcion'],
                'id_asignacion'  => $validated['id_asignacion'],
                'id_trimestre'   => $validated['id_trimestre'],
            ],
            [
                'nota_final' => $validated['nota_final'],
            ]
        );

        return response()->json([
            'ok'         => true,
            'id_nota'    => $nota->id_nota,
            'nota_final' => $nota->nota_final,
        ]);
    }
}