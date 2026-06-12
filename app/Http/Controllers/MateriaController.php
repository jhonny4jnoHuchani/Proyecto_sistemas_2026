<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Traemos todas las materias que tengan el estado en true (activas)
        $materias = Materia::where('estado',true)->get();
        return view('materias.index',compact('materias'));
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
        $request->validate([
            'nombre'        => 'required|string|max:150',
            'area'          => 'required|string|max:100',
            'carga_horaria' => 'required|integer|min:1',
        ]);

        Materia::create($request->all());
        return redirect()->route('materias.index')->with('success','La materia fue registrada exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Materia $materia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materia $materia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materia $materia)
    {
        //
        $request->validate([
            'nombre'        => 'required|string|max:150',
            'area'          => 'required|string|max:100',
            'carga_horaria' => 'required|integer|min:1',
        ]);
        $materia->update($request->all());

        return redirect()->route('materias.index')->with('success', 'La materia fue actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia)
    {
        //
        $materia->estado = false;
        $materia->save();

        return redirect()->route('materias.index')->with('success', 'La materia fue enviada a la papelera.');
    }

    // 1. Mostrar la tabla de materias eliminadas lógicamente
    public function inactivos()
    {
        $materias = Materia::where('estado', false)->get();
        return view('materias.inactivos', compact('materias'));
    }

    // 2. Restaurar una materia (volver su estado a true)
    public function restaurar($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->estado = true;
        $materia->save();

        return redirect()->route('materias.inactivos')->with('success', 'La materia fue restaurada correctamente.');
    }

    // 3. Eliminar físicamente (borrar para siempre de MySQL)
    public function forceDelete($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('materias.inactivos')->with('success', 'La materia fue eliminada permanentemente de la base de datos.');
    }
}
