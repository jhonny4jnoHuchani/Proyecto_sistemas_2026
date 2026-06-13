@extends('adminlte::page')
@section('title','Añadir Curso')

@section('content_header')
    <h1>Registrar Nuevo Curso</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6"> 
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos del Curso</h3>
                </div>
                
                <form action="{{ route('cursos.store') }}" method="POST">
                    
                    {{-- ¡ATENCIÓN A ESTA LÍNEA! Es vital en Laravel --}}
                    @csrf 

                    <div class="card-body">
                        
                        {{-- CAMBIADO: de nombre a grado --}}
                        <div class="form-group">
                            <label for="grado">Grado</label>
                            <select name="grado" class="form-control" id="grado" required>
                                <option value="">Seleccione un grado...</option>
                                <option value="1">1ro</option>
                                <option value="2">2do</option>
                                <option value="3">3ro</option>
                                <option value="4">4to</option>
                                <option value="5">5to</option>
                                <option value="6">6to</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="paralelo">Paralelo</label>
                            <input type="text" name="paralelo" class="form-control" id="paralelo" placeholder="Ej: A, B, C" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="turno">Turno</label>
                            <select name="turno" class="form-control" id="turno" required>
                                <option value="">Seleccione un turno...</option>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Curso</button>
                        <a href="{{ route('cursos.index') }}" class="btn btn-default float-right">Cancelar</a>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
@stop