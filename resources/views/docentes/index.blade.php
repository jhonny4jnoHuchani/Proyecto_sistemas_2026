@extends('adminlte::page')

@section('title', 'Docentes')

@section('content_header')
    <h1>Lista de Docentes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Añadir Nuevo Docente
            </button>
            <a href="{{ route('docentes.inactivos') }}" class="btn btn-danger float-right">
                <i class="fas fa-trash-alt"></i> Ver Eliminados
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
                        <th>Email</th>
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
                            <td>{{ $docente->user->email ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                    data-target="#modal-edit" 
                                    data-id="{{ $docente->id }}"
                                    data-user_id="{{ $docente->user_id }}"
                                    data-nombre="{{ $docente->nombre }}"
                                    data-apellido="{{ $docente->apellido }}"
                                    data-ci="{{ $docente->ci }}"
                                    data-especialidad="{{ $docente->especialidad }}"
                                    data-email="{{ $docente->user->email }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este docente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay docentes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
              </table>
        </div>
    </div>

    <!-- MODAL PARA CREAR DOCENTE - MÁS GRANDE Y ANCHO -->
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalCreateLabel">Registrar Nuevo Docente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('docentes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 20px;">
                        <!-- FILA 1: NOMBRE y APELLIDO -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ej: Juan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" id="apellido" placeholder="Ej: Pérez" required>
                                </div>
                            </div>
                        </div>

                        <!-- FILA 2: CI y ESPECIALIDAD -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ci">Cédula de Identidad</label>
                                    <input type="text" name="ci" class="form-control" id="ci" placeholder="Ej: 12345678" required>
                                    <small class="form-text text-muted">La cédula será usada como contraseña del usuario.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="especialidad">Especialidad</label>
                                    <select name="especialidad" class="form-control" id="especialidad" required>
                                        <option value="">Seleccione una especialidad...</option>
                                        @foreach($materias as $materia)
                                            <option value="{{ $materia->nombre }}">{{ $materia->nombre }} ({{ $materia->area }})</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        ¿No encuentra la especialidad? 
                                        <a href="{{ route('materias.index') }}" target="_blank">Cree una nueva materia aquí</a>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- FILA 3: CORREO ELECTRÓNICO (ancho completo) -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Ej: juan@example.com" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Docente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR DOCENTE - MÁS GRANDE Y ANCHO -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Docente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" style="padding: 20px;">
                        <!-- FILA 1: NOMBRE y APELLIDO -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" id="edit_nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_apellido">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" id="edit_apellido" required>
                                </div>
                            </div>
                        </div>

                        <!-- FILA 2: CI y ESPECIALIDAD -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_ci">Cédula de Identidad</label>
                                    <input type="text" name="ci" class="form-control" id="edit_ci" required>
                                    <small class="form-text text-muted">Si cambia la CI, se actualizará el username y contraseña.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_especialidad">Especialidad</label>
                                    <select name="especialidad" class="form-control" id="edit_especialidad" required>
                                        <option value="">Seleccione una especialidad...</option>
                                        @foreach($materias as $materia)
                                            <option value="{{ $materia->nombre }}">{{ $materia->nombre }} ({{ $materia->area }})</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        ¿No encuentra la especialidad? 
                                        <a href="{{ route('materias.index') }}" target="_blank">Cree una nueva materia aquí</a>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- FILA 3: CORREO ELECTRÓNICO (ancho completo) -->
                        <div class="form-group">
                            <label for="edit_email">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" id="edit_email" required>
                        </div>

                        <!-- FILA 4: CONTRASEÑA (ancho completo) -->
                        <div class="form-group">
                            <label for="password">Nueva Contraseña (opcional)</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Dejar en blanco para mantener la actual">
                            <small class="form-text text-muted">Si desea cambiar la contraseña, ingrese una nueva.</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Docente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        @if ($errors->any())
            $(document).ready(function() {
                $('#modal-create').modal('show');
            });
        @endif

        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            let apellido = $(this).data('apellido');
            let ci = $(this).data('ci');
            let especialidad = $(this).data('especialidad');
            let email = $(this).data('email');

            $('#edit_nombre').val(nombre);
            $('#edit_apellido').val(apellido);
            $('#edit_ci').val(ci);
            $('#edit_email').val(email);
            $('#password').val('');
            
            if (especialidad) {
                $('#edit_especialidad').val(especialidad);
            }

            let url = "{{ route('docentes.update', ':id') }}";
            url = url.replace(':id', id);
            $('#form-edit').attr('action', url);
        });
    </script>
@stop