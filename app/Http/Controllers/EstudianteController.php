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
    // Validar campos - incluye TODOS los campos que necesitas
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'ci' => 'required|integer|unique:users,ci', 
        'genero' => 'required|string|max:10',
        'celular' => 'nullable|string|max:15', 
        'direccion' => 'nullable|string|max:255', 
        'fecha_nacimiento' => 'nullable|date', 
        'rude'=>'nullable|string|max:50',
    ]);
    
    // Crear usuario con TODOS los campos
    $user = User::create([
        'name' => $validatedData['nombre'],
        'apellido' => $validatedData['apellido'],
        'ci' => $validatedData['ci'],
        'genero' => $validatedData['genero'],
        'celular' => $validatedData['celular'] ?? null,
        'direccion' => $validatedData['direccion'] ?? null,
        'fecha_nacimiento' => $validatedData['fecha_nacimiento'] ?? null,
        'email' => $validatedData['ci'] . '@example.com',
        'password' => Hash::make($validatedData['ci']), 
    ]);
    
            $estudiante = Estudiante::create([
                'user_id' => $user->id,
                'rude' => $validatedData['rude'] ?? null,
            ]);

            return redirect()->route('estudiantes.listar');
    
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
    public function update(Request $request, Estudiante $estudiante)
    {
        dd($request->all(), $estudiante);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        //
    }
}
