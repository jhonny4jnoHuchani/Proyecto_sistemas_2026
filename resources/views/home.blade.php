@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Control Principal</h1>
@stop

@section('content')
    <p>Bienvenido a este hermoso panel de administración.</p>
    <div class="row mt-4">
        <!-- Card de Cursos -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Cursos</h3>
                    <p>Gestionar paralelos y turnos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <a href="{{ route('cursos.index') }}" class="small-box-footer">
                    Ingresar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>Materias</h3>
                    <p>Gestionar áreas y carga horaria</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('materias.index') }}" class="small-box-footer">
                    Ingresar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Trimestres</h3>
                    <p>Control de Periodos y Notas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ route('trimestres.index') }}" class="small-box-footer">
                    Configurar Fechas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <!-- Card de Docentes -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Docentes</h3>
                    <p>Gestionar docentes registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="{{ route('docentes.index') }}" class="small-box-footer">
                    Ingresar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>Carga</h3>
                    <p>Asignaciones Académicas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="{{ route('asignaciones.index') }}" class="small-box-footer">
                    Configurar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-danger"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{-- Modal advertencia gestión --}}
    @if (!$gestionActiva)
        <div class="modal fade" id="modalSinGestion" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-dark font-weight-bold">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gestión no iniciada
                        </h5>
                    </div>

                    <div class="modal-body text-center py-4">
                        <i class="fas fa-calendar-times fa-4x text-warning mb-3"></i>
                        <p class="mb-1">No existe una gestión activa para el año</p>
                        <h2 class="font-weight-bold">{{ now()->year }}</h2>
                        <p class="text-muted small mt-2">
                            Debes iniciar la gestión académica antes de operar el sistema.
                        </p>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <a href="{{ route('gestiones.index') }}" class="btn btn-warning">
                            <i class="fas fa-play-circle mr-1"></i>
                            Iniciar gestión {{ now()->year }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endif

@stop

@section('js')
    <script>
        console.log("Panel principal cargado correctamente.");

        @if (!$gestionActiva)
            setTimeout(function() {
                $('#modalSinGestion').modal('show');
            }, 500);
        @endif
    </script>
@stop
