<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::where('estado', true)->orderBy('grado')->orderBy('paralelo')->get();
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // VALIDACIÓN CORREGIDA
        $request->validate([
            'grado'    => 'required|integer|min:1|max:6',  // Cambiado a integer
            'paralelo' => 'required|string|max:10',
            'turno'    => 'required|string|in:Mañana,Tarde,Noche',  // Mejor validación
        ]);

        // Verificar si ya existe un curso con el mismo grado, paralelo y turno activo
        $existe = Curso::where('grado', $request->grado)
                        ->where('paralelo', $request->paralelo)
                        ->where('turno', $request->turno)
                        ->where('estado', true)
                        ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('error', 'Ya existe un curso activo con ese grado, paralelo y turno.')
                ->withInput();
        }

        // GUARDAR EN LA BASE DE DATOS
        Curso::create([
            'grado' => $request->grado,
            'paralelo' => $request->paralelo,
            'turno' => $request->turno,
            'estado' => true,
        ]);

        return redirect()->route('cursos.index')
            ->with('success', 'El curso se guardó correctamente.');
    }

    /**
     * Display soft deleted cursos.
     */
    public function inactivos()
    {
        $cursos = Curso::where('estado', false)->orderBy('grado')->orderBy('paralelo')->get();
        return view('cursos.inactivos', compact('cursos'));
    }

    /**
     * Restore a soft deleted curso.
     */
    public function restaurar($id)
    {
        $curso = Curso::findOrFail($id);
        
        // Verificar si ya existe un curso activo con los mismos datos
        $existe = Curso::where('grado', $curso->grado)
                        ->where('paralelo', $curso->paralelo)
                        ->where('turno', $curso->turno)
                        ->where('estado', true)
                        ->exists();

        if ($existe) {
            return redirect()->route('cursos.inactivos')
                ->with('error', 'No se puede restaurar porque ya existe un curso activo con ese grado, paralelo y turno.');
        }

        $curso->estado = true;
        $curso->save();

        return redirect()->route('cursos.inactivos')
            ->with('success', 'El curso fue restaurado correctamente.');
    }

    /**
     * Force delete from database.
     */
    public function forceDelete($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete(); // DELETE real en MySQL

        return redirect()->route('cursos.inactivos')
            ->with('success', 'El curso fue eliminado permanentemente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        // VALIDACIÓN CORREGIDA
        $request->validate([
            'grado'    => 'required|integer|min:1|max:6',  // Cambiado a integer
            'paralelo' => 'required|string|max:10',
            'turno'    => 'required|string|in:Mañana,Tarde,Noche',
        ]);

        // Verificar si ya existe otro curso con los mismos datos (excepto el actual)
        $existe = Curso::where('grado', $request->grado)
                        ->where('paralelo', $request->paralelo)
                        ->where('turno', $request->turno)
                        ->where('estado', true)
                        ->where('id', '!=', $curso->id)
                        ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('error', 'Ya existe otro curso activo con ese grado, paralelo y turno.')
                ->withInput();
        }

        // ACTUALIZAR EL CURSO
        $curso->update([
            'grado' => $request->grado,
            'paralelo' => $request->paralelo,
            'turno' => $request->turno,
        ]);

        return redirect()->route('cursos.index')
            ->with('success', 'El curso se actualizó correctamente.');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(Curso $curso)
    {
        // Soft delete: solo cambiamos estado a false
        $curso->estado = false;
        $curso->save();

        return redirect()->route('cursos.index')
            ->with('success', 'El curso fue eliminado correctamente.');
    }
}