<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Inscripción</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── Encabezado ── */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            color: #fff;
            padding: 24px 30px 20px;
            position: relative;
            overflow: hidden;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, #e94560, #0f3460, #533483);
        }
        .header-grid {
            display: table;
            width: 100%;
        }
        .header-logo {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
        }
        .logo-circle {
            width: 58px; height: 58px;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            border: 2px solid rgba(255,255,255,.4);
            text-align: center;
            line-height: 58px;
            font-size: 26px;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 14px;
        }
        .header-text h1 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 3px;
        }
        .header-text p {
            font-size: 11px;
            opacity: .75;
        }
        .header-badge {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            white-space: nowrap;
        }
        .badge-box {
            display: inline-block;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 8px;
            padding: 8px 14px;
            text-align: center;
        }
        .badge-box .label { font-size: 9px; opacity: .7; text-transform: uppercase; letter-spacing: 1px; }
        .badge-box .value { font-size: 20px; font-weight: 700; color: #e94560; margin-top: 2px; }

        /* ── Cuerpo ── */
        .body { padding: 24px 30px; }

        /* Sección título */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #0f3460;
            border-left: 4px solid #e94560;
            padding-left: 10px;
            margin-bottom: 12px;
            margin-top: 20px;
        }

        /* Grid de datos */
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row { display: table-row; }
        .info-cell {
            display: table-cell;
            padding: 7px 10px;
            border: 1px solid #e8ecf0;
            vertical-align: top;
            width: 25%;
        }
        .info-cell:nth-child(odd) { background: #f8fafc; }
        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #6b7280;
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 12px;
            font-weight: 600;
            color: #1a1a2e;
        }

        /* Pill de curso */
        .curso-pill {
            display: inline-block;
            background: linear-gradient(135deg, #0f3460, #533483);
            color: #fff;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 12px;
            font-weight: 700;
        }

        /* Tabla de materias */
        .materias-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .materias-table thead tr {
            background: linear-gradient(135deg, #0f3460, #533483);
            color: #fff;
        }
        .materias-table thead th {
            padding: 9px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 600;
            text-align: left;
        }
        .materias-table tbody tr:nth-child(even) { background: #f8fafc; }
        .materias-table tbody tr:hover { background: #eef2ff; }
        .materias-table tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid #e8ecf0;
            font-size: 11px;
        }
        .num-cell { color: #6b7280; font-size: 10px; width: 30px; text-align: center; }
        .docente-name { font-weight: 600; color: #0f3460; }
        .hora-badge {
            display: inline-block;
            background: #e0e7ff;
            color: #3730a3;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 600;
        }

        /* Sin asignaciones */
        .empty-msg {
            text-align: center;
            padding: 20px;
            color: #9ca3af;
            font-style: italic;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            border-radius: 6px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding: 16px 30px;
            background: #f8fafc;
            border-top: 2px solid #e8ecf0;
            display: table;
            width: 100%;
        }
        .footer-left  { display: table-cell; vertical-align: middle; font-size: 10px; color: #6b7280; }
        .footer-right { display: table-cell; vertical-align: middle; text-align: right; font-size: 10px; color: #9ca3af; }
        .firma-box {
            width: 180px;
            border-top: 1px solid #374151;
            margin-top: 40px;
            padding-top: 6px;
            text-align: center;
            font-size: 10px;
            color: #374151;
        }
    </style>
</head>
<body>

{{-- ══ ENCABEZADO ══ --}}
<div class="header">
    <div class="header-grid">
        <div class="header-logo">
            <div class="logo-circle">🏫</div>
        </div>
        <div class="header-text">
            <h1>Ficha de Inscripción Estudiantil</h1>
            <p>Unidad Educativa &mdash; Sistema de Gestión Académica</p>
            <p style="margin-top:4px; opacity:.6;">
                Generado el {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}
            </p>
        </div>
        <div class="header-badge">
            <div class="badge-box">
                <div class="label">Gestión</div>
                <div class="value">{{ $inscripcion?->gestion?->anio ?? now()->year }}</div>
            </div>
        </div>
    </div>
</div>

<div class="body">

    {{-- ══ DATOS PERSONALES ══ --}}
    <div class="section-title">📋 Datos Personales</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">Nombre completo</div>
                <div class="info-value">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Cédula de Identidad</div>
                <div class="info-value">{{ $estudiante->ci ?? '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Género</div>
                <div class="info-value">{{ $estudiante->genero ?? '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Fecha de Nacimiento</div>
                <div class="info-value">
                    {{ $estudiante->fecha_nacimiento
                        ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->isoFormat('D MMM YYYY')
                        : '—' }}
                </div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">RUDE</div>
                <div class="info-value">{{ $estudiante->rude ?? '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Celular</div>
                <div class="info-value">{{ $estudiante->telefono ?? '—' }}</div>
            </div>
            <div class="info-cell" style="width:50%">
                <div class="info-label">Dirección</div>
                <div class="info-value">{{ $estudiante->direccion ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- ══ DATOS DE INSCRIPCIÓN ══ --}}
    <div class="section-title">📌 Datos de Inscripción</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">Curso asignado</div>
                <div class="info-value">
                    @if($curso)
                        <span class="curso-pill">{{ $curso->grado }}° "{{ $curso->paralelo }}"</span>
                    @else
                        —
                    @endif
                </div>
            </div>
            <div class="info-cell">
                <div class="info-label">Turno</div>
                <div class="info-value">{{ $curso?->turno ?? '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Fecha de Inscripción</div>
                <div class="info-value">
                    {{ $inscripcion?->fecha_inscripcion
                        ? \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->isoFormat('D MMM YYYY')
                        : '—' }}
                </div>
            </div>
            <div class="info-cell">
                <div class="info-label">Estado</div>
                <div class="info-value" style="color:#16a34a;">
                    {{ $inscripcion?->estado ? '✓ Activo' : '✗ Inactivo' }}
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MATERIAS Y DOCENTES ══ --}}
    <div class="section-title">📚 Materias y Docentes Asignados</div>

    @if($asignaciones->count() > 0)
        <table class="materias-table">
            <thead>
                <tr>
                    <th style="width:30px;">#</th>
                    <th>Materia</th>
                    <th>Área</th>
                    <th>Carga Horaria</th>
                    <th>Docente Responsable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaciones as $i => $asignacion)
                <tr>
                    <td class="num-cell">{{ $i + 1 }}</td>
                    <td style="font-weight:600;">{{ $asignacion->materia?->nombre ?? '—' }}</td>
                    <td style="color:#6b7280;">{{ $asignacion->materia?->area ?? '—' }}</td>
                    <td>
                        @if($asignacion->materia?->carga_horaria)
                            <span class="hora-badge">{{ $asignacion->materia->carga_horaria }} hrs</span>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <span class="docente-name">
                            {{ $asignacion->docente?->nombre ?? '—' }}
                            {{ $asignacion->docente?->apellido ?? '' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-msg">
            No hay materias asignadas a este curso en la gestión actual.
        </div>
    @endif

    {{-- ══ FIRMA ══ --}}
    <div style="margin-top: 40px; text-align: right; padding-right: 30px;">
        <div class="firma-box" style="margin-left:auto;">
            Director/a de la Unidad Educativa
        </div>
    </div>

</div>

{{-- ══ FOOTER ══ --}}
<div class="footer">
    <div class="footer-left">
        <strong>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</strong>
        &nbsp;·&nbsp; CI: {{ $estudiante->ci }}
        &nbsp;·&nbsp; Gestión {{ $inscripcion?->gestion?->anio ?? now()->year }}
    </div>
    <div class="footer-right">
        Documento generado automáticamente &mdash; Sistema Académico
    </div>
</div>

</body>
</html>