@extends('adminlte::page')

@section('title', 'Cursos')

@section('content_header')
    <h1>Lista de Cursos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Añadir Nuevo Curso
            </button>
            <a href="{{ route('cursos.inactivos') }}" class="btn btn-danger float-right">
                <i class="fas fa-trash-alt"></i> Ver Eliminados
            </a>
        </div>
        

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Paralelo</th>
                        <th>Turno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cursos as $curso)
                        <tr>
                            <td>{{ $curso->id }}</td>
                            <td>{{ $curso->nombre }}</td>
                            <td>{{ $curso->paralelo }}</td>
                            <td>{{ $curso->turno }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                    data-target="#modal-edit" data-id="{{ $curso->id }}"
                                    data-nombre="{{ $curso->nombre }}" data-paralelo="{{ $curso->paralelo }}"
                                    data-turno="{{ $curso->turno }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');">
                                    @csrf
                                    @method('DELETE') <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aún no hay cursos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>




    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('PUT') <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nombre">Nombre del Curso</label>
                            <input type="text" name="nombre" class="form-control" id="edit_nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_paralelo">Paralelo</label>
                            <input type="text" name="paralelo" class="form-control" id="edit_paralelo" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_turno">Turno</label>
                            <select name="turno" class="form-control" id="edit_turno" required>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Curso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalCreateLabel">Registrar Nuevo Curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('cursos.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre del Curso</label>
                            <input type="text" name="nombre" class="form-control" id="nombre"
                                placeholder="Ej: Primero de Secundaria" required>
                        </div>

                        <div class="form-group">
                            <label for="paralelo">Paralelo</label>
                            <input type="text" name="paralelo" class="form-control" id="paralelo"
                                placeholder="Ej: A, B, C" required>
                        </div>

                        <div class="form-group">
                            <label for="turno">Turno</label>
                            <select name="turno" class="form-control" id="turno" required>
                                <option value="">Seleccione un turno...</option>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Curso</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Si Laravel detecta errores de validación, vuelve a abrir el modal automáticamente
        @if ($errors->any())
            $(document).ready(function() {
                $('#modal-create').modal('show');
            });
        @endif

        // Código para pasar los datos del botón al modal de edición
        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            let paralelo = $(this).data('paralelo');
            let turno = $(this).data('turno');

            // 2. Llenar los campos del modal
            $('#edit_nombre').val(nombre);
            $('#edit_paralelo').val(paralelo);
            $('#edit_turno').val(turno);

            // 3. Modificar la URL del formulario para que apunte al curso correcto
            // Creamos una URL base y le reemplazamos una palabra clave por el ID real
            let url = "{{ route('cursos.update', ':id') }}";
            url = url.replace(':id', id);

            $('#form-edit').attr('action', url);
        });
    </script>
@stop
