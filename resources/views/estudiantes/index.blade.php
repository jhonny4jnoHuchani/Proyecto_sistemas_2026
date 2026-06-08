@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista estudiantes</h1>
@stop

@section('content')
<!-- Botones para abrir modal con diferentes datos -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form_estudiante">
    <i class="fas fa-user-plus"></i> Crear Estudiante
</button>

<!-- Modal -->
<div class="modal fade" id="form_estudiante" tabindex="-1" aria-labelledby="form_estudianteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="form_estudianteLabel">
                    <i class="fas fa-user-graduate"></i> Registrar Nuevo Estudiante
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCrearEstudiante" action="{{ route('estudiantes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="col-form-label">
                                <i class="fas fa-user"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <div class="invalid-feedback">El nombre es requerido</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="col-form-label">
                                <i class="fas fa-user"></i> Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                            <div class="invalid-feedback">El apellido es requerido</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ci" class="col-form-label">
                                <i class="fas fa-id-card"></i> CI <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="ci" name="ci" required>
                            <div class="invalid-feedback">El CI es requerido</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="rude" class="col-form-label">
                                <i class="fas fa-qrcode"></i> RUDE
                            </label>
                            <input type="text" class="form-control" id="rude" name="rude">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="celular" class="col-form-label">
                                <i class="fas fa-phone"></i> Celular
                            </label>
                            <input type="tel" class="form-control" id="celular" name="celular" pattern="[0-9]{8}">
                            <small class="form-text text-muted">Formato: 8 dígitos</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="genero" class="col-form-label">
                                <i class="fas fa-venus-mars"></i> Género <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="genero" name="genero" required>
                                <option value="">Seleccione género</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <div class="invalid-feedback">Seleccione un género</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="fecha_nacimiento" class="col-form-label">
                                <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                            </label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="col-form-label">
                            <i class="fas fa-map-marker-alt"></i> Dirección
                        </label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2" placeholder="Dirección completa del estudiante"></textarea>
                    </div>

                    <div class="alert alert-info mt-2">
                        <i class="fas fa-info-circle"></i> Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Estudiante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Tabla de estudiantes -->
<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                
                <th>Nombre</th>
                <th>Apellido</th>
                <th>CI</th>
                
                <th>Celular</th>
                <th>Dirección</th>
                <th>Fecha Nac.</th>
                <th>RUDE</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $estudiante)
            <tr>
                
                <td>{{ $estudiante->user->name ?? 'N/A' }}</td>
                <td>{{ $estudiante->user->apellido ?? 'N/A' }}</td>
                <td>{{ $estudiante->user->ci ?? 'N/A' }}</td>
                
                <td>{{ $estudiante->user->celular ?? 'N/A' }}</td>
                <td>{{ $estudiante->user->direccion ?? 'N/A' }}</td>
                <td>{{ $estudiante->user->fecha_nacimiento ?? 'N/A' }}</td>
                <td>{{ $estudiante->rude ?? 'N/A' }}</td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEstudianteModal{{ $estudiante->id }}">
                        <i class="fas fa-edit"></i> Editar
                    </button>

                    <!-- Modal de Edición para cada estudiante -->
                    <div class="modal fade" id="editEstudianteModal{{ $estudiante->id }}" tabindex="-1" aria-labelledby="editEstudianteModalLabel{{ $estudiante->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h1 class="modal-title fs-5" id="editEstudianteModalLabel{{ $estudiante->id }}">
                                        <i class="fas fa-user-edit"></i> Editar Estudiante
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nombre{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-user"></i> Nombre <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nombre{{ $estudiante->id }}" 
                                                    name="nombre" value="{{ $estudiante->user->name ?? '' }}" required>
                                                <div class="invalid-feedback">El nombre es requerido</div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="apellido{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-user"></i> Apellido <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="apellido{{ $estudiante->id }}" 
                                                    name="apellido" value="{{ $estudiante->user->apellido ?? '' }}" required>
                                                <div class="invalid-feedback">El apellido es requerido</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="ci{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-id-card"></i> CI <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="ci{{ $estudiante->id }}" 
                                                    name="ci" value="{{ $estudiante->user->ci ?? '' }}" required>
                                                <div class="invalid-feedback">El CI es requerido</div>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="rude{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-qrcode"></i> RUDE
                                                </label>
                                                <input type="text" class="form-control" id="rude{{ $estudiante->id }}" 
                                                    name="rude" value="{{ $estudiante->rude ?? '' }}">
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="celular{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-phone"></i> Celular
                                                </label>
                                                <input type="tel" class="form-control" id="celular{{ $estudiante->id }}" 
                                                    name="celular" value="{{ $estudiante->user->celular ?? '' }}" pattern="[0-9]{8}">
                                                <small class="form-text text-muted">Formato: 8 dígitos</small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="genero{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-venus-mars"></i> Género <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="genero{{ $estudiante->id }}" name="genero" required>
                                                    <option value="">Seleccione género</option>
                                                    <option value="Masculino" {{ ($estudiante->user->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Femenino" {{ ($estudiante->user->genero ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                    <option value="Otro" {{ ($estudiante->user->genero ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                <div class="invalid-feedback">Seleccione un género</div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="fecha_nacimiento{{ $estudiante->id }}" class="col-form-label">
                                                    <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                                                </label>
                                                <input type="date" class="form-control" id="fecha_nacimiento{{ $estudiante->id }}" 
                                                    name="fecha_nacimiento" value="{{ $estudiante->user->fecha_nacimiento ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="direccion{{ $estudiante->id }}" class="col-form-label">
                                                <i class="fas fa-map-marker-alt"></i> Dirección
                                            </label>
                                            <textarea class="form-control" id="direccion{{ $estudiante->id }}" 
                                                    name="direccion" rows="2" placeholder="Dirección completa del estudiante">{{ $estudiante->user->direccion ?? '' }}</textarea>
                                        </div>

                                        <div class="alert alert-warning mt-2">
                                            <i class="fas fa-exclamation-triangle"></i> Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save"></i> Actualizar Estudiante
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este estudiante?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stop