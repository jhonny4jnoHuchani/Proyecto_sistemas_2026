@extends('adminlte::page')

@section('title', 'Docentes Eliminados')

@section('content_header')
    <h1>Docentes Eliminados</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('docentes.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver a Docentes Activos
            </a>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>CI</th>
                        <th>Especialidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($docentes as $docente)
                        <tr>
                            <td>{{ $docente->id }}</td>
                            <td>{{ $docente->user->username ?? 'N/A' }}</td>
                            <td>{{ $docente->nombre }}</td>
                            <td>{{ $docente->apellido }}</td>
                            <td>{{ $docente->ci }}</td>
                            <td>{{ $docente->especialidad }}</td>
                            <td>
                                <form action="{{ route('docentes.restore', $docente->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Restaurar este docente?')">
                                        <i class="fas fa-trash-restore"></i> Restaurar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay docentes eliminados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop