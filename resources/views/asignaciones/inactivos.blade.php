@extends('adminlte::page')

@section('title', 'Asignaciones Inactivas')

@section('content_header')
    <h1>Papelera: Asignaciones Eliminadas</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-danger card-outline">
        <div class="card-header">
            <a href="{{ route('asignaciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Asignaciones Activas
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
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaciones as $asignacion)
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay asignaciones en la papelera.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop