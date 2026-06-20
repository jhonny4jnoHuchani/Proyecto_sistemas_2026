<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletín - {{ $estudiante->apellido }} {{ $estudiante->nombre }}</title>
    <style>
        @page {
            size: landscape;
            margin: 15mm 12mm 30mm 12mm; /* margen inferior más grande para dejar sitio al pie de página */
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            font-size: 13px;
            color: #1a1a1a;
        }

        /* MARCO - borde decorativo fijo en cada página */
        .marco {
            position: fixed;
            top: -15mm;
            left: -12mm;
            right: -12mm;
            bottom: -30mm;
            border: 2px solid #333;
        }

        .escudo {
            text-align: center;
            margin-bottom: 5px;
        }
        .escudo h1 {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            color: #1a3c6e;
            border-bottom: 2px solid #c9a84c;
            display: inline-block;
            padding-bottom: 3px;
        }
        .boletin-titulo {
            background: #1a3c6e;
            color: #fff;
            text-align: center;
            padding: 6px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        /* DATOS DEL ALUMNO */
        .datos-alumno {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            background: #f5f5f5;
            font-size: 11px;
        }
        .datos-alumno td {
            padding: 6px 10px;
            vertical-align: top;
            border: none;
        }
        .dato {
            margin-bottom: 3px;
        }
        .dato strong {
            color: #1a3c6e;
        }

        /* TABLA DE NOTAS */
        table.notas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        thead th {
            background: #1a3c6e;
            color: white;
            padding: 6px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid #1a3c6e;
        }
        tbody td {
            padding: 5px 6px;
            text-align: center;
            border: 1px solid #ccc;
            font-size: 11px;
        }
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        .materia-nombre {
            text-align: left !important;
            font-weight: bold;
            padding-left: 8px !important;
        }
        .promedio-final {
            font-weight: bold;
            font-size: 12px;
        }
        .literal-final {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #1a3c6e;
        }
        .aprobado {
            color: #2d7a3e;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        .reprobado {
            color: #c0392b;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        /* PIE DE PÁGINA FIJO - firmas, se repite en cada página al fondo */
        .pie-firmas {
            position: fixed;
            bottom: -25mm;
            left: 0;
            right: 0;
            width: 100%;
        }
        table.firmas {
            width: 100%;
            border-collapse: collapse;
        }
        .firmas td {
            width: 25%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 10px;
            border: none;
        }
        .firma .linea {
            border-top: 1px solid #000;
            width: 90%;
            margin: 0 auto 6px auto;
        }
        .firma p {
            margin: 2px 0;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .firma small {
            font-size: 9px;
            color: #666;
        }
        .sello {
            border: 2px dashed #c9a84c;
            padding: 8px;
            text-align: center;
            font-size: 8px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 1px;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            margin: 0 auto;
            line-height: 12px;
        }
    </style>
</head>
<body>

    {{-- MARCO FIJO: se repite en cada página --}}
    <div class="marco"></div>

    {{-- PIE DE PÁGINA FIJO: firmas, se repiten en cada página --}}
    <div class="pie-firmas">
        <table class="firmas">
            <tr>
                <td class="firma">
                    <div class="linea"></div>
                    <p>Profesor Asesor</p>
                    <small>Curso {{ $inscripcion->curso->grado }}° "{{ $inscripcion->curso->paralelo }}"</small>
                </td>
                <td class="firma">
                    <div class="linea"></div>
                    <p>Director</p>
                    <small>U.E. "Nuevo Amanecer"</small>
                </td>
                <td class="firma">
                    <div class="sello">SELLO<br>DIRECCIÓN</div>
                </td>
                <td class="firma">
                    <div class="linea"></div>
                    <p>Secretaría</p>
                    <small>U.E. "Nuevo Amanecer"</small>
                </td>
            </tr>
        </table>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}

    {{-- ENCABEZADO --}}
    <div class="escudo">
        <h1>Unidad Educativa "Nuevo Amanecer"</h1>
    </div>

    <div class="boletin-titulo">
         BOLETÍN DE CALIFICACIONES
    </div>

    {{-- DATOS DEL ALUMNO --}}
    <table class="datos-alumno">
        <tr>
            <td style="width: 50%;">
                <div class="dato"><strong>Estudiante:</strong> {{ $estudiante->apellido }} {{ $estudiante->nombre }}</div>
                <div class="dato"><strong>R.U.D.E.:</strong> {{ $estudiante->rude }}</div>
                <div class="dato"><strong>C.I.:</strong> {{ $estudiante->ci }}</div>
            </td>
            <td style="width: 50%;">
                <div class="dato"><strong>Curso:</strong> {{ $inscripcion->curso->grado }}° "{{ $inscripcion->curso->paralelo }}"</div>
                <div class="dato"><strong>Turno:</strong> {{ ucfirst($inscripcion->curso->turno) }}</div>
                <div class="dato"><strong>Gestión:</strong> {{ $inscripcion->gestion->anio }}</div>
            </td>
        </tr>
    </table>

    {{-- TABLA DE NOTAS --}}
    <table class="notas">
        <thead>
            <tr>
                <th style="width: 24%;">Materia</th>
                <th style="width: 12%;">1er Trimestre</th>
                <th style="width: 12%;">2do Trimestre</th>
                <th style="width: 12%;">3er Trimestre</th>
                <th style="width: 10%;">Promedio</th>
                <th style="width: 15%;">Literal</th>
                <th style="width: 15%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($boletin as $materia => $notasTrimestre)
                @php
                    $n1 = $notasTrimestre['1er Trimestre'] ?? 0;
                    $n2 = $notasTrimestre['2do Trimestre'] ?? 0;
                    $n3 = $notasTrimestre['3er Trimestre'] ?? 0;
                    $promedio = round(($n1 + $n2 + $n3) / 3);
                    $literal = numToLetras($promedio);
                    $estado = $promedio >= 51 ? 'APROBADO' : 'REPROBADO';
                    $claseEstado = $promedio >= 51 ? 'aprobado' : 'reprobado';
                @endphp
                <tr>
                    <td class="materia-nombre">{{ $materia }}</td>
                    <td>{{ $n1 > 0 ? $n1 : '—' }}</td>
                    <td>{{ $n2 > 0 ? $n2 : '—' }}</td>
                    <td>{{ $n3 > 0 ? $n3 : '—' }}</td>
                    <td class="promedio-final">{{ $promedio > 0 ? $promedio : '—' }}</td>
                    <td class="literal-final">{{ $promedio > 0 ? $literal : '—' }}</td>
                    <td class="{{ $claseEstado }}">{{ $promedio > 0 ? $estado : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                        📭 Aún no se han registrado calificaciones.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>