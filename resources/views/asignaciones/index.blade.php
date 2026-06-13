@extends('adminlte::page')

@section('title', 'Asignaciones')

@section('content_header')
    <h1>Asignación de Materias por Grado</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($grados as $g)
            <div class="col-md-2">
                <a href="{{ route('asignaciones.paralelos', $g['numero']) }}" style="text-decoration:none;">
                    <div class="card card-outline card-primary text-center">
                        <div class="card-body">
                            <h3>{{ $g['numero'] }}°</h3>
                            <p class="text-muted mb-0">{{ $g['total_asignaciones'] }} asignaciones</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@stop