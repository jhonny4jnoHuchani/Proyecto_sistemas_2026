{{-- resources/views/notas/cargar.blade.php --}}
@extends('adminlte::page')

@section('title', 'Carga de Notas')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-0">Carga de Notas</h1>
            <small class="text-muted">
                {{ $curso->grado }}° {{ $curso->paralelo }} —
                {{ $asignacion->materia->nombre }} —
                {{ $trimestre->nombre }}
            </small>
        </div>
        {{-- Breadcrumb de regreso --}}
        <a href="{{ route('notas.trimestres', [$curso, $asignacion]) }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Cambiar trimestre
        </a>
    </div>
@stop

@section('content')

    {{-- Indicador global de estado --}}
    <div id="estado-global" class="alert alert-info d-none mb-3" role="alert">
        <i class="fas fa-spinner fa-spin mr-1"></i> Guardando...
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users mr-1"></i>
                Estudiantes inscritos —
                <span class="badge badge-primary">{{ $inscripciones->count() }}</span>
            </h3>
            <div class="card-tools">
                <span class="text-muted small">
                    <i class="fas fa-info-circle"></i>
                    La nota se guarda al salir del campo (Tab / Enter / clic fuera)
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0" id="tabla-notas">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Apellidos y Nombres</th>
                        <th width="110">C.I.</th>
                        <th width="150" class="text-center">Nota Final (0–100)</th>
                        <th width="80"  class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inscripciones as $i => $inscripcion)
                        @php
                            $notaValor = $notasExistentes[$inscripcion->id_inscripcion] ?? '';
                        @endphp
                        <tr id="fila-{{ $inscripcion->id_inscripcion }}">
                            <td class="text-muted align-middle">{{ $i + 1 }}</td>
                            <td class="align-middle font-weight-bold">
                                {{ strtoupper($inscripcion->estudiante->apellido) }},
                                {{ $inscripcion->estudiante->nombre }}
                            </td>
                            <td class="align-middle text-muted">
                                {{ $inscripcion->estudiante->ci }}
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"
                                    class="form-control form-control-sm text-center input-nota"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="—"
                                    value="{{ $notaValor }}"
                                    data-inscripcion="{{ $inscripcion->id_inscripcion }}"
                                    data-asignacion="{{ $asignacion->id }}"
                                    data-trimestre="{{ $trimestre->id }}"
                                    autocomplete="off"
                                    tabindex="{{ $i + 1 }}"
                                >
                            </td>
                            <td class="text-center align-middle">
                                @if ($notaValor !== '')
                                    <span class="badge badge-success icono-estado" id="estado-{{ $inscripcion->id_inscripcion }}">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @else
                                    <span class="badge badge-secondary icono-estado" id="estado-{{ $inscripcion->id_inscripcion }}">
                                        <i class="fas fa-minus"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-home mr-1"></i> Volver a cursos
            </a>
            
            <a href="{{ route('notas.pdf', [$curso, $asignacion, $trimestre]) }}" target="_blank" class="btn btn-danger">
                <i class="fas fa-file-pdf mr-1"></i> Exportar Planilla PDF
            </a>
        </div>
    </div>

@stop

@section('js')
<script>
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const URL_GUARDAR = "{{ route('notas.guardar') }}";

    // Cola para no disparar múltiples requests si el usuario escribe rápido
    let timers = {};

    document.querySelectorAll('.input-nota').forEach(function (input) {

        // Autoguardado al perder el foco (Tab, clic fuera)
        input.addEventListener('blur', function () {
            guardarNota(this);
        });

        // Autoguardado al presionar Enter — y pasa al siguiente input
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                guardarNota(this);
                // Mover foco al siguiente estudiante
                const siguiente = document.querySelector(
                    `.input-nota[tabindex="${parseInt(this.getAttribute('tabindex')) + 1}"]`
                );
                if (siguiente) siguiente.focus();
            }
        });

        // Validación visual en tiempo real (rojo si fuera de rango)
        input.addEventListener('input', function () {
            const val = parseFloat(this.value);
            if (this.value !== '' && (isNaN(val) || val < 0 || val > 100)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    function guardarNota(input) {
        const val = input.value.trim();

        // No guardar si está vacío o inválido
        if (val === '') return;
        const num = parseFloat(val);
        if (isNaN(num) || num < 0 || num > 100) return;

        const idInscripcion = input.dataset.inscripcion;
        const idAsignacion  = input.dataset.asignacion;
        const idTrimestre   = input.dataset.trimestre;
        const estadoEl      = document.getElementById('estado-' + idInscripcion);

        // Mostrar spinner en la fila
        estadoEl.className = 'badge badge-warning icono-estado';
        estadoEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // Mostrar indicador global
        const globalEl = document.getElementById('estado-global');
        globalEl.classList.remove('d-none', 'alert-success', 'alert-danger');
        globalEl.classList.add('alert-info');
        globalEl.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';

        fetch(URL_GUARDAR, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                id_inscripcion: idInscripcion,
                id_asignacion:  idAsignacion,
                id_trimestre:   idTrimestre,
                nota_final:     num,
            }),
        })
        .then(function (res) {
            if (!res.ok) throw new Error('Error HTTP ' + res.status);
            return res.json();
        })
        .then(function (data) {
            if (data.ok) {
                // Marcar fila como guardada (verde)
                estadoEl.className = 'badge badge-success icono-estado';
                estadoEl.innerHTML = '<i class="fas fa-check"></i>';

                // Indicador global de éxito (desaparece en 2 s)
                globalEl.classList.remove('alert-info', 'alert-danger');
                globalEl.classList.add('alert-success');
                globalEl.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Nota guardada';
                setTimeout(() => globalEl.classList.add('d-none'), 2000);
            }
        })
        .catch(function (err) {
            // Marcar fila como error (rojo)
            estadoEl.className = 'badge badge-danger icono-estado';
            estadoEl.innerHTML = '<i class="fas fa-times"></i>';

            globalEl.classList.remove('alert-info', 'alert-success');
            globalEl.classList.add('alert-danger');
            globalEl.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Error al guardar. Intente de nuevo.';

            console.error('Error guardando nota:', err);
        });
    }
</script>
@stop