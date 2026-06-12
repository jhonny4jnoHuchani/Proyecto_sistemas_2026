@extends('adminlte::page')

@section('title', 'Materias')

@section('content_header')
    <h1>Lista de Materias</h1>
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
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Añadir Nueva Materia
            </button>

            <a href="{{ route('materias.inactivos') }}" class="btn btn-danger float-right">
                <i class="fas fa-trash-alt"></i> Ver Eliminados
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
                                <button class="btn btn-sm btn-warning btn-edit" 
                                    data-toggle="modal" 
                                    data-target="#modal-edit"
                                    data-id="{{ $materia->id }}"
                                    data-nombre="{{ $materia->nombre }}"
                                    data-area="{{ $materia->area }}"
                                    data-carga="{{ $materia->carga_horaria }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                                <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta materia?');">
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
                            <td colspan="5" class="text-center">Aún no hay materias registradas.</td>
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
                    <h5 class="modal-title">Registrar Nueva Materia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="{{ route('materias.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Materia</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ej: Matemáticas" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="area">Área</label>
                            <input type="text" name="area" class="form-control" id="area" placeholder="Ej: Ciencias Exactas" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="carga_horaria">Carga Horaria (Horas)</label>
                            <input type="number" name="carga_horaria" class="form-control" id="carga_horaria" placeholder="Ej: 80" required>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Materia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Materia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="edit_nombre">Nombre de la Materia</label>
                            <input type="text" name="nombre" class="form-control" id="edit_nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_area">Área</label>
                            <input type="text" name="area" class="form-control" id="edit_area" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_carga_horaria">Carga Horaria (Horas)</label>
                            <input type="number" name="carga_horaria" class="form-control" id="edit_carga_horaria" required>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Materia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Si hay errores de validación, vuelve a abrir el modal de crear
        @if($errors->any())
            $(document).ready(function(){
                $('#modal-create').modal('show');
            });
        @endif

        // Lógica para pasar datos al modal de EDICIÓN
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                let area = $(this).data('area');
                let carga = $(this).data('carga');
                
                $('#edit_nombre').val(nombre);
                $('#edit_area').val(area);
                $('#edit_carga_horaria').val(carga);
                
                let url = "{{ route('materias.update', ':id') }}";
                url = url.replace(':id', id);
                
                $('#form-edit').attr('action', url);
            });
        });
    </script>
@stop