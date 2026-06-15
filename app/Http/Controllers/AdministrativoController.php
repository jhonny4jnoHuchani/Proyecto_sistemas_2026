<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministrativoController extends Controller
{
    public function index()
    {
        $administrativos = Administrativo::where('estado', true)->get();
        return view('administrativos.index', compact('administrativos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci'       => 'required|string|max:20|unique:administrativos,ci',
            'cargo'    => 'required|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear el acceso al sistema
            $user = User::create([
                'username' => $request->ci,
                'email'    => $request->ci . '@colegio.com',
                'password' => Hash::make($request->ci),
                'rol'      => 'administrativo',
                'estado'   => true
            ]);

            // 2. Crear el perfil administrativo
            Administrativo::create([
                'user_id'  => $user->id,
                'nombre'   => $request->nombre,
                'apellido' => $request->apellido,
                'ci'       => $request->ci,
                'cargo'    => $request->cargo,
                'estado'   => true
            ]);

            DB::commit();
            return redirect()->route('administrativos.index')->with('success', 'Personal administrativo registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, Administrativo $administrativo)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            // Ignorar el CI actual en la validación unique
            'ci'       => 'required|string|max:20|unique:administrativos,ci,' . $administrativo->id,
            'cargo'    => 'required|string|max:100',
        ]);

        $administrativo->update([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'ci'       => $request->ci,
            'cargo'    => $request->cargo,
        ]);

        // Si el CI cambia, actualizamos también el username del login
        $administrativo->user->update([
            'username' => $request->ci
        ]);

        return redirect()->route('administrativos.index')->with('success', 'Datos actualizados correctamente.');
    }

    public function destroy(Administrativo $administrativo)
    {
        // Eliminación lógica del perfil y bloqueo de la cuenta de usuario
        $administrativo->update(['estado' => false]);
        $administrativo->user->update(['estado' => false]);

        return redirect()->route('administrativos.index')->with('success', 'Administrativo dado de baja.');
    }

    // ==========================================
    // MÉTODOS DE LA PAPELERA (ELIMINACIÓN LÓGICA)
    // ==========================================

    public function inactivos()
    {
        $administrativos = Administrativo::where('estado', false)->get();
        return view('administrativos.inactivos', compact('administrativos'));
    }

    public function restaurar($id)
    {
        $administrativo = Administrativo::findOrFail($id);
        $administrativo->update(['estado' => true]);
        $administrativo->user->update(['estado' => true]);

        return redirect()->route('administrativos.inactivos')->with('success', 'Personal restaurado al sistema.');
    }

    public function forceDelete($id)
    {
        $administrativo = Administrativo::findOrFail($id);
        $user = $administrativo->user; // Rescatamos el usuario antes de borrar
        
        $administrativo->delete(); // Borrar perfil
        if($user) $user->delete(); // Borrar credenciales

        return redirect()->route('administrativos.inactivos')->with('success', 'Registro eliminado de la base de datos.');
    }
}