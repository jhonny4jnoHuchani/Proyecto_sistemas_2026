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
        $cursos = Curso::where('estado', true)->get();
        //
        return view('cursos.index',compact('cursos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Aca le direcmos a laravel que busque la carpeta 'cursos' y nos muestre el archivo 'create.blade.php'
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // 1. REGLAS DE SEGURIDAD (Validación)
        // Revisamos que nadie nos mande textos más largos de lo que aguanta la base de datos
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'paralelo' => 'required|string|max:10',
            'turno'    => 'required|string|max:50',
        ]);

        // 2. GUARDAR EN LA BASE DE DATOS
        // Esto toma todos los datos del formulario y crea el registro automáticamente.
        \App\Models\Curso::create($request->all());

        // 3. REDIRECCIONAR AL USUARIO
        // Lo mandamos de vuelta a la tabla principal con un mensaje en la "mochila" (session)
        return redirect()->route('cursos.index')->with('success', 'El curso se guardó correctamente.');
    }


    // 1. Mostrar la tabla de eliminados lógicamente
    public function inactivos()
    {
        $cursos = Curso::where('estado', false)->get();
        return view('cursos.inactivos', compact('cursos'));
    }

    // 2. Restaurar un curso (volver su estado a true)
    public function restaurar($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->estado = true;
        $curso->save();

        return redirect()->route('cursos.inactivos')->with('success', 'El curso fue restaurado correctamente.');
    }

    // 3. Eliminar físicamente (borrar para siempre de la base de datos)
    public function forceDelete($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete(); // Esto hace el DELETE real en MySQL

        return redirect()->route('cursos.inactivos')->with('success', 'El curso fue eliminado permanentemente.');
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
        //1. Validar los datos
        $request->validate([
            'nombre'=>'required|string|max:100',
            'paralelo'=>'required|string|max:10',
            'turno'=>'required|string|max:50',
        ]);

        //2. Actuializar el curso directamente (Laravek ya lo buscó y lo tiene en la variable $curso)
        $curso->update($request->all());

        //3. Redireccionamos a la tabla nuevamanete
        return redirect()->route('cursos.index')->with('success','El curso se actualizó correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //En lugar de $curso->delete()
        //Simplemente camviamos su estado a inactivo

        $curso->estado = false;
        $curso->save();

        return redirect()->route('cursos.index')->with('success','El curso fue eliminado correctamente.');
    }
}
