@extends('adminlte::page')

@section('title', 'Materias Inactivas')

@section('content_header')
    <h1>Papelera: Materias Eliminadas</h1>
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
            <a href="{{ route('materias.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Materias Activas
            </a>
        </div>
        
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Carga Horaria</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materias as $materia)
                        <tr>
                            <td>{{ $materia->id }}</td>
                            <td>{{ $materia->nombre }}</td>
                            <td>{{ $materia->area }}</td>
                            <td>{{ $materia->carga_horaria }} hrs</td>
                            <td>
                                <form action="{{ route('materias.restaurar', $materia->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Deseas restaurar esta materia?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo"></i> Restaurar
                                    </button>
                                </form>

                                <form action="{{ route('materias.forceDelete', $materia->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¡ADVERTENCIA! Esta acción no se puede deshacer. ¿Deseas eliminar esta materia permanentemente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times-circle"></i> Eliminar Totalmente
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay materias en la papelera.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop