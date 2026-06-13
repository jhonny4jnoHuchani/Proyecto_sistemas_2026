@extends('adminlte::page')

@section('title', 'Detalle del Curso')

@section('content_header')
    <h1>{{ $curso->grado }}° "{{ $curso->paralelo }}" - Materias Asignadas</h1>
    <a href="{{ route('asignaciones.paralelos', $curso->grado) }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Volver a Paralelos
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
            <h3 class="card-title">Materias y Docentes</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-agregar-materia">
                    <i class="fas fa-plus"></i> Agregar Materia
                </button>
            </div>
        </div>

        <form action="{{ route('asignaciones.guardarDocentes', $curso->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Materia</th>
                            <th>Área</th>
                            <th>Docente Asignado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asignaciones as $asignacion)
                            <tr>
                                <td>{{ $asignacion->materia->nombre }}</td>
                                <td>{{ $asignacion->materia->area }}</td>
                                <td>
                                    <select name="docentes[{{ $asignacion->id }}]" class="form-control">
                                        <option value="">-- Sin asignar --</option>
                                        @foreach($asignacion->docentes_disponibles as $docente)
                                            <option value="{{ $docente->id }}"
                                                {{ $asignacion->docente_id == $docente->id ? 'selected' : '' }}>
                                                {{ $docente->nombre }} {{ $docente->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($asignacion->docentes_disponibles->isEmpty())
                                        <small class="text-danger">
                                            No hay docentes con especialidad "{{ $asignacion->materia->nombre }}"
                                        </small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    Este curso aún no tiene materias asignadas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($asignaciones->isNotEmpty())
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Confirmar Docentes
                    </button>
                </div>
            @endif
        </form>
    </div>

    {{-- Modal: Agregar más materias a este curso (materia + docente directo) --}}
    <div class="modal fade" id="modal-agregar-materia" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Agregar Materias a {{ $curso->grado }}° "{{ $curso->paralelo }}"</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('asignaciones.agregarMateria', $curso->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @forelse($materiasDisponibles as $index => $materia)
                            <div class="form-row align-items-center border-bottom pb-2 mb-2">
                                <div class="col-md-1">
                                    <input type="checkbox"
                                        class="form-check-input check-materia"
                                        data-index="{{ $index }}">
                                </div>
                                <div class="col-md-5">
                                    <strong>{{ $materia->nombre }}</strong>
                                    <br><small class="text-muted">{{ $materia->area }}</small>
                                </div>
                                <div class="col-md-6">
                                    <select name="nuevas[{{ $index }}][docente_id]" class="form-control select-docente-{{ $index }}" disabled>
                                        <option value="">-- Sin asignar --</option>
                                        @foreach($materia->docentes_disponibles as $docente)
                                            <option value="{{ $docente->id }}">
                                                {{ $docente->nombre }} {{ $docente->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($materia->docentes_disponibles->isEmpty())
                                        <small class="text-danger">
                                            No hay docentes con especialidad "{{ $materia->nombre }}"
                                        </small>
                                    @endif
                                </div>
                                {{-- Campo oculto que solo se activa si el checkbox está marcado --}}
                                <input type="hidden" name="nuevas[{{ $index }}][materia_id]" value="{{ $materia->id }}" class="hidden-materia-{{ $index }}" disabled>
                            </div>
                        @empty
                            <p class="text-center text-muted">
                                Este curso ya tiene todas las materias disponibles asignadas.
                            </p>
                        @endforelse
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        @if($materiasDisponibles->isNotEmpty())
                            <button type="submit" class="btn btn-success">Agregar Seleccionadas</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('js')
<script>
    $(document).ready(function () {
        // Habilita/deshabilita el select y el campo oculto según el checkbox
        $('.check-materia').on('change', function () {
            let index = $(this).data('index');
            let isChecked = $(this).is(':checked');

            $('.select-docente-' + index).prop('disabled', !isChecked);
            $('.hidden-materia-' + index).prop('disabled', !isChecked);
        });
    });
</script>
@stop