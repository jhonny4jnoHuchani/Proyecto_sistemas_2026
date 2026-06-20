@extends('adminlte::page')

@section('title', 'Mis Notas')

@section('content_header')
    <h1><i class="fas fa-user-graduate"></i> Mi Boletín de Calificaciones</h1>
@stop

@section('content')
    @if(!$inscripcion)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Actualmente no cuentas con una inscripción activa para esta gestión. Si crees que es un error, comunícate con Dirección.
        </div>
    @else
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chalkboard"></i> 
                    Curso: <strong>{{ $inscripcion->curso->grado }}° "{{ $inscripcion->curso->paralelo }}" - {{ ucfirst($inscripcion->curso->turno) }}</strong>
                </h3>
                <div class="card-tools">
                    <span class="badge badge-info text-md">Gestión {{ $inscripcion->gestion->anio }}</span>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Materia</th>
                                <th class="text-center">1er Trimestre</th>
                                <th class="text-center">2do Trimestre</th>
                                <th class="text-center">3er Trimestre</th>
                                <th class="text-center">Promedio Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($boletin as $materia => $notasTrimestre)
                                @php
                                    $nota1 = $notasTrimestre['1er Trimestre'] ?? 0;
                                    $nota2 = $notasTrimestre['2do Trimestre'] ?? 0;
                                    $nota3 = $notasTrimestre['3er Trimestre'] ?? 0;
                                    
                                    // Cálculo de promedio (ajusta la lógica si el colegio evalúa diferente)
                                    $promedio = round(($nota1 + $nota2 + $nota3) / 3);
                                @endphp
                                <tr>
                                    <td class="font-weight-bold">{{ $materia }}</td>
                                    <td class="text-center">{{ $nota1 > 0 ? $nota1 : '—' }}</td>
                                    <td class="text-center">{{ $nota2 > 0 ? $nota2 : '—' }}</td>
                                    <td class="text-center">{{ $nota3 > 0 ? $nota3 : '—' }}</td>
                                    <td class="text-center font-weight-bold {{ $promedio >= 51 ? 'text-success' : 'text-danger' }}">
                                        {{ $promedio > 0 ? $promedio : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Tus docentes aún no han cargado calificaciones.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@stop