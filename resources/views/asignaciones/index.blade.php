@extends('adminlte::page')

@section('title', 'Asignaciones Académicas')

@section('content_header')
    <h1>Designación de Carga Académica</h1>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Nueva Asignación
            </button>

            <a href="{{ route('asignaciones.inactivos') }}" class="btn btn-danger float-right">
                <i class="fas fa-trash-alt"></i> Ver Eliminados
            </a>
        </div>
        
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Gestión</th>
                        <th>Docente</th>
                        <th>Materia</th>
                        <th>Curso / Paralelo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaciones as $asignacion)
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay asignaciones académicas registradas aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Registrar Asignación</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('asignaciones.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label>Gestión Académica</label>
                            <select name="gestion_id" class="form-control" required>
                                <option value="">-- Seleccione Gestión --</option>
                                @foreach($gestiones as $g)
                                    <option value="{{ $g->id }}">{{ $g->anio }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Docente</label>
                            <select name="docente_id" class="form-control" required>
                                <option value="">-- Seleccione Docente --</option>
                                @foreach($docentes as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre }} {{ $d->apellido }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Materia</label>
                            <select name="materia_id" class="form-control" required>
                                <option value="">-- Seleccione Materia --</option>
                                @foreach($materias as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre }} ({{ $m->area }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Curso Destino</label>
                            <select name="curso_id" class="form-control" required>
                                <option value="">-- Seleccione Curso --</option>
                                @foreach($cursos as $c)
                                    <option value="{{ $c->id }}">{{ $c->nombre }} - {{ $c->paralelo }} ({{ $c->turno }})</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop