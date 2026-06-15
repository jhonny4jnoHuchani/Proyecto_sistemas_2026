{{-- resources/views/notas/trimestres.blade.php --}}
@extends('adminlte::page')

@section('title', 'Notas - Seleccionar Trimestre')

@section('content_header')
    <h1>Trimestres <small class="text-muted">— {{ $asignacion->materia->nombre }}</small></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-alt mr-1"></i> Seleccioná un trimestre</h3>
            <div class="card-tools">
                <a href="{{ route('notas.materias', $curso) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Trimestre</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trimestres as $trimestre)
                        <tr>
                            <td class="align-middle font-weight-bold">{{ $trimestre->nombre }}</td>
                            <td class="text-center align-middle">
                                @if ($trimestre->estado === 1 )
                                    <span class="badge badge-success">Abierto</span>
                                @else
                                    <span class="badge badge-secondary">Cerrado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($trimestre->estado === 1 )
                                    <a href="{{ route('notas.cargar', [$curso, $asignacion, $trimestre]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-arrow-right mr-1"></i> Ingresar notas
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="fas fa-lock mr-1"></i> Cerrado
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No hay trimestres configurados para esta gestión.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop