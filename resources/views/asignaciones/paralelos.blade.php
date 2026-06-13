@extends('adminlte::page')

@section('title', 'Paralelos - Grado ' . $grado)

@section('content_header')
    <h1>{{ $grado }}° Grado - Paralelos</h1>
    <a href="{{ route('asignaciones.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Volver a Grados
    </a>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-asignar-masivo">
                <i class="fas fa-plus"></i> Asignar Materias a {{ $grado }}° Grado
            </button>
        </div>

        <div class="card-body">
            <div class="row">
                @forelse($cursos as $curso)
                    <div class="col-md-2">
                        <a href="{{ route('asignaciones.detalle', $curso->id) }}" style="text-decoration:none;">
                            <div class="card card-outline card-success text-center">
                                <div class="card-body">
                                    <h4>{{ $grado }}° "{{ $curso->paralelo }}"</h4>
                                    <p class="text-muted mb-0">{{ $curso->total_asignaciones }} asignaciones</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No hay paralelos registrados para este grado.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal: Asignación masiva de materias para todo el grado --}}
    <div class="modal fade" id="modal-asignar-masivo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Asignar Materias - {{ $grado }}° Grado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('asignaciones.asignarMasivo', $grado) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">
                            Selecciona las materias que se asignarán a TODOS los paralelos del {{ $grado }}° grado
                            ({{ $cursos->pluck('paralelo')->implode(', ') }}).
                        </p>

                        @forelse($materias as $materia)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="materias[]"
                                    value="{{ $materia->id }}"
                                    id="materia_{{ $materia->id }}"
                                    {{ $materiasAsignadasIds->contains($materia->id) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="materia_{{ $materia->id }}">
                                    {{ $materia->nombre }} <span class="text-muted">({{ $materia->area }})</span>
                                </label>
                            </div>
                        @empty
                            <p class="text-muted">No hay materias registradas.</p>
                        @endforelse
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop