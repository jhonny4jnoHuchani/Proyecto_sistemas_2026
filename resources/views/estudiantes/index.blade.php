@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')
    <h1>Lista de Estudiantes</h1>
@stop

@section('content')

{{-- Alertas --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Botón crear --}}
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
    <i class="fas fa-user-plus"></i> Crear Estudiante
</button>

{{-- ===================== MODAL CREAR ===================== --}}
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-graduate"></i> Registrar Nuevo Estudiante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_form" value="crear">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-user"></i> Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" 
                                class="form-control @error('nombre') is-invalid @enderror" 
                                value="{{ old('nombre') }}">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-user"></i> Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido" 
                                class="form-control @error('apellido') is-invalid @enderror" 
                                value="{{ old('apellido') }}">
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label"><i class="fas fa-id-card"></i> CI <span class="text-danger">*</span></label>
                            <input type="text" name="ci" 
                                class="form-control @error('ci') is-invalid @enderror" 
                                value="{{ old('ci') }}">
                            @error('ci')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label"><i class="fas fa-qrcode"></i> RUDE</label>
                            <input type="text" name="rude" 
                                class="form-control @error('rude') is-invalid @enderror" 
                                value="{{ old('rude') }}">
                            @error('rude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label"><i class="fas fa-phone"></i> Celular</label>
                            <input type="tel" name="celular" 
                                class="form-control @error('celular') is-invalid @enderror" 
                                value="{{ old('celular') }}" pattern="[0-9]{8}">
                            @error('celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formato: 8 dígitos</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-venus-mars"></i> Género <span class="text-danger">*</span></label>
                            <select name="genero" class="form-select @error('genero') is-invalid @enderror">
                                <option value="">Seleccione género</option>
                                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino"  {{ old('genero') == 'Femenino'  ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro"      {{ old('genero') == 'Otro'      ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" 
                                class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                value="{{ old('fecha_nacimiento') }}">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                        <textarea name="direccion" rows="2" 
                            class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger">*</span> son obligatorios.
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

{{-- ===================== TABLA ===================== --}}
<div class="table-responsive">
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
                <th>Acciones</th>
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
                    {{-- Botón Editar --}}
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                        data-bs-target="#modalEditar{{ $estudiante->id }}">
                        <i class="fas fa-edit"></i> Editar
                    </button>

                    {{-- Botón Eliminar --}}
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                        data-bs-target="#modalEliminar{{ $estudiante->id }}">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>

                    {{-- ===================== MODAL EDITAR ===================== --}}
                    <div class="modal fade" id="modalEditar{{ $estudiante->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title"><i class="fas fa-user-edit"></i> Editar Estudiante</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('estudiantes.actualizar', $estudiante->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_form" value="editar">
                                    <input type="hidden" name="_form_id" value="{{ $estudiante->id }}">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-user"></i> Nombre <span class="text-danger">*</span></label>
                                                <input type="text" name="nombre"
                                                    class="form-control @error('nombre') is-invalid @enderror"
                                                    value="{{ old('nombre', $estudiante->user->name ?? '') }}">
                                                @error('nombre')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-user"></i> Apellido <span class="text-danger">*</span></label>
                                                <input type="text" name="apellido"
                                                    class="form-control @error('apellido') is-invalid @enderror"
                                                    value="{{ old('apellido', $estudiante->user->apellido ?? '') }}">
                                                @error('apellido')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label"><i class="fas fa-id-card"></i> CI <span class="text-danger">*</span></label>
                                                <input type="text" name="ci"
                                                    class="form-control @error('ci') is-invalid @enderror"
                                                    value="{{ old('ci', $estudiante->user->ci ?? '') }}">
                                                @error('ci')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label"><i class="fas fa-qrcode"></i> RUDE</label>
                                                <input type="text" name="rude"
                                                    class="form-control @error('rude') is-invalid @enderror"
                                                    value="{{ old('rude', $estudiante->rude ?? '') }}">
                                                @error('rude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label"><i class="fas fa-phone"></i> Celular</label>
                                                <input type="tel" name="celular"
                                                    class="form-control @error('celular') is-invalid @enderror"
                                                    value="{{ old('celular', $estudiante->user->celular ?? '') }}" pattern="[0-9]{8}">
                                                @error('celular')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Formato: 8 dígitos</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-venus-mars"></i> Género <span class="text-danger">*</span></label>
                                                <select name="genero" class="form-select @error('genero') is-invalid @enderror">
                                                    <option value="">Seleccione género</option>
                                                    <option value="Masculino" {{ old('genero', $estudiante->user->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Femenino"  {{ old('genero', $estudiante->user->genero ?? '') == 'Femenino'  ? 'selected' : '' }}>Femenino</option>
                                                    <option value="Otro"      {{ old('genero', $estudiante->user->genero ?? '') == 'Otro'      ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                @error('genero')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                                                <input type="date" name="fecha_nacimiento"
                                                    class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                    value="{{ old('fecha_nacimiento', $estudiante->user->fecha_nacimiento ?? '') }}">
                                                @error('fecha_nacimiento')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                                            <textarea name="direccion" rows="2"
                                                class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $estudiante->user->direccion ?? '') }}</textarea>
                                            @error('direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Los campos con <span class="text-danger">*</span> son obligatorios.
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

                    {{-- ===================== MODAL ELIMINAR ===================== --}}
                    <div class="modal fade" id="modalEliminar{{ $estudiante->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                    <p>¿Eliminar a <strong>{{ $estudiante->user->name }} {{ $estudiante->user->apellido }}</strong>?</p>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div id="progressBar{{ $estudiante->id }}" class="progress-bar bg-danger" style="width: 0%"></div>
                                    </div>
                                    <small id="timerText{{ $estudiante->id }}" class="text-muted">Espera 5 segundos</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('estudiantes.eliminar', $estudiante->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="btnEliminar{{ $estudiante->id }}" class="btn btn-danger" disabled>Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop

@section('css')@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-cerrar alertas después de 5 segundos
        setTimeout(function () {
            document.querySelectorAll('.alert').forEach(function (alert) {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);

        // Reabrir modal CREAR si hubo errores de validación
        @if($errors->any() && old('_form') == 'crear')
            new bootstrap.Modal(document.getElementById('modalCrear')).show();
        @endif

        // Reabrir modal EDITAR si hubo errores de validación
        @if($errors->any() && old('_form') == 'editar')
            new bootstrap.Modal(document.getElementById('modalEditar{{ old("_form_id") }}')).show();
        @endif

        // Temporizador para modales de eliminar
        @foreach ($estudiantes as $estudiante)
            let modal{{ $estudiante->id }} = document.getElementById('modalEliminar{{ $estudiante->id }}');
            let tiempo{{ $estudiante->id }} = 5;
            let intervalo{{ $estudiante->id }};

            modal{{ $estudiante->id }}.addEventListener('show.bs.modal', function() {
                tiempo{{ $estudiante->id }} = 5;
                let progress = document.getElementById('progressBar{{ $estudiante->id }}');
                let timerText = document.getElementById('timerText{{ $estudiante->id }}');
                let btn = document.getElementById('btnEliminar{{ $estudiante->id }}');
                
                progress.style.width = '0%';
                timerText.textContent = 'Espera 5 segundos';
                btn.disabled = true;
                
                if (intervalo{{ $estudiante->id }}) clearInterval(intervalo{{ $estudiante->id }});
                
                intervalo{{ $estudiante->id }} = setInterval(function() {
                    tiempo{{ $estudiante->id }}--;
                    let porcentaje = ((5 - tiempo{{ $estudiante->id }}) / 5) * 100;
                    progress.style.width = porcentaje + '%';
                    timerText.textContent = `Espera ${tiempo{{ $estudiante->id }}} segundos`;
                    
                    if (tiempo{{ $estudiante->id }} <= 0) {
                        clearInterval(intervalo{{ $estudiante->id }});
                        timerText.textContent = '✓ Ya puedes eliminar';
                        btn.disabled = false;
                    }
                }, 1000);
            });
            
            modal{{ $estudiante->id }}.addEventListener('hidden.bs.modal', function() {
                if (intervalo{{ $estudiante->id }}) clearInterval(intervalo{{ $estudiante->id }});
            });
        @endforeach
    });
</script>
@stop