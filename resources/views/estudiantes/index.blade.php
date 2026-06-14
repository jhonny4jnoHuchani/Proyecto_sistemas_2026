@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')
    <h1>Lista de Estudiantes</h1>
@stop

@section('content')

{{-- Alertas (solo para errores no-AJAX) --}}
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

{{-- ══════════════════════════════════════════
     FILTRO POR GRADO Y PARALELO
══════════════════════════════════════════ --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label mb-1 small fw-bold">
                    <i class="fas fa-filter text-primary"></i> Filtrar por:
                </label>
            </div>
            <div class="col-md-2">
                <select id="filtroGrado" class="form-select form-select-sm">
                    <option value="">Todos los grados</option>
                    @for($g = 1; $g <= 6; $g++)
                        <option value="{{ $g }}">{{ $g }}°</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select id="filtroParalelo" class="form-select form-select-sm">
                    <option value="">Todos los paralelos</option>
                </select>
            </div>
            <div class="col-auto">
                <button id="btnLimpiarFiltro" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
            <div class="col-auto ms-auto">
                <span class="badge bg-secondary" id="contadorEstudiantes">
                    {{ $estudiantes->count() }} estudiante(s)
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL CREAR (con AJAX)
══════════════════════════════════════════ --}}
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-graduate"></i> Registrar Nuevo Estudiante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCrearEstudiante">
                @csrf
                <div class="modal-body">

                    {{-- Alerta de errores AJAX --}}
                    <div id="ajaxErrors" class="alert alert-danger d-none">
                        <ul id="ajaxErrorList" class="mb-0 ps-3"></ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-user"></i> Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="crear_nombre" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-user"></i> Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido" id="crear_apellido" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label"><i class="fas fa-id-card"></i> CI <span class="text-danger">*</span></label>
                            <input type="text" name="ci" id="crear_ci" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label"><i class="fas fa-qrcode"></i> RUDE</label>
                            <input type="text" name="rude" id="crear_rude" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label"><i class="fas fa-phone"></i> Celular</label>
                            <input type="tel" name="celular" id="crear_celular" class="form-control" pattern="[0-9]{8}">
                            <div class="invalid-feedback"></div>
                            <small class="text-muted">Formato: 8 dígitos</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-venus-mars"></i> Género <span class="text-danger">*</span></label>
                            <select name="genero" id="crear_genero" class="form-select">
                                <option value="">Seleccione género</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="crear_fecha_nacimiento" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                        <textarea name="direccion" id="crear_direccion" rows="2" class="form-control"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-school"></i> Grado <span class="text-danger">*</span></label>
                            <select id="grado_select_crear" class="form-select">
                                <option value="">Seleccione grado</option>
                                @for($g = 1; $g <= 6; $g++)
                                    <option value="{{ $g }}">{{ $g }}°</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"><i class="fas fa-users"></i> Paralelo <span class="text-danger">*</span></label>
                            <select name="id_curso" id="paralelo_select_crear" class="form-select">
                                <option value="">Seleccione un grado primero</option>
                            </select>
                            <div class="invalid-feedback" id="id_curso_error"></div>
                        </div>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger">*</span> son obligatorios.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" id="btnGuardarEstudiante" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Estudiante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL ¿IMPRIMIR PDF?
══════════════════════════════════════════ --}}
<div class="modal fade" id="modalPdf" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center px-4 pb-2">
                <div class="mb-3">
                    <span style="font-size:56px;">🎉</span>
                </div>
                <h5 class="fw-bold text-success mb-1">¡Estudiante registrado!</h5>
                <p class="text-muted mb-1" id="pdfNombreEstudiante"></p>
                <p class="mb-4">¿Deseas imprimir la ficha de inscripción en PDF?</p>
                <div class="d-grid gap-2">
                    <a href="#" id="btnAbrirPdf" target="_blank" class="btn btn-success btn-lg">
                        <i class="fas fa-file-pdf"></i> Sí, imprimir PDF
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="btnOmitirPdf">
                        Omitir por ahora
                    </button>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                <small class="text-muted">La página se actualizará al cerrar este aviso</small>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     TABLA
══════════════════════════════════════════ --}}
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="tablaEstudiantes">
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
        <tbody id="tablaBody">
            @foreach ($estudiantes as $estudiante)
            <tr
                data-grado="{{ $estudiante->inscripcionActiva->curso->grado ?? '' }}"
                data-paralelo="{{ $estudiante->inscripcionActiva->curso->paralelo ?? '' }}"
                data-curso-id="{{ $estudiante->inscripcionActiva->id_curso ?? '' }}"
            >
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
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        data-bs-target="#modalEditar{{ $estudiante->id }}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#modalEliminar{{ $estudiante->id }}">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>

                    {{-- MODAL EDITAR (sin cambios, igual que antes) --}}
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
                                                <label class="col-form-label">Nombre <span class="text-danger">*</span></label>
                                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                                    value="{{ old('nombre', $estudiante->nombre ?? '') }}">
                                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Apellido <span class="text-danger">*</span></label>
                                                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                                                    value="{{ old('apellido', $estudiante->apellido ?? '') }}">
                                                @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label">CI <span class="text-danger">*</span></label>
                                                <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror"
                                                    value="{{ old('ci', $estudiante->ci ?? '') }}">
                                                @error('ci') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label">RUDE</label>
                                                <input type="text" name="rude" class="form-control @error('rude') is-invalid @enderror"
                                                    value="{{ old('rude', $estudiante->rude ?? '') }}">
                                                @error('rude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label">Celular</label>
                                                <input type="tel" name="celular" class="form-control @error('celular') is-invalid @enderror"
                                                    value="{{ old('celular', $estudiante->telefono ?? '') }}" pattern="[0-9]{8}">
                                                @error('celular') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                <small class="text-muted">Formato: 8 dígitos</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Género <span class="text-danger">*</span></label>
                                                <select name="genero" class="form-select @error('genero') is-invalid @enderror">
                                                    <option value="">Seleccione género</option>
                                                    <option value="Masculino" {{ old('genero', $estudiante->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Femenino"  {{ old('genero', $estudiante->genero ?? '') == 'Femenino'  ? 'selected' : '' }}>Femenino</option>
                                                    <option value="Otro"      {{ old('genero', $estudiante->genero ?? '') == 'Otro'      ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                @error('genero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Fecha de Nacimiento</label>
                                                <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                    value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '') }}">
                                                @error('fecha_nacimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label">Dirección</label>
                                            <textarea name="direccion" rows="2" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $estudiante->direccion ?? '') }}</textarea>
                                            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Grado <span class="text-danger">*</span></label>
                                                <select class="form-select grado_select_editar"
                                                    data-estudiante="{{ $estudiante->id }}"
                                                    data-curso-actual="{{ $estudiante->inscripcionActiva->id_curso ?? '' }}">
                                                    <option value="">Seleccione grado</option>
                                                    @for($g = 1; $g <= 6; $g++)
                                                        <option value="{{ $g }}" {{ ($estudiante->inscripcionActiva->curso->grado ?? null) == $g ? 'selected' : '' }}>{{ $g }}°</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Paralelo <span class="text-danger">*</span></label>
                                                <select name="id_curso" class="form-select paralelo_select_editar @error('id_curso') is-invalid @enderror"
                                                    data-estudiante="{{ $estudiante->id }}">
                                                    <option value="">Seleccione un grado primero</option>
                                                </select>
                                                @error('id_curso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-exclamation-triangle"></i> Los campos con <span class="text-danger">*</span> son obligatorios.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL ELIMINAR --}}
                    <div class="modal fade" id="modalEliminar{{ $estudiante->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                    <p>¿Eliminar a <strong>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</strong>?</p>
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
const cursos = @json($cursos);
const routePdf = "{{ route('estudiantes.pdf', ['id' => '__ID__']) }}";

// ═══════════════════════════════════════════
// Helpers de paralelos
// ═══════════════════════════════════════════
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
        const opt = document.createElement('option');
        opt.value = c.id;
        opt.textContent = c.paralelo;
        if (valorPreseleccionado && c.id == valorPreseleccionado) opt.selected = true;
        paraleloSelect.appendChild(opt);
    });
}

// ═══════════════════════════════════════════
// Helpers de validación visual
// ═══════════════════════════════════════════
function limpiarErroresAjax() {
    document.querySelectorAll('#formCrearEstudiante .is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('#formCrearEstudiante .invalid-feedback').forEach(el => el.textContent = '');
    document.getElementById('ajaxErrors').classList.add('d-none');
    document.getElementById('ajaxErrorList').innerHTML = '';
}

function mostrarErroresAjax(errors) {
    const errorBox  = document.getElementById('ajaxErrors');
    const errorList = document.getElementById('ajaxErrorList');
    errorList.innerHTML = '';

    Object.entries(errors).forEach(([campo, mensajes]) => {
        // Marcar el input con is-invalid
        const input = document.querySelector(`#formCrearEstudiante [name="${campo}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.closest('.col-md-6, .col-md-4, .mb-3')?.querySelector('.invalid-feedback');
            if (feedback) feedback.textContent = mensajes[0];
        }
        // También en id_curso
        if (campo === 'id_curso') {
            const sel = document.getElementById('paralelo_select_crear');
            sel?.classList.add('is-invalid');
            document.getElementById('id_curso_error').textContent = mensajes[0];
        }
        mensajes.forEach(msg => {
            const li = document.createElement('li');
            li.textContent = msg;
            errorList.appendChild(li);
        });
    });

    errorBox.classList.remove('d-none');
    errorBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function resetFormCrear() {
    const form = document.getElementById('formCrearEstudiante');
    form.reset();
    document.getElementById('grado_select_crear').value = '';
    document.getElementById('paralelo_select_crear').innerHTML = '<option value="">Seleccione un grado primero</option>';
    limpiarErroresAjax();
}

// ═══════════════════════════════════════════
// FILTRO POR GRADO / PARALELO
// ═══════════════════════════════════════════
function aplicarFiltro() {
    const grado    = document.getElementById('filtroGrado').value;
    const paralelo = document.getElementById('filtroParalelo').value;
    const filas    = document.querySelectorAll('#tablaBody tr');
    let visibles   = 0;

    filas.forEach(fila => {
        const filaGrado    = fila.dataset.grado;
        const filaParalelo = fila.dataset.paralelo;

        const passGrado    = !grado    || filaGrado == grado;
        const passParalelo = !paralelo || filaParalelo === paralelo;

        if (passGrado && passParalelo) {
            fila.style.display = '';
            visibles++;
        } else {
            fila.style.display = 'none';
        }
    });

    document.getElementById('contadorEstudiantes').textContent = visibles + ' estudiante(s)';
}

function llenarFiltroParalelos(grado) {
    const sel = document.getElementById('filtroParalelo');
    sel.innerHTML = '<option value="">Todos los paralelos</option>';
    if (!grado) return;

    const filtrados = cursos.filter(c => c.grado == grado);
    filtrados.forEach(c => {
        const opt = document.createElement('option');
        opt.value = c.paralelo;
        opt.textContent = c.paralelo;
        sel.appendChild(opt);
    });
}

// ═══════════════════════════════════════════
// DOMContentLoaded
// ═══════════════════════════════════════════
document.addEventListener('DOMContentLoaded', function () {

    // ── Modal Crear: paralelos dinámicos ──
    const gradoCrear    = document.getElementById('grado_select_crear');
    const paraleloCrear = document.getElementById('paralelo_select_crear');
    gradoCrear.addEventListener('change', function () {
        llenarParalelos(this.value, paraleloCrear);
    });

    // Limpiar al cerrar el modal crear
    document.getElementById('modalCrear').addEventListener('hidden.bs.modal', function () {
        resetFormCrear();
    });

    // ── AJAX: envío del formulario ──
    document.getElementById('formCrearEstudiante').addEventListener('submit', function (e) {
        e.preventDefault();
        limpiarErroresAjax();

        const btn = document.getElementById('btnGuardarEstudiante');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Guardando...';

        const formData = new FormData(this);

        fetch("{{ route('estudiantes.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            if (status === 422) {
                mostrarErroresAjax(data.errors);
                return;
            }
            if (data.ok) {
                // Ocultar modal crear
                bootstrap.Modal.getInstance(document.getElementById('modalCrear')).hide();

                // Preparar modal PDF
                document.getElementById('pdfNombreEstudiante').textContent =
                    'Estudiante: ' + data.estudiante.nombre;
                document.getElementById('btnAbrirPdf').href =
                    routePdf.replace('__ID__', data.estudiante.id);

                // Mostrar modal PDF
                new bootstrap.Modal(document.getElementById('modalPdf')).show();
            }
        })
        .catch(() => {
            alert('Ocurrió un error inesperado. Intente de nuevo.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Guardar Estudiante';
        });
    });

    // Recargar página al cerrar el modal PDF
    document.getElementById('modalPdf').addEventListener('hidden.bs.modal', function () {
        window.location.reload();
    });

    // ── Modales Editar: paralelos dinámicos ──
    document.querySelectorAll('.grado_select_editar').forEach(function (gradoSelect) {
        const id           = gradoSelect.dataset.estudiante;
        const cursoActual  = gradoSelect.dataset.cursoActual;
        const paraleloSel  = document.querySelector(`.paralelo_select_editar[data-estudiante="${id}"]`);

        if (gradoSelect.value) llenarParalelos(gradoSelect.value, paraleloSel, cursoActual);
        gradoSelect.addEventListener('change', function () {
            llenarParalelos(this.value, paraleloSel);
        });
    });

    // ── Filtro ──
    document.getElementById('filtroGrado').addEventListener('change', function () {
        llenarFiltroParalelos(this.value);
        document.getElementById('filtroParalelo').value = '';
        aplicarFiltro();
    });
    document.getElementById('filtroParalelo').addEventListener('change', aplicarFiltro);
    document.getElementById('btnLimpiarFiltro').addEventListener('click', function () {
        document.getElementById('filtroGrado').value    = '';
        document.getElementById('filtroParalelo').value = '';
        llenarFiltroParalelos('');
        aplicarFiltro();
    });

    // ── Temporizador modales eliminar ──
    @foreach ($estudiantes as $estudiante)
    (function() {
        const modal = document.getElementById('modalEliminar{{ $estudiante->id }}');
        let intervalo;

        modal.addEventListener('show.bs.modal', function () {
            let tiempo  = 5;
            const progress  = document.getElementById('progressBar{{ $estudiante->id }}');
            const timerText = document.getElementById('timerText{{ $estudiante->id }}');
            const btn       = document.getElementById('btnEliminar{{ $estudiante->id }}');

            progress.style.width = '0%';
            timerText.textContent = 'Espera 5 segundos';
            btn.disabled = true;

            if (intervalo) clearInterval(intervalo);
            intervalo = setInterval(function () {
                tiempo--;
                progress.style.width = ((5 - tiempo) / 5 * 100) + '%';
                timerText.textContent = `Espera ${tiempo} segundos`;
                if (tiempo <= 0) {
                    clearInterval(intervalo);
                    timerText.textContent = '✓ Ya puedes eliminar';
                    btn.disabled = false;
                }
            }, 1000);
        });
        modal.addEventListener('hidden.bs.modal', function () {
            if (intervalo) clearInterval(intervalo);
        });
    })();
    @endforeach

    // ── Auto cerrar alertas ──
    setTimeout(function () {
        document.querySelectorAll('.alert-dismissible').forEach(function (a) {
            bootstrap.Alert.getOrCreateInstance(a).close();
        });
    }, 5000);

    // ── Reabrir modal EDITAR si hubo errores de validación ──
    @if($errors->any() && old('_form') == 'editar')
        new bootstrap.Modal(document.getElementById('modalEditar{{ old("_form_id") }}')).show();
    @endif
});
</script>
@stop