{{-- resources/views/notas/materias.blade.php --}}
@extends('adminlte::page')

@section('title', 'Notas - Seleccionar Materia')

@section('content_header')
    <h1>Materias <small class="text-muted">— {{ $curso->grado }}° {{ $curso->paralelo }}</small></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-book mr-1"></i> Seleccioná una materia</h3>
            <div class="card-tools">
                <a href="{{ route('notas.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Materia</th>
                        <th>Área</th>
                        <th>Docente</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaciones as $asignacion)
                        <tr>
                            <td class="align-middle font-weight-bold">{{ $asignacion->materia->nombre }}</td>
                            <td class="align-middle text-muted">{{ $asignacion->materia->area }}</td>
                            <td class="align-middle">
                                {{ $asignacion->docente->nombre }} {{ $asignacion->docente->apellido }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('notas.trimestres', [$curso, $asignacion]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right mr-1"></i> Seleccionar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No hay materias asignadas a este curso.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop