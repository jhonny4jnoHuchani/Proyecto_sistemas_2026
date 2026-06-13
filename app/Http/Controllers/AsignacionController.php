<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\Docente;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    /**
     * Vista 1: Grid de 6 grados con número total de asignaciones por grado
     */
    public function index()
    {
        $grados = [];

        for ($i = 1; $i <= 6; $i++) {
            $totalAsignaciones = Asignacion::whereHas('curso', function ($q) use ($i) {
                $q->where('grado', $i)->where('estado', true);
            })->where('estado', true)->count();

            $grados[] = [
                'numero' => $i,
                'total_asignaciones' => $totalAsignaciones,
            ];
        }

        return view('asignaciones.index', compact('grados'));
    }

    /**
     * Vista 2: Paralelos (A, B, C...) de un grado + modal asignación masiva
     */
    public function paralelos($grado)
    {
        // Cursos (paralelos) de este grado
        $cursos = Curso::where('grado', $grado)
            ->where('estado', true)
            ->orderBy('paralelo')
            ->get();

        // Contamos asignaciones por cada curso/paralelo
        foreach ($cursos as $curso) {
            $curso->total_asignaciones = Asignacion::where('curso_id', $curso->id)
                ->where('estado', true)
                ->count();
        }

        // Todas las materias activas (para el modal de checkboxes)
        $materias = Materia::where('estado', true)->orderBy('nombre')->get();

        // IDs de los cursos de este grado, para saber qué materias ya están asignadas
        $cursoIds = $cursos->pluck('id');

        // Materias que YA tienen asignación en al menos uno de estos cursos
        $materiasAsignadasIds = Asignacion::whereIn('curso_id', $cursoIds)
            ->where('estado', true)
            ->pluck('materia_id')
            ->unique();

        return view('asignaciones.paralelos', compact('grado', 'cursos', 'materias', 'materiasAsignadasIds'));
    }

    /**
     * Acción del modal de asignación masiva: aplica las materias marcadas
     * a TODOS los paralelos del grado
     */
    public function asignarMasivo(Request $request, $grado)
    {
        $request->validate([
            'materias' => 'array',
            'materias.*' => 'exists:materias,id',
        ]);

        $materiaIds = $request->input('materias', []);

        $cursos = Curso::where('grado', $grado)
            ->where('estado', true)
            ->get();

        $creadas = 0;

        foreach ($materiaIds as $materiaId) {
            foreach ($cursos as $curso) {
                $asignacion = Asignacion::firstOrCreate(
                    [
                        'curso_id' => $curso->id,
                        'materia_id' => $materiaId,
                    ],
                    [
                        'docente_id' => null,
                        'gestion_id' => null,
                        'estado' => true,
                    ]
                );

                if ($asignacion->wasRecentlyCreated) {
                    $creadas++;
                }
            }
        }

        return redirect()
            ->route('asignaciones.paralelos', $grado)
            ->with('success', "Materias asignadas al grado {$grado} correctamente.");
    }

    /**
     * Vista 3: Detalle de un curso (tabla materias asignadas + selects docentes)
     */
    public function detalle(Curso $curso)
    {
        // Asignaciones de este curso, con la materia y el docente (si tiene) cargados
        $asignaciones = Asignacion::where('curso_id', $curso->id)
            ->where('estado', true)
            ->with(['materia', 'docente'])
            ->get();

        // Para cada asignación, buscamos docentes cuya especialidad coincida
        // con el nombre de la materia
        foreach ($asignaciones as $asignacion) {
            $asignacion->docentes_disponibles = Docente::where('estado', true)
                ->where('especialidad', $asignacion->materia->nombre)
                ->get();
        }

        // Materias que AÚN NO están asignadas a este curso (para el modal "agregar más")
        $materiaIdsAsignadas = $asignaciones->pluck('materia_id');

        $materiasDisponibles = Materia::where('estado', true)
            ->whereNotIn('id', $materiaIdsAsignadas)
            ->orderBy('nombre')
            ->get();

        // Para cada materia disponible, sus posibles docentes
        foreach ($materiasDisponibles as $materia) {
            $materia->docentes_disponibles = Docente::where('estado', true)
                ->where('especialidad', $materia->nombre)
                ->get();
        }

        return view('asignaciones.detalle', compact('curso', 'asignaciones', 'materiasDisponibles'));
    }

    /**
     * Guardar/actualizar el docente asignado a cada materia del curso
     */
    public function guardarDocentes(Request $request, Curso $curso)
    {
        // Llega algo como: docentes[asignacion_id] = docente_id
        $docentes = $request->input('docentes', []);

        foreach ($docentes as $asignacionId => $docenteId) {
            $asignacion = Asignacion::where('id', $asignacionId)
                ->where('curso_id', $curso->id)
                ->first();

            if ($asignacion) {
                $asignacion->docente_id = $docenteId ?: null;
                $asignacion->save();
            }
        }

        return redirect()
            ->route('asignaciones.detalle', $curso->id)
            ->with('success', 'Docentes actualizados correctamente.');
    }

    /**
     * Modal "agregar más materias" desde el detalle:
     * crea asignaciones nuevas (materia + docente) que no existían para este curso
     */
    public function agregarMateria(Request $request, Curso $curso)
    {
        $request->validate([
            'nuevas' => 'array',
            'nuevas.*.materia_id' => 'required|exists:materias,id',
            'nuevas.*.docente_id' => 'nullable|exists:docentes,id',
        ]);

        $nuevas = $request->input('nuevas', []);

        foreach ($nuevas as $item) {
            // Doble seguro: no duplicar si ya existe
            Asignacion::firstOrCreate(
                [
                    'curso_id' => $curso->id,
                    'materia_id' => $item['materia_id'],
                ],
                [
                    'docente_id' => $item['docente_id'] ?? null,
                    'gestion_id' => null,
                    'estado' => true,
                ]
            );
        }

        return redirect()
            ->route('asignaciones.detalle', $curso->id)
            ->with('success', 'Materias agregadas correctamente.');
    }

    // ===== Métodos restantes (los dejo igual que ya los tenías) =====

    public function create() {}
    public function store(Request $request) {}
    public function show(Asignacion $asignacion) {}
    public function edit(Asignacion $asignacion) {}
    public function update(Request $request, Asignacion $asignacion) {}
    public function destroy(Asignacion $asignacion) {}
}