@extends('adminlte::page')

@section('title', 'Cursos Inactivos')

@section('content_header')
    <h1>Papelera: Cursos Eliminados</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif
    
    <div class="card card-danger card-outline">
        <div class="card-header">
            <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Cursos Activos
            </a>
        </div>
        
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Grado</th>      {{-- CAMBIADO: Nombre → Grado --}}
                        <th>Paralelo</th>
                        <th>Turno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cursos as $curso)
                        <tr>
                            <td>{{ $curso->id }}</td>
                            <td>{{ $curso->grado }}° {{-- CAMBIADO: muestra el grado con el símbolo de grado --}}</td>
                            <td>{{ $curso->paralelo }}</td>
                            <td>{{ $curso->turno }}</td>
                            <td>
                                <form action="{{ route('cursos.restaurar', $curso->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Deseas restaurar este curso?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo"></i> Restaurar
                                    </button>
                                </form>

                                <form action="{{ route('cursos.forceDelete', $curso->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¡ADVERTENCIA! Esta acción no se puede deshacer. ¿Deseas eliminarlo de la base de datos para siempre?');">
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
                            <td colspan="5" class="text-center">No hay cursos en la papelera.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop