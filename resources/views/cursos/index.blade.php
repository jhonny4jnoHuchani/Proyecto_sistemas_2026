@extends('adminlte::page')

@section('title', 'Cursos')

@section('content_header')
    <h1><i class="fas fa-school"></i> Gestión de Cursos</h1>
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
    
    <div class="row mb-3">
        <div class="col-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Añadir Nuevo Curso
            </button>
            <a href="{{ route('cursos.inactivos') }}" class="btn btn-danger float-right">
                <i class="fas fa-trash-alt"></i> Ver Eliminados
            </a>
        </div>
    </div>

    <!-- TARJETAS POR GRADOS -->
    <div class="row">
        @php
            $colores = [
                1 => 'primary',
                2 => 'success',
                3 => 'info',
                4 => 'warning',
                5 => 'danger',
                6 => 'secondary'
            ];
            
            $grados = [1, 2, 3, 4, 5, 6];
        @endphp

        @foreach($grados as $grado)
            @php
                $cursosPorGrado = $cursos->where('grado', $grado);
                $color = $colores[$grado];
            @endphp
            
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card card-{{ $color }} card-outline">
                    <div class="card-header bg-{{ $color }} text-white">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $grado }}° Grado
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-light">{{ $cursosPorGrado->count() }} paralelo(s)</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        @if($cursosPorGrado->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Paralelo</th>
                                            <th>Turno</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cursosPorGrado as $curso)
                                            <tr>
                                                <td>
                                                    <span class="badge badge-{{ $color }} px-3 py-2">
                                                        {{ $curso->paralelo }}
                                                    </span>
                                                </td>
                                                <td>{{ $curso->turno }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-warning btn-edit" 
                                                        data-toggle="modal"
                                                        data-target="#modal-edit" 
                                                        data-id="{{ $curso->id }}"
                                                        data-grado="{{ $curso->grado }}" 
                                                        data-paralelo="{{ $curso->paralelo }}"
                                                        data-turno="{{ $curso->turno }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
                                                    <form action="{{ route('cursos.destroy', $curso->id) }}" 
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No hay paralelos registrados</p>
                                <button class="btn btn-sm btn-{{ $color }} mt-2 btn-add-grado" 
                                    data-grado="{{ $grado }}" data-toggle="modal" data-target="#modal-create">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    @if($cursosPorGrado->count() > 0)
                        <div class="card-footer text-muted text-center">
                            <small>
                                <i class="fas fa-chalkboard-teacher"></i> 
                                Total: {{ $cursosPorGrado->count() }} paralelo(s)
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- MODAL PARA CREAR CURSO (MEJORADO) -->
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalCreateLabel">
                        <i class="fas fa-plus-circle"></i> Registrar Nuevo Curso
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('cursos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="grado">Grado <span class="text-danger">*</span></label>
                            <select name="grado" class="form-control" id="grado" required>
                                <option value="">Seleccione un grado...</option>
                                <option value="1">1ro Grado</option>
                                <option value="2">2do Grado</option>
                                <option value="3">3ro Grado</option>
                                <option value="4">4to Grado</option>
                                <option value="5">5to Grado</option>
                                <option value="6">6to Grado</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="paralelo">Paralelo <span class="text-danger">*</span></label>
                            <input type="text" name="paralelo" class="form-control" id="paralelo" 
                                placeholder="Ej: A, B, C" maxlength="10" required>
                        </div>

                        <div class="form-group">
                            <label for="turno">Turno <span class="text-danger">*</span></label>
                            <select name="turno" class="form-control" id="turno" required>
                                <option value="">Seleccione un turno...</option>
                                <option value="Mañana">🌅 Mañana</option>
                                <option value="Tarde">☀️ Tarde</option>
                                <option value="Noche">🌙 Noche</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR CURSO (MEJORADO) -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i> Editar Curso
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_grado">Grado <span class="text-danger">*</span></label>
                            <select name="grado" class="form-control" id="edit_grado" required>
                                <option value="">Seleccione un grado...</option>
                                <option value="1">1ro Grado</option>
                                <option value="2">2do Grado</option>
                                <option value="3">3ro Grado</option>
                                <option value="4">4to Grado</option>
                                <option value="5">5to Grado</option>
                                <option value="6">6to Grado</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_paralelo">Paralelo <span class="text-danger">*</span></label>
                            <input type="text" name="paralelo" class="form-control" id="edit_paralelo" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_turno">Turno <span class="text-danger">*</span></label>
                            <select name="turno" class="form-control" id="edit_turno" required>
                                <option value="Mañana">🌅 Mañana</option>
                                <option value="Tarde">☀️ Tarde</option>
                                <option value="Noche">🌙 Noche</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Actualizar Curso
                        </button>
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

        // Para el botón de agregar dentro de una tarjeta vacía
        $('.btn-add-grado').on('click', function() {
            let grado = $(this).data('grado');
            $('#grado').val(grado);
        });

        // Código para pasar los datos del botón al modal de edición
        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let grado = $(this).data('grado');
            let paralelo = $(this).data('paralelo');
            let turno = $(this).data('turno');

            // Llenar los campos del modal
            $('#edit_grado').val(grado);
            $('#edit_paralelo').val(paralelo);
            $('#edit_turno').val(turno);

            // Modificar la URL del formulario
            let url = "{{ route('cursos.update', ':id') }}";
            url = url.replace(':id', id);
            $('#form-edit').attr('action', url);
        });
    </script>
@stop