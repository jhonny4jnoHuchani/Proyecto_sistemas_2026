@extends('adminlte::page')

@section('title', 'Administrativos Inactivos')

@section('content_header')
    <h1><i class="fas fa-user-slash"></i> Papelera: Administrativos Inactivos</h1>
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
            <a href="{{ route('administrativos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Personal Activo
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Nombre Completo</th>
                            <th>C.I.</th>
                            <th>Cargo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($administrativos as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admin->nombre }} {{ $admin->apellido }}</td>
                                <td>{{ $admin->ci }}</td>
                                <td><span class="badge badge-secondary">{{ $admin->cargo }}</span></td>
                                <td class="text-center">
                                    <form action="{{ route('administrativos.restaurar', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Deseas restaurar el acceso a este empleado?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Restaurar">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('administrativos.forceDelete', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¡PELIGRO! ¿Estás seguro de eliminar este registro de la base de datos permanentemente? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar Definitivamente">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">La papelera está vacía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop