<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\User;
use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiantes = Estudiante::with(['user', 'inscripcionActiva.curso'])->get();
        $cursos = \App\Models\Curso::where('estado', true)
            ->orderBy('grado')
            ->orderBy('paralelo')
            ->get();

        return view('estudiantes.index', compact('estudiantes', 'cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store vía AJAX
     */
    public function storeAjax(Request $request)
    {
        $gestion_actual = Gestion::where('estado', true)->first();

        $validator = \Validator::make($request->all(), [
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'ci'               => 'required|string|max:20|unique:estudiantes,ci',
            'genero'           => 'required|in:Masculino,Femenino,Otro',
            'celular'          => 'nullable|string|max:15',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'rude'             => 'nullable|string|max:50|unique:estudiantes,rude',
            'id_curso'         => 'required|exists:cursos,id',
        ], [
            'nombre.required'       => 'El nombre es obligatorio.',
            'nombre.max'            => 'El nombre no puede tener más de 100 caracteres.',
            'apellido.required'     => 'El apellido es obligatorio.',
            'apellido.max'          => 'El apellido no puede tener más de 100 caracteres.',
            'ci.required'           => 'El CI es obligatorio.',
            'ci.unique'             => 'Este CI ya está registrado.',
            'ci.max'                => 'El CI no puede tener más de 20 caracteres.',
            'genero.required'       => 'El género es obligatorio.',
            'genero.in'             => 'El género seleccionado no es válido.',
            'celular.max'           => 'El celular no puede tener más de 15 dígitos.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
            'rude.unique'           => 'Este RUDE ya está registrado.',
            'rude.max'              => 'El RUDE no puede tener más de 50 caracteres.',
            'id_curso.required'     => 'Debe seleccionar el grado y paralelo.',
            'id_curso.exists'       => 'El curso seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok'     => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'username' => $request->nombre . '_' . $request->ci,
            'email'    => $request->ci . '@example.com',
            'password' => Hash::make($request->ci),
            'rol'      => 'estudiante',
            'estado'   => true,
        ]);

        $estudiante = Estudiante::create([
            'user_id'          => $user->id,
            'nombre'           => $request->nombre,
            'apellido'         => $request->apellido,
            'ci'               => $request->ci,
            'rude'             => $request->rude,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion'        => $request->direccion,
            'telefono'         => $request->celular,
            //'genero'           => $request->genero,
        ]);

        Inscripcion::create([
            'id_estudiante'     => $estudiante->id,
            'id_curso'          => $request->id_curso,
            'id_gestion'        => $gestion_actual->id_gestion,
            'fecha_inscripcion' => now()->format('Y-m-d'),
            'estado'            => true,
        ]);

        return response()->json([
            'ok'          => true,
            'estudiante'  => [
                'id'     => $estudiante->id,
                'nombre' => $estudiante->nombre . ' ' . $estudiante->apellido,
            ],
        ]);
    }

    /**
     * Generar PDF de inscripción
     */
    public function generarPdf($id)
    {
        $estudiante = Estudiante::with([
            'inscripcionActiva.curso',
            'inscripcionActiva.gestion',
        ])->findOrFail($id);

        $inscripcion = $estudiante->inscripcionActiva;
        $curso       = $inscripcion?->curso;

        // Materias y docentes asignados al curso en la gestión activa
        $asignaciones = [];
        if ($curso) {
            $asignaciones = \App\Models\Asignacion::with(['materia', 'docente'])
                ->where('curso_id', $curso->id)
                ->where('estado', true)
                ->get();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('estudiantes.pdf', [
            'estudiante'  => $estudiante,
            'inscripcion' => $inscripcion,
            'curso'       => $curso,
            'asignaciones'=> $asignaciones,
        ])->setPaper('letter', 'portrait');

        return $pdf->stream('inscripcion_' . $estudiante->ci . '.pdf');
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
            'ci' => 'unique:estudiantes,ci,' . $estudiante->id,
            'genero'           => 'required|in:Masculino,Femenino,Otro',
            'celular'          => 'nullable|string|max:15',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'rude'             => 'nullable|string|max:50|unique:estudiantes,rude,' . $estudiante->id,
            'id_curso'         => 'required|exists:cursos,id',
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
            'id_curso.required'    => 'Debe seleccionar el grado y paralelo.',
            'id_curso.exists'      => 'El curso seleccionado no es válido.',
        ]);

        $estudiante->user->update([
            'username' => $request->nombre . '_' . $request->ci,  // si quieres actualizar username
            'email'    => $request->ci . '@example.com',          // si quieres actualizar email
        ]);

        $estudiante->update([
            'nombre'           => $request->nombre,
            'apellido'         => $request->apellido,
            'ci'               => $request->ci,
            'rude'             => $request->rude,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion'        => $request->direccion,
            'telefono'         => $request->celular,
            'genero'           => $request->genero,  // si tienes este campo
        ]);

        // Actualizar o crear la inscripción activa del estudiante
        $inscripcion = Inscripcion::where('id_estudiante', $estudiante->id)
            ->where('estado', true)
            ->latest('id_inscripcion')
            ->first();

        if ($inscripcion) {
            // Solo actualiza el curso si cambió
            if ($inscripcion->id_curso != $request->id_curso) {
                $inscripcion->update([
                    'id_curso' => $request->id_curso,
                ]);
            }
        } else {
            Inscripcion::create([
                'id_estudiante'     => $estudiante->id,
                'id_curso'          => $request->id_curso,
                'id_gestion' => Gestion::where('estado', true)->first()->id_gestion,
                'fecha_inscripcion' => now()->format('Y-m-d'),
                'estado'            => true,
            ]);
        }

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