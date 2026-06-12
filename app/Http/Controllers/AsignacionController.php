<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Cargamos los catálogos activos para alimentar los select de los modales
        $gestiones = \App\Models\Gestion::where('estado', true)->get();
        $docentes  = \App\Models\Docente::where('estado', true)->get();
        $materias  = \App\Models\Materia::where('estado', true)->get();
        $cursos    = \App\Models\Curso::where('estado', true)->get();
        
        // Dejamos la colección vacía por ahora para que tu compañero la programe
        $asignaciones = []; 

        return view('asignaciones.index', compact('gestiones', 'docentes', 'materias', 'cursos', 'asignaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asignacion $asignacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignacion $asignacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignacion $asignacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignacion $asignacion)
    {
        //
    }

    // 1. Listar asignaciones inactivas
    public function inactivos()
    {
        // Dejamos la consulta lista buscando el estado false
        $asignaciones = \App\Models\Asignacion::where('estado', false)->get();
        return view('asignaciones.inactivos', compact('asignaciones'));
    }

    // 2. Restaurar una asignación académica
    public function restaurar($id)
    {
        $asignacion = \App\Models\Asignacion::findOrFail($id);
        $asignacion->estado = true;
        $asignacion->save();

        return redirect()->route('asignaciones.inactivos')->with('success', 'La asignación fue restaurada correctamente.');
    }

    // 3. Eliminación física definitiva de MySQL
    public function forceDelete($id)
    {
        $asignacion = \App\Models\Asignacion::findOrFail($id);
        $asignacion->delete();

        return redirect()->route('asignaciones.inactivos')->with('success', 'La asignación fue eliminada permanentemente.');
    }
}
