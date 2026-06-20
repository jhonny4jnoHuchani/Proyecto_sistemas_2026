<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asignacion;
use PDF;



class EstudiantePanelController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        if (!$estudiante) {
            return redirect('/')->with('error', 'No tienes un perfil de estudiante.');
        }

        // Traemos su inscripción actual
        $inscripcion = $estudiante->inscripcionActiva()->with(['curso', 'gestion'])->first();

        // Buscamos a sus docentes usando los nombres correctos de tu base de datos (id_curso e id_gestion)
        $misDocentes = [];
        if ($inscripcion) {
            $misDocentes = \App\Models\Asignacion::with(['materia', 'docente'])
                ->where('curso_id', $inscripcion->id_curso) // CORREGIDO AQUÍ
                ->where('estado', true)
                ->get();

            // Nota: Si tu tabla 'asignaciones' también tiene la columna 'gestion_id',
            // puedes agregar ->where('gestion_id', $inscripcion->id_gestion) justo debajo de curso_id.
            // Lo dejé comentado/quitado por seguridad basándome en el controlador de tu compañero.
        }

        return view('estudiante.dashboard', compact('estudiante', 'inscripcion', 'misDocentes'));
    }
    public function misNotas()
    {
        // 1. Obtenemos al usuario logueado en ese instante
        $user = Auth::user();

        // 2. Usamos la relación para sacar su perfil de estudiante
        $estudiante = $user->estudiante;

        // Si por alguna razón un admin o docente entra a esta ruta, lo bloqueamos amablemente
        if (!$estudiante) {
            return redirect()->route('dashboard')->with('error', 'No tienes un perfil de estudiante asignado para ver notas.');
        }

        // 3. El salto mágico: Traemos la inscripción activa, su curso, y TODAS sus notas con materias y trimestres
        $inscripcion = $estudiante->inscripcionActiva()
            ->with([
                'curso',
                'gestion',
                'notas.asignacion.materia',
                'notas.trimestre'
            ])->first();

        // Si no está inscrito este año, mandamos la variable vacía
        if (!$inscripcion) {
            return view('estudiante.mis_notas', ['inscripcion' => null]);
        }

        // 4. Armamos la "Libreta" (Agrupamos las notas por materia)
        $boletin = [];
        foreach ($inscripcion->notas as $nota) {
            $nombreMateria = $nota->asignacion->materia->nombre;
            $nombreTrimestre = $nota->trimestre->nombre;

            // Estructura: $boletin['Matematicas']['1er Trimestre'] = 85
            $boletin[$nombreMateria][$nombreTrimestre] = $nota->nota_final;
        }

        return view('estudiante.mis_notas', compact('estudiante', 'inscripcion', 'boletin'));
    }

    public function generarPDF()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        if (!$estudiante) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'No tienes un perfil de estudiante asignado.');
        }

        $inscripcion = $estudiante->inscripcionActiva()
            ->with([
                'curso',
                'gestion',
                'notas.asignacion.materia',
                'notas.trimestre'
            ])->first();

        if (!$inscripcion) {
            return redirect()->route('estudiante.notas')
                ->with('error', 'No tienes inscripción activa.');
        }

        $boletin = [];
        foreach ($inscripcion->notas as $nota) {
            $nombreMateria = $nota->asignacion->materia->nombre;
            $nombreTrimestre = $nota->trimestre->nombre;
            $boletin[$nombreMateria][$nombreTrimestre] = $nota->nota_final;
        }

        $pdf = PDF::loadView('estudiante.pdf_notas', compact('estudiante', 'inscripcion', 'boletin'));

        $nombreArchivo = 'boletin_' . $estudiante->apellido . '_' . $inscripcion->gestion->anio . '.pdf';

        return $pdf->stream($nombreArchivo);
    }
}