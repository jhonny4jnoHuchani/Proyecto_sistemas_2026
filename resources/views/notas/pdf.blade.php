<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planilla de Notas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; font-size: 18px; text-transform: uppercase; }
        .header h3 { margin: 5px 0 0 0; padding: 0; font-size: 15px; color: #555; }
        .info-table { width: 100%; margin-bottom: 20px; font-size: 14px; }
        .info-table td { padding: 4px; }
        .grades-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .grades-table th, .grades-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .grades-table th { background-color: #e9ecef; font-weight: bold; }
        .text-left { text-align: left !important; }
        .footer-firmas { width: 100%; margin-top: 80px; text-align: center; }
        .footer-firmas td { width: 50%; padding-top: 50px; }
        .linea-firma { border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Unidad Educativa Union Europea</h2>
        <h3>Planilla Oficial de Calificaciones - Trimestre: {{ $trimestre->nombre }}</h3>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Docente:</strong> {{ $asignacion->docente->nombre }} {{ $asignacion->docente->apellido }}</td>
            <td><strong>Gestión:</strong> {{ $gestion->anio }}</td>
        </tr>
        <tr>
            <td><strong>Materia:</strong> {{ $asignacion->materia->nombre }}</td>
            <td><strong>Curso:</strong> {{ $curso->grado }}° "{{ $curso->paralelo }}" - {{ ucfirst($curso->turno) }}</td>
        </tr>
    </table>

    <table class="grades-table">
        <thead>
            <tr>
                <th width="5%">N°</th>
                <th class="text-left" width="55%">Apellidos y Nombres</th>
                <th width="20%">C.I.</th>
                <th width="20%">Nota Final</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscripciones as $i => $inscripcion)
                @php
                    $notaValor = $notasExistentes[$inscripcion->id_inscripcion] ?? '—';
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-left">{{ strtoupper($inscripcion->estudiante->apellido) }}, {{ $inscripcion->estudiante->nombre }}</td>
                    <td>{{ $inscripcion->estudiante->ci }}</td>
                    <td><strong>{{ $notaValor }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay estudiantes inscritos en este curso.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer-firmas">
        <tr>
            <td>
                <div class="linea-firma">
                    <strong>Firma del Docente</strong><br>
                    {{ $asignacion->docente->nombre }} {{ $asignacion->docente->apellido }}
                </div>
            </td>
            <td>
                <div class="linea-firma">
                    <strong>Sello de Dirección</strong>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>