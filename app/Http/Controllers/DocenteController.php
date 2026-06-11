<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener solo docentes activos con su relación de usuario
        $docentes = Docente::where('estado', true)
                            ->with('user')
                            ->latest()
                            ->get();
        
        return view('docentes.index', compact('docentes'));
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
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|unique:docentes,ci|max:20',
            'email' => 'required|email|unique:users,email',
            'especialidad' => 'required|string|max:255',
        ]);

        // 1. Crear el Usuario
        $user = User::create([
            'username' => $request->nombre . '_' . $request->ci, // Ej: Juan_12345678
            'email' => $request->email,
            'password' => Hash::make($request->ci), // Contraseña = CI
            'rol' => 'docente',
            'estado' => true,
        ]);

        // 2. Crear el Docente vinculado al usuario
        Docente::create([
            'user_id' => $user->id,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci' => $request->ci,
            'especialidad' => $request->especialidad,
            'estado' => true,
        ]);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente creado exitosamente. Usuario: ' . $user->username);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|max:20|unique:docentes,ci,' . $docente->id,
            'email' => 'required|email|unique:users,email,' . $docente->user_id,
            'especialidad' => 'required|string|max:255',
        ]);

        // 1. Actualizar el Usuario relacionado
        $user = $docente->user;
        $user->update([
            'username' => $request->nombre . '_' . $request->ci,
            'email' => $request->email,
            // Solo actualizar password si se envía uno nuevo
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        // 2. Actualizar el Docente
        $docente->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci' => $request->ci,
            'especialidad' => $request->especialidad,
        ]);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(Docente $docente)
    {
        // Eliminación lógica del docente
        $docente->update(['estado' => false]);
        
        // También eliminar lógicamente el usuario asociado
        $docente->user->update(['estado' => false]);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado exitosamente.');
    }

    /**
     * Display soft deleted docentes.
     */
    public function inactivos()
    {
        $docentes = Docente::where('estado', false)
                            ->with('user')
                            ->latest()
                            ->get();
        
        return view('docentes.inactivos', compact('docentes'));
    }

    /**
     * Restore a soft deleted docente.
     */
    public function restore($id)
    {
        $docente = Docente::findOrFail($id);
        $docente->update(['estado' => true]);
        
        // También restaurar el usuario asociado
        $docente->user->update(['estado' => true]);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente restaurado exitosamente.');
    }
    
}