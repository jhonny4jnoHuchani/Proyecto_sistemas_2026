<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::orderBy('anio', 'desc')->get();
        return view('gestion.index', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio'           => 'required|integer|unique:gestiones,anio',
            'fecha_apertura' => 'required|date',
            'fecha_clausura' => 'nullable|date|after:fecha_apertura',
            'documento'      => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'anio.unique'          => 'Ya existe una gestión para ese año.',
            'fecha_clausura.after' => 'La fecha de clausura debe ser posterior a la apertura.',
            'documento.mimes'      => 'Solo se permiten archivos PDF, DOC o DOCX.',
            'documento.max'        => 'El documento no debe superar 5MB.',
        ]);

        $rutaDocumento = null;

        if ($request->hasFile('documento')) {
            $archivo = $request->file('documento');
            $nombre = 'gestion_' . $request->anio . '_' . date('Y-m-d_H-i-s') . '.' . $archivo->getClientOriginalExtension();
            $rutaDocumento = $archivo->storeAs('gestiones', $nombre, 'public');
        }

        Gestion::create([
            'anio'           => $request->anio,
            'estado'         => true,
            'fecha_apertura' => $request->fecha_apertura,
            'fecha_clausura' => $request->fecha_clausura,
            'documento'      => $rutaDocumento,
        ]);

        return redirect()->route('gestiones.index')
                         ->with('success', 'Gestión ' . $request->anio . ' iniciada correctamente.');
    }

    public function update(Request $request, Gestion $gestion)
    {
        $request->validate([
            'fecha_apertura' => 'required|date',
            'fecha_clausura' => 'nullable|date|after:fecha_apertura',
            'documento'      => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'fecha_clausura.after' => 'La fecha de clausura debe ser posterior a la apertura.',
            'documento.mimes'      => 'Solo se permiten archivos PDF, DOC o DOCX.',
            'documento.max'        => 'El documento no debe superar 5MB.',
        ]);

        if ($request->hasFile('documento')) {
            // Eliminar el anterior si existe
            if ($gestion->documento) {
                Storage::disk('public')->delete($gestion->documento);
            }

            $archivo = $request->file('documento');
            $nombre  = 'gestion_' . $gestion->anio . '.' . $archivo->getClientOriginalExtension();
            $gestion->documento = $archivo->storeAs('gestiones', $nombre, 'public');
        }

        $gestion->fecha_apertura = $request->fecha_apertura;
        $gestion->fecha_clausura = $request->fecha_clausura;
        $gestion->save();

        return redirect()->route('gestiones.index')
                         ->with('success', 'Gestión ' . $gestion->anio . ' actualizada correctamente.');
    }
}