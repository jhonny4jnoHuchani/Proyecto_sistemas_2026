@extends('adminlte::page')

@section('title', 'Administrativos')

@section('content_header')
    <h1><i class="fas fa-user-tie"></i> Gestión de Personal Administrativo</h1>
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

    <div class="callout callout-info">
        <h5><i class="fas fa-info-circle text-info"></i> Información sobre Credenciales de Acceso</h5>
        <p>
            Al registrar un nuevo miembro del personal administrativo, el sistema genera automáticamente su cuenta de usuario con la siguiente estructura:<br>
            <ul class="mb-0 mt-1">
                <li><strong>Correo Electrónico:</strong> <code>[C.I.]@colegio.com</code> (Ejemplo: <i>1234567@colegio.com</i>)</li>
                <li><strong>Usuario y Contraseña:</strong> El número de Carnet de Identidad (C.I.).</li>
            </ul>
        </p>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Nuevo Administrativo
            </button>
            <a href="{{ route('administrativos.inactivos') }}" class="btn btn-danger float-right">
                <i class="fas fa-trash-alt"></i> Ver Inactivos
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
                                <td><span class="badge badge-info">{{ $admin->cargo }}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" 
                                        data-id="{{ $admin->id }}"
                                        data-nombre="{{ $admin->nombre }}"
                                        data-apellido="{{ $admin->apellido }}"
                                        data-ci="{{ $admin->ci }}"
                                        data-cargo="{{ $admin->cargo }}"
                                        data-toggle="modal" data-target="#modal-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('administrativos.destroy', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Dar de baja a este empleado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-user-minus"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay personal administrativo registrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Registrar Personal</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('administrativos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellido *</label>
                                <input type="text" name="apellido" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>C.I. *</label>
                                <input type="text" name="ci" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Cargo *</label>
                                <select name="cargo" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Director">Director</option>
                                    <option value="Secretaria">Secretaria</option>
                                    <option value="Regente">Regente</option>
                                    <option value="Portero">Portero</option>
                                    <option value="Psicologo">Psicólogo</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="alert alert-info py-2 mb-0">
                            <small>
                                <strong><i class="fas fa-magic"></i> Creación Automática:</strong> Al guardar, el usuario será el C.I., la contraseña será el C.I., y el correo será <i>[ci]@colegio.com</i>.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Personal</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-edit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre *</label>
                                <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellido *</label>
                                <input type="text" name="apellido" id="edit_apellido" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>C.I. *</label>
                                <input type="text" name="ci" id="edit_ci" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Cargo *</label>
                                <select name="cargo" id="edit_cargo" class="form-control" required>
                                    <option value="Director">Director</option>
                                    <option value="Secretaria">Secretaria</option>
                                    <option value="Regente">Regente</option>
                                    <option value="Portero">Portero</option>
                                    <option value="Psicologo">Psicólogo</option>
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-warning py-2 mb-0">
                            <small><i class="fas fa-exclamation-triangle"></i> Si modificas el C.I., el usuario de acceso para el sistema también cambiará automáticamente.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        $('#edit_nombre').val($(this).data('nombre'));
        $('#edit_apellido').val($(this).data('apellido'));
        $('#edit_ci').val($(this).data('ci'));
        $('#edit_cargo').val($(this).data('cargo'));
        
        let url = "{{ route('administrativos.update', ':id') }}";
        $('#form-edit').attr('action', url.replace(':id', id));
    });
</script>
@stop