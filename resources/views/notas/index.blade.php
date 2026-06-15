{{-- resources/views/notas/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Notas - Seleccionar Curso')

@section('content_header')
    <h1>Notas <small class="text-muted">— Gestión {{ $gestion->anio }}</small></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chalkboard mr-1"></i> Seleccioná un curso</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Grado</th>
                        <th>Paralelo</th>
                        <th>Turno</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cursos as $curso)
                        <tr>
                            <td class="align-middle">{{ $curso->grado }}°</td>
                            <td class="align-middle">{{ $curso->paralelo }}</td>
                            <td class="align-middle">{{ ucfirst($curso->turno) }}</td>
                            <td class="text-center">
                                <a href="{{ route('notas.materias', $curso) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right mr-1"></i> Seleccionar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No hay cursos con asignaciones en esta gestión.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop