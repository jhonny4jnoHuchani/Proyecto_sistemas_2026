@extends('adminlte::page')

@section('title', 'Gestiones')

@section('content_header')
    <h1>Gestiones Académicas</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('warning') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Nueva Gestión
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Año</th>
                        <th>Estado</th>
                        <th>Fecha Apertura</th>
                        <th>Fecha Clausura</th>
                        <th>Documento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gestiones as $gestion)
                        <tr>
                            <td><strong>{{ $gestion->anio }}</strong></td>
                            <td>
                                @if($gestion->estado)
                                    <span class="badge badge-success">Activa</span>
                                @else
                                    <span class="badge badge-secondary">Cerrada</span>
                                @endif
                            </td>
                            <td>{{ $gestion->fecha_apertura->format('d/m/Y') }}</td>
                            <td>{{ $gestion->fecha_clausura?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                @if($gestion->documento)
                                    <a href="{{ asset($gestion->documento) }}" target="_blank" class="btn btn-xs btn-outline-secondary">
                                        <i class="fas fa-file-pdf"></i> Ver
                                    </a>
                                @else
                                    <span class="text-muted small">Sin documento</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal"
                                    data-target="#modal-edit"
                                    data-id="{{ $gestion->id }}"
                                    data-anio="{{ $gestion->anio }}"
                                    data-fecha_apertura="{{ $gestion->fecha_apertura->format('Y-m-d') }}"
                                    data-fecha_clausura="{{ $gestion->fecha_clausura?->format('Y-m-d') ?? '' }}"
                                    data-documento="{{ $gestion->documento ?? '' }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                No hay gestiones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL CREAR --}}
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-plus mr-2"></i>Nueva Gestión
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form action="{{ route('gestiones.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Año</label>
                            <input type="number" name="anio" class="form-control"
                                   value="{{ now()->year }}" required>
                        </div>

                        <div class="form-group">
                            <label>Fecha de Apertura</label>
                            <input type="date" name="fecha_apertura" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Fecha de Clausura <small class="text-muted">(opcional)</small></label>
                            <input type="date" name="fecha_clausura" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Documento <small class="text-muted">(PDF, DOC, DOCX — máx. 5MB)</small></label>
                            <input type="file" name="documento" class="form-control-file"
                                   accept=".pdf,.doc,.docx">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR --}}
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>Editar Gestión <span id="edit-anio-title"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="form-edit" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Fecha de Apertura</label>
                            <input type="date" name="fecha_apertura" id="edit_fecha_apertura"
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Fecha de Clausura <small class="text-muted">(opcional)</small></label>
                            <input type="date" name="fecha_clausura" id="edit_fecha_clausura"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Documento <small class="text-muted">(dejar vacío para mantener el actual)</small></label>
                            <input type="file" name="documento" class="form-control-file"
                                   accept=".pdf,.doc,.docx">
                            <small id="edit-doc-actual" class="text-muted mt-1 d-block"></small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
@section('js')
<script>
    @if($errors->any())
        $(document).ready(function() {
            @if(session('modal') === 'edit')
                $('#modal-edit').modal('show');
            @else
                $('#modal-create').modal('show');
            @endif
        });
    @endif

    $('.btn-edit').on('click', function() {
        let id             = $(this).data('id');
        let anio           = $(this).data('anio');
        let fecha_apertura = $(this).data('fecha_apertura');
        let fecha_clausura = $(this).data('fecha_clausura');
        let documento      = $(this).data('documento');

        $('#edit-anio-title').text(anio);
        $('#edit_fecha_apertura').val(fecha_apertura);
        $('#edit_fecha_clausura').val(fecha_clausura);

        if (documento) {
            let base = "{{ url('/') }}/";
            $('#edit-doc-actual').html(
                'Documento actual: <a href="' + base + documento + '" target="_blank">ver archivo</a>'
            );
        } else {
            $('#edit-doc-actual').text('Sin documento cargado.');
        }

        let url = "{{ route('gestiones.update', ':id') }}";
        url = url.replace(':id', id);
        $('#form-edit').attr('action', url);
    });
</script>
@stop