@extends('adminlte::page')

@section('title', 'Mi Panel')

@section('content_header')
    <h1 class="font-weight-bold">¡Hola, {{ $estudiante->nombre }}! 👋</h1>
    <p class="text-muted">Bienvenido a tu portal estudiantil</p>
@stop

@section('content')
    @if(!$inscripcion)
        <div class="alert alert-warning">
            <i class="fas fa-info-circle"></i> Actualmente no tienes una inscripción activa.
        </div>
    @else
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $inscripcion->curso->grado }}° "{{ $inscripcion->curso->paralelo }}"</h3>
                        <p>Turno {{ ucfirst($inscripcion->curso->turno) }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-school"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $inscripcion->gestion->anio }}</h3>
                        <p>Gestión Académica Activa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline card-primary mt-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chalkboard-teacher mr-2"></i> Mis Docentes Asignados</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Materia</th>
                                <th>Docente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($misDocentes as $asignacion)
                                <tr>
                                    <td class="font-weight-bold align-middle">
                                        <i class="fas fa-book text-primary mr-2"></i> {{ $asignacion->materia->nombre }}
                                    </td>
                                    <td class="align-middle">
                                        Prof. {{ $asignacion->docente->nombre }} {{ $asignacion->docente->apellido }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Aún no tienes docentes asignados para este curso.
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