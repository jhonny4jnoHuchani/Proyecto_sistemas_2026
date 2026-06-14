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

                    {{-- ===== Grado y Paralelo ===== --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-school"></i> Grado <span class="text-danger">*</span></label>
                            <select id="grado_select_crear" class="form-select">
                                <option value="">Seleccione grado</option>
                                @for($g = 1; $g <= 6; $g++)
                                    <option value="{{ $g }}" {{ old('grado_select') == $g ? 'selected' : '' }}>{{ $g }}°</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-users"></i> Paralelo <span class="text-danger">*</span></label>
                            <select name="id_curso" id="paralelo_select_crear" class="form-select @error('id_curso') is-invalid @enderror">
                                <option value="">Seleccione un grado primero</option>
                            </select>
                            @error('id_curso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                <th>Curso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $estudiante)
            <tr>
                <td>{{ $estudiante->nombre ?? 'N/A' }}</td>
                <td>{{ $estudiante->apellido ?? 'N/A' }}</td>
                <td>{{ $estudiante->ci ?? 'N/A' }}</td>
                <td>{{ $estudiante->telefono ?? 'N/A' }}</td>
                <td>{{ $estudiante->direccion ?? 'N/A' }}</td>
                <td>{{ $estudiante->fecha_nacimiento ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $estudiante->rude ?? 'N/A' }}</td>
                <td>
                    @if($estudiante->inscripcionActiva && $estudiante->inscripcionActiva->curso)
                        {{ $estudiante->inscripcionActiva->curso->grado }}°
                        "{{ $estudiante->inscripcionActiva->curso->paralelo }}"
                    @else
                        <span class="text-muted">Sin curso</span>
                    @endif
                </td>
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
                                                    value="{{ old('nombre', $estudiante->nombre ?? '') }}">
                                                @error('nombre')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-user"></i> Apellido <span class="text-danger">*</span></label>
                                                <input type="text" name="apellido"
                                                    class="form-control @error('apellido') is-invalid @enderror"
                                                    value="{{ old('apellido', $estudiante->apellido ?? '') }}">
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
                                                    value="{{ old('ci', $estudiante->ci ?? '') }}">
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
                                                    value="{{ old('celular', $estudiante->telefono ?? '') }}" pattern="[0-9]{8}">
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
                                                    <option value="Masculino" {{ old('genero', $estudiante->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Femenino"  {{ old('genero', $estudiante->genero ?? '') == 'Femenino'  ? 'selected' : '' }}>Femenino</option>
                                                    <option value="Otro"      {{ old('genero', $estudiante->genero ?? '') == 'Otro'      ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                @error('genero')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                                                <input type="date" name="fecha_nacimiento"
                                                    class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                    value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '') }}">
                                                @error('fecha_nacimiento')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                                            <textarea name="direccion" rows="2"
                                                class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $estudiante->direccion ?? '') }}</textarea>
                                            @error('direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- ===== Grado y Paralelo ===== --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-school"></i> Grado <span class="text-danger">*</span></label>
                                                <select class="form-select grado_select_editar"
                                                    data-estudiante="{{ $estudiante->id }}"
                                                    data-curso-actual="{{ $estudiante->inscripcionActiva->id_curso ?? '' }}">
                                                    <option value="">Seleccione grado</option>
                                                    @for($g = 1; $g <= 6; $g++)
                                                        <option value="{{ $g }}"
                                                            {{ ($estudiante->inscripcionActiva->curso->grado ?? null) == $g ? 'selected' : '' }}>
                                                            {{ $g }}°
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label"><i class="fas fa-users"></i> Paralelo <span class="text-danger">*</span></label>
                                                <select name="id_curso"
                                                    class="form-select paralelo_select_editar @error('id_curso') is-invalid @enderror"
                                                    data-estudiante="{{ $estudiante->id }}">
                                                    <option value="">Seleccione un grado primero</option>
                                                </select>
                                                @error('id_curso')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
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
    // Datos de cursos enviados desde el controlador: [{id, grado, paralelo, ...}, ...]
    const cursos = @json($cursos);

    function llenarParalelos(gradoSeleccionado, paraleloSelect, valorPreseleccionado = null) {
        paraleloSelect.innerHTML = '';

        if (!gradoSeleccionado) {
            paraleloSelect.innerHTML = '<option value="">Seleccione un grado primero</option>';
            return;
        }

        const filtrados = cursos.filter(c => c.grado == gradoSeleccionado);

        if (filtrados.length === 0) {
            paraleloSelect.innerHTML = '<option value="">No hay paralelos para este grado</option>';
            return;
        }

        paraleloSelect.innerHTML = '<option value="">Seleccione un paralelo</option>';

        filtrados.forEach(c => {
            const option = document.createElement('option');
            option.value = c.id;
            option.textContent = c.paralelo;
            if (valorPreseleccionado && c.id == valorPreseleccionado) {
                option.selected = true;
            }
            paraleloSelect.appendChild(option);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {

        // ===== Modal CREAR =====
        const gradoCrear = document.getElementById('grado_select_crear');
        const paraleloCrear = document.getElementById('paralelo_select_crear');

        gradoCrear.addEventListener('change', function () {
            llenarParalelos(this.value, paraleloCrear);
        });

        // Si vino con old('grado_select') por error de validación, dispara el cambio
        if (gradoCrear.value) {
            llenarParalelos(gradoCrear.value, paraleloCrear, '{{ old('id_curso') }}');
        }

        // ===== Modales EDITAR (uno por estudiante) =====
        document.querySelectorAll('.grado_select_editar').forEach(function (gradoSelect) {
            const idEstudiante = gradoSelect.dataset.estudiante;
            const cursoActual = gradoSelect.dataset.cursoActual;
            const paraleloSelect = document.querySelector(
                '.paralelo_select_editar[data-estudiante="' + idEstudiante + '"]'
            );

            // Llenado inicial con el curso actual preseleccionado
            if (gradoSelect.value) {
                llenarParalelos(gradoSelect.value, paraleloSelect, cursoActual);
            }

            gradoSelect.addEventListener('change', function () {
                llenarParalelos(this.value, paraleloSelect);
            });
        });

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