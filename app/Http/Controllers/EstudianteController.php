<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $estudiantes = Estudiante::with('user')->get(); // Carga la relación con User
        
        return view('estudiantes.index', compact('estudiantes'));
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
        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'ci'               => 'required|string|max:20|unique:users,ci',
            'genero'           => 'required|in:Masculino,Femenino,Otro',
            'celular'          => 'nullable|string|max:15',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'rude'             => 'nullable|string|max:50|unique:estudiantes,rude',
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'nombre.max'           => 'El nombre no puede tener más de 100 caracteres.',
            'apellido.required'    => 'El apellido es obligatorio.',
            'apellido.max'         => 'El apellido no puede tener más de 100 caracteres.',
            'ci.required'          => 'El CI es obligatorio.',
            'ci.unique'            => 'Este CI ya está registrado.',
            'ci.max'               => 'El CI no puede tener más de 20 caracteres.',
            'genero.required'      => 'El género es obligatorio.',
            'genero.in'            => 'El género seleccionado no es válido.',
            'celular.max'          => 'El celular no puede tener más de 15 dígitos.',
            'fecha_nacimiento.date'=> 'La fecha de nacimiento no es válida.',
            'rude.unique'          => 'Este RUDE ya está registrado.',
            'rude.max'             => 'El RUDE no puede tener más de 50 caracteres.',
        ]);

        $user = User::create([
            'name'             => $request->nombre,
            'apellido'         => $request->apellido,
            'ci'               => $request->ci,
            'genero'           => $request->genero,
            'celular'          => $request->celular,
            'direccion'        => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email'            => $request->ci . '@example.com',
            'password'         => Hash::make($request->ci),
        ]);

        Estudiante::create([
            'user_id' => $user->id,
            'rude'    => $request->rude,
        ]);

        return redirect()->route('estudiantes.listar')
            ->with('success', 'Estudiante creado exitosamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::with('user')->findOrFail($id);

        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'ci'               => 'required|string|max:20|unique:users,ci,' . $estudiante->user->id,
            'genero'           => 'required|in:Masculino,Femenino,Otro',
            'celular'          => 'nullable|string|max:15',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'rude'             => 'nullable|string|max:50|unique:estudiantes,rude,' . $estudiante->id,
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'nombre.max'           => 'El nombre no puede tener más de 100 caracteres.',
            'apellido.required'    => 'El apellido es obligatorio.',
            'apellido.max'         => 'El apellido no puede tener más de 100 caracteres.',
            'ci.required'          => 'El CI es obligatorio.',
            'ci.unique'            => 'Este CI ya está registrado.',
            'ci.max'               => 'El CI no puede tener más de 20 caracteres.',
            'genero.required'      => 'El género es obligatorio.',
            'genero.in'            => 'El género seleccionado no es válido.',
            'celular.max'          => 'El celular no puede tener más de 15 dígitos.',
            'fecha_nacimiento.date'=> 'La fecha de nacimiento no es válida.',
            'rude.unique'          => 'Este RUDE ya está registrado.',
            'rude.max'             => 'El RUDE no puede tener más de 50 caracteres.',
        ]);

        $estudiante->user->update([
            'name'             => $request->nombre,
            'apellido'         => $request->apellido,
            'ci'               => $request->ci,
            'genero'           => $request->genero,
            'celular'          => $request->celular,
            'direccion'        => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        $estudiante->update([
            'rude' => $request->rude,
        ]);

        return redirect()->route('estudiantes.listar')
            ->with('success', 'Estudiante actualizado exitosamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $nombre = $estudiante->user->name . ' ' . $estudiante->user->apellido;
        $estudiante->delete();
        return redirect()->route('estudiantes.listar')->with('success', "✅ Estudiante {$nombre} eliminado correctamente");
    }
}
