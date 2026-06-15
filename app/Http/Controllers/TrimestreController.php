<?php

namespace App\Http\Controllers;

use App\Models\Trimestre;
use App\Models\Gestion;
use Illuminate\Http\Request;

class TrimestreController extends Controller
{
    public function index()
    {
        // Buscamos la gestión que esté activa actualmente
        $gestionActiva = Gestion::where('estado', true)->first();

        // Si hay una gestión activa, traemos sus trimestres. Si no, devolvemos un arreglo vacío.
        $trimestres = [];
        if ($gestionActiva) {
            $trimestres = Trimestre::where('gestion_id', $gestionActiva->id)->get();
        }

        return view('trimestres.index', compact('gestionActiva', 'trimestres'));
    }

    // Método AJAX para cambiar el estado (abrir/cerrar carga de notas)
    public function toggle(Request $request, $id)
    {
        $trimestre = Trimestre::findOrFail($id);
        
        // Invertimos el estado (si es true pasa a false, y viceversa)
        $trimestre->estado = !$trimestre->estado;
        $trimestre->save();

        return response()->json([
            'success' => true,
            'nuevo_estado' => $trimestre->estado,
            'mensaje' => $trimestre->estado ? 'Trimestre habilitado para notas.' : 'Trimestre cerrado.'
        ]);
    }
}